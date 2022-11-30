<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\LeadSource;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class LeadSourceController extends Controller
{

    /**
     * Twilio Client
     */
    protected $_twilioClient;

    public function __construct()
    {
         // Your Account SID and Auth Token from twilio.com/console
         $this->sid = getenv("TWILIO_ACCOUNT_SID");
         $this->token = getenv("TWILIO_AUTH_TOKEN");
         
         /** Initialize the Twilio client so it can be used */
         $this->_twilioClient = new Client($this->sid, $this->token);
       
    }

    /**
     * Store a new lead source (i.e phone number) and redirect to edit
     * page
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $appSid = $this->_appSid();

        $phoneNumber = $request->input('phoneNumber');

        $this->_twilioClient->incomingPhoneNumbers
            ->create(
                [
                    "phoneNumber" => $phoneNumber,
                    "voiceApplicationSid" => $appSid,
                    "voiceCallerIdLookup" => true
                ]
            );

        $leadSource = new LeadSource(
            [
                'number' => $phoneNumber
            ]
        );
        $leadSource->save();

        return redirect()->route('lead_source.edit', [$leadSource]);
    }

    /**
     * Show the form for editing a lead source
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $leadSourceToEdit = LeadSource::find($id);

        return response()->view(
            'lead_sources.edit',
            ['leadSource' => $leadSourceToEdit]
        );
    }

    /**
     * Update the lead source in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'forwarding_number' => 'required',
                'description' => 'required'
            ]
        );

        $leadSourceToUpdate = LeadSource::find($id);
        $leadSourceToUpdate->fill($request->all());
        $leadSourceToUpdate->save();

        return redirect()->route('dashboard');
    }

    /**
     * Remove the lead source from storage and release the number
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $leadSourceToDelete = LeadSource::find($id);
        $phoneToDelete = $this->_twilioClient->incomingPhoneNumbers
            ->read(
                [
                    "phoneNumber" => $leadSourceToDelete->number
                ]
            );

        if ($phoneToDelete) {
            $phoneToDelete[0]->delete();
        }
        $leadSourceToDelete->delete();

        return redirect()->route('dashboard');
    }

    /**
     * The Twilio TwiML App SID to use
     * @return string
     */
    private function _appSid()
    {
        $appSid = getenv("TWILIO_APP_SID");
        if (isset($appSid)) {
            return $appSid;
        }

        return $this->_findOrCreateCallTrackingApp();
    }

    private function _findOrCreateCallTrackingApp()
    {
        $existingApp = $this->_twilioClient->applications->read(
            array(
                "friendlyName" => 'Call tracking app'
            )
        );
        if ($existingApp) {
            return $existingApp[0]->sid;
        }

        $newApp = $this->_twilioClient->applications
            ->create('Call tracking app');

        return $newApp->sid;
    }
}
