@extends('layouts.app')
@section('content')
<title>{{config('app.name', 'SOLARPH')}}</title>
<div class="container">
{{-- @guest
<div class="row">
  <div class="alert alert-danger col text-center">
    <strong>You are not logged in.</strong>
  </div>
</div>
@else --}}
<div class="row">
    <div class="col-4">

      <div class="card">
        <div class="card-header">General Set-up</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a  href="/process/create">Process</a></li>
          <li class="list-group-item"><a  href="/bom/create">BOM Type</a></li>
          <li class="list-group-item"><a  href="/product/create">Product Type</a></li>
          <li class="list-group-item"><a  href="/subprocess/create">Critical Nodes</a></li>
          <li class="list-group-item"><a  href="/parameter/create">SPC Indicators chart Parameters</a></li>
        </ul>
    </div>
     
    

</div>
{{-- @endguest --}}
</div>
@endsection