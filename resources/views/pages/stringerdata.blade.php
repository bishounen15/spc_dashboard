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
            <div class="card-header">STRINGER MONITORING</div> 
            {{-- <div class="card"> --}}
            <div class="card-body"> 
            <a href="/Summary" class="btn btn-success">Go Back</a>
            <a href="/stringer/create" class="btn btn-primary">ADD STRINGER DATA</a>
            <br><br>
            <table class="table table-striped">
            <tr>
            <th></th>
            <th>Date &nbsp;&nbsp;&nbsp;</th>
            <th>Stringer &nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Shift &nbsp;&nbsp;&nbsp;</th>
            <th>Cell &nbsp;&nbsp;&nbsp;</th>
            <th>Ribbon &nbsp;&nbsp;&nbsp;</th>
            <th>Station&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Side&nbsp;&nbsp;&nbsp;</th>
            <th>Cell No.&nbsp;&nbsp;&nbsp;</th>
            <th>Location&nbsp;&nbsp;&nbsp;</th>
            <th>Peel Test&nbsp;&nbsp;</th>
            <th>Criteria&nbsp;&nbsp;</th>
            <th>Remarks&nbsp;&nbsp;</th>
            </tr>
            @if(count($alldata) > 0)
            <?php $i=0 ?>
            @foreach($alldata as $pulltest)
            <?php $i++ ?>
            <tr>
            <td>
            <td>{{$pulltest->Date}}</td>
            <td>{{$pulltest->Stringer}}</td>
            <td>{{$pulltest->Shift}}</td>
            <td>{{$pulltest->Cell}}</td>
            <td>{{$pulltest->Ribbon}}</td>
            <td>{{$pulltest->Station}}</td>
            <td>{{$pulltest->Side}}</td>
            <td>{{$pulltest->Cell}}</td>
            <td>{{$pulltest->Location}}</td>
            <td>{{$pulltest->PeelTest}}</td>
            <td>{{$pulltest->Criteria}}</td>
            <td>{{$pulltest->Remarks}}</td>
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