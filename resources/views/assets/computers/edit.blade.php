@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <asset-entry
     v-bind:add=false
     v-bind:device_id={{$id}}></asset-entry>
</div>
@endsection