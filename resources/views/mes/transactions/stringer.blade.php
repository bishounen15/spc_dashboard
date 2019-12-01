@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <stringer
        line="{{$prodline != null ? $prodline->LINDESC : "-"}}"
        prodline="{{$prodline != null ? $prodline->LINCODE : "-"}}"
        machine="{{$machine}}"
        station="{{$station}}"
        date="{{$date}}"
        user_id="{{Auth::user()->user_id}}"></stringer>
    </div>    
@endsection