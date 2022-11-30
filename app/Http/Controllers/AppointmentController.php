<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    private $appointment;
    private $validInputConditions = array(
        'name' => 'required',
        'phoneNumber' => 'required|min:5',
        'when' => 'required',
        'timezoneOffset' => 'required',
        'delta' => 'required|numeric'
    );

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allAppointments = Appointment::orderBy('id', 'ASC')->get();
        return response()->view('appointment.index', array('apts' => $allAppointments));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $appointment = new Appointment;
        return \View::make('appointment.create', array('appointment' => $appointment));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $newAppointment = $this->appointmentFromRequest($request);
        $newAppointment->save();
        return redirect()->route('appointment.index');
    }

    /**
     * Delete a resource in storage.
     *
     * @return Response
     */
    public function destroy($id)
    {
        Appointment::find($id)->delete();
        return redirect()->route('appointment.index');
    }

    public function edit($id)
    {
        $appointmentToEdit = Appointment::find($id);
        return \View::make('appointment.edit', array('appointment' => $appointmentToEdit));
    }

    public function update(Request $request, $id)
    {
        $updatedAppointment = $this->appointmentFromRequest($request);
        $existingAppointment = Appointment::find($id);

        $existingAppointment->name = $updatedAppointment->name;
        $existingAppointment->phoneNumber = $updatedAppointment->phoneNumber;
        $existingAppointment->timezoneOffset = $updatedAppointment->timezoneOffset;
        $existingAppointment->when = $updatedAppointment->when;
        $existingAppointment->notificationTime = $updatedAppointment->notificationTime;

        $existingAppointment->save();
        return redirect()->route('appointment.index');
    }

    private function appointmentFromRequest(Request $request)
    {
        $this->validate($request, $this->validInputConditions);
        $newAppointment = new Appointment;

        $newAppointment->name = $request->input('name');
        $newAppointment->phoneNumber = $request->input('phoneNumber');
        $newAppointment->timezoneOffset = $request->input('timezoneOffset');
        $newAppointment->when = $request->input('when');

        $notificationTime = Carbon::parse($request->input('when'))->subMinutes($request->delta);
        $newAppointment->notificationTime = $notificationTime;

        return $newAppointment;
    }
}
