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
            <div class="card-header">PULLTEST MONITORING</div> 
            {{-- <div class="card"> --}}
            <div class="card-body">
            <a href="/pulltest/create" class="btn btn-primary">ADD PULLTEST DATA</a>
            <br><br>
            <table class="table table-striped">
            <tr>
            <th></th>
            <th>Date &nbsp;&nbsp;&nbsp;</th>
            <th>Laminator &nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Shift &nbsp;&nbsp;&nbsp;</th>
            <th>Recipe &nbsp;&nbsp;&nbsp;</th>
            <th>Glass &nbsp;&nbsp;&nbsp;</th>
            <th>EVA&nbsp;&nbsp;&nbsp;</th>
            <th>Backsheet&nbsp;&nbsp;&nbsp;</th>
            <th>Location&nbsp;&nbsp;&nbsp;</th>
            <th>EVA-Glass Avrge&nbsp;&nbsp;&nbsp;</th>
            <th>EVA-Backsheet Avrge&nbsp;&nbsp;&nbsp;</th>
            </tr>
            @if(count($alldata) > 0)
            <?php $i=0 ?>
            @foreach($alldata as $pulltest)
            <?php $i++ ?>
            <tr>
            <td>
            <td>{{$pulltest->Date}}</td>
            <td>{{$pulltest->Laminator}}</td>
            <td>{{$pulltest->Shift}}</td>
            <td>{{$pulltest->Recipe}}</td>
            <td>{{$pulltest->Glass}}</td>
            <td>{{$pulltest->EVA}}</td>
            <td>{{$pulltest->Backsheet}}</td>
            <td>{{$pulltest->Location}}</td>
            <td>{{$pulltest->PTEGA}}</td>
            <td>{{$pulltest->PTEBA}}</td>
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