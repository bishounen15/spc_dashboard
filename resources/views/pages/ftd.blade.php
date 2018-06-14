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
            <div class="card-header">FLASH TEST DATA MONITORING</div> 
            {{-- <div class="card"> --}}
            <div class="card-body">
            <a href="flash/create" class="btn btn-primary">ADD FLASH TEST DATA</a>
            <br><br>
            <table class="table table-striped">
            <tr>
            <th></th>
            <th>Date &nbsp;&nbsp;&nbsp;</th>
            <th>ModuleID &nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Inspection Time &nbsp;&nbsp;&nbsp;</th>
            <th>ISC &nbsp;&nbsp;&nbsp;</th>
            <th>UOC &nbsp;&nbsp;&nbsp;</th>
            <th>IMPP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>UMPP&nbsp;&nbsp;&nbsp;</th>
            <th>PMPP&nbsp;&nbsp;&nbsp;</th>
            <th>Shunt Resistance&nbsp;&nbsp;&nbsp;</th>
            <th>FF&nbsp;&nbsp;</th>
            <th>BIN&nbsp;&nbsp;</th>
            </tr>
            @if(count($alldata) > 0)
            <?php $i=0 ?>
            @foreach($alldata as $pulltest)
            <?php $i++ ?>
            <tr>
            <td>
            <td>{{$pulltest->created_at}}</td>
            <td>{{$pulltest->ModuleID}}</td>
            <td>{{$pulltest->InspTime}}</td>
            <td>{{$pulltest->ISC}}</td>
            <td>{{$pulltest->UOC}}</td>
            <td>{{$pulltest->IMPP}}</td>
            <td>{{$pulltest->UMPP}}</td>
            <td>{{$pulltest->PMPP}}</td>
            <td>{{$pulltest->ShuntResist}}</td>
            <td>{{$pulltest->FF}}</td>
            <td>{{$pulltest->BIN}}</td>
            </tr>
            @endforeach 
            @else
            <p>No Records Found</p>
            @endif
            </table>
            </div>
            {{-- </div> --}}
            </div>
            {{-- </div> --}}
            </div>
            </div>
            </div> 
@endsection