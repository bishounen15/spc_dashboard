@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <lot-record 
        station="{{$station}}"
        v-bind:materials="{{$materials}}"
        v-bind:production_line={{$prodline->LINCODE}}
        line_desc="{{$prodline->LINDESC}}"
    ></lot-record>
</div>
@endsection