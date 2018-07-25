@extends('layouts.app')
  
@section('content')


    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">Frame Squareness and Bowing Qual Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/Framming/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped">
            <tr>
            <th>Seq</th>
            <th>Date</th>
            <th>Time</th>
            <th>Shift</th>
            <th>Serial</th>
            <th>L1</th>
            <th>L2</th>
            <th>L3</th>
            <th>L-Diff</th>
            <th>S1</th>
            <th>S2</th>
            <th>S3</th>
            <th>S-Diff</th>
            <th>D1</th>
            <th>D2</th>
            <th>D-Diff</th>
            <th>Qual</br>Result</th>
            <th>Remarks</th>
            </tr>

             
                @if(count($frameSBLogs) > 0)
                @foreach($frameSBLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->qualTime}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->moduleID}}</td>
                    <td>{{$potLog->L1}}</td>
                    <td>{{$potLog->L2}}</td>
                    <td>{{$potLog->L3}}</td>
                    <td>{{$potLog->LDiff}}</td>
                    <td>{{$potLog->S1}}</td>
                    <td>{{$potLog->S2}}</td>
                    <td>{{$potLog->S3}}</td>
                    <td>{{$potLog->SDiff}}</td>
                    <td>{{$potLog->D1}}</td>
                    <td>{{$potLog->D2}}</td>
                    <td>{{$potLog->DDiff}}</td>
                    <td>{{$potLog->qualRes}}</td>
                    <td>{{$potLog->remarks}}</td>
                 </tr>
            @endforeach  
        @else
        <p>No Records Found</p>
        @endif
            </table>
            </div>
            </div>
            </div>
            </div>


 
    </div>      

 @endsection


 