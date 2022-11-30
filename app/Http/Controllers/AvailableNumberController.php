<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class AvailableNumberController extends Controller
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
     * Display numbers available for purchase. Fetched from the API
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
         
        $areaCode = $request->input('areaCode');
      
        $numbers = $this->_twilioClient->availablePhoneNumbers("US")
            ->local->stream(
                [
                    'areaCode' => $areaCode
                ]
            );
        return response()->view(
            'available_numbers.index',
            [
                'numbers' => $numbers,
                'areaCode' => $areaCode
            ]
        );
    }
}
