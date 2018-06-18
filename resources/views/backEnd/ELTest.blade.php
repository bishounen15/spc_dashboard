@extends('layouts.app')
  
@section('content')


    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">EL Test Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/ELTest/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped">
            <tr>
            <th>Seq</th>
            <th>Date</th>
            <th>Time</th>
            <th>Shift</th>
            <th>Serial No</th>
            <th>Result</th>
            <th>Remarks</th>
            </tr>

             
                @if(count($ELTestLogs) > 0)
                @foreach($ELTestLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->qualTime}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->serialNo}}</td>
                    <td>{{$potLog->result}}</td>
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


 