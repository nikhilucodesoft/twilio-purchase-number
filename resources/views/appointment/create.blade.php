@extends('layouts.main')

@section('content')
    @include('appointment._form', array('heading' => 'New appointment',
                                        'route' => 'appointment.store',
                                        'submitText' => 'Add',
                                        'method' => 'POST'))
@stop

 
