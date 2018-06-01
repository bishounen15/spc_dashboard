@extends('layouts.app')
@section('content')
<title>{{config('app.name', 'SOLARPH')}}</title>
<div class="container">
    <br>

    <br>
    <div class="col-md-12">
            <div class="row">
            {{-- <div class="col-md-12"> --}}
            <div class="card">
            <div class="card-header">LAMINATOR MONITORING</div> 
            {{-- <div class="card"> --}}
            <div class="card-body"> 
            <a href="/Summary" class="btn btn-success">Go Back</a>
            <a href="/lam/create" class="btn btn-primary">ADD LXM DATA</a>
            <br><br>
            <table class="table table-striped">
            <tr>
            <th>Date &nbsp;&nbsp;&nbsp;</th>
            <th>Laminator &nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Shift &nbsp;&nbsp;&nbsp;</th>
            <th>Recipe &nbsp;&nbsp;&nbsp;</th>
            <th>Glass &nbsp;&nbsp;&nbsp;</th>
            <th>ModuleID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>EVA&nbsp;&nbsp;&nbsp;</th>
            <th>Backsheet&nbsp;&nbsp;&nbsp;</th>
            <th>Location&nbsp;&nbsp;&nbsp;</th>
            <th>LXM Average&nbsp;&nbsp;&nbsp;</th>
            <th>Rel Gel Average&nbsp;&nbsp;&nbsp;</th>
            </tr>
            
            
    
</div>
@endsection