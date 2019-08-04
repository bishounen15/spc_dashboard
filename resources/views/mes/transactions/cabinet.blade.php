@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <cab-record 
        title="Cabinet Information"
        v-bind:production_line={{$prodline->LINCODE}}
        line_desc="{{$prodline->LINDESC}}"
        user_id="{{Auth::user()->user_id}}"
    ></cab-record>
</div>
@endsection