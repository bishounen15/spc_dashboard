@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <mes
            station="{{$station->STNCODE}}"
            station_desc="{{$station->STNDESC}}"
            station_id="{{$station->STNID}}"
            line="{{$prodline}}"
            line_desc="{{$linedesc}}"
            prod_date="{{$date}}"
            shift="{{$shift}}"
            registration="{{$registration}}"
            uid="{{Auth::user()->user_id}}"
            user_name="{{Auth::user()->name}}">
        </mes>
    </div>
@endsection