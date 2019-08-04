@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <cab-record 
        title="Cabinet Information"
        v-bind:production_line=0
        line_desc=""
        user_id="{{Auth::user()->user_id}}"
    ></cab-record>
</div>
@endsection