@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <stringer
        line="{{$prodline->LINDESC}}"
        prodline="{{$prodline->LINCODE}}"
        machine="{{$machine}}"
        station="{{$station}}"
        user_id="{{Auth::user()->user_id}}"></stringer>
    </div>    
@endsection