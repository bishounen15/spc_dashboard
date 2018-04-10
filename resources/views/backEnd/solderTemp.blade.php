@extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">J-Box Solder Temperature Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/SolderTemp/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped">
            <tr>
                <th>Seq</th>
                <th>Shift</th>
                <th>Date</th>
                <th>Temp Before <br/> Adjustment</th>
                <th>Temp After  <br/>Adjustment</th>
                <th>Remarks</th>
                <th>J-Box</th>
            </tr>

             
                @if(count($tempLogs) > 0)
                @foreach($tempLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->tempBefAdj}}</td>
                    <td>{{$potLog->tempAftAdj}}</td>
                    <td>{{$potLog->remarks}}</td>
                    <td>{{$potLog->jBox}}</td>
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


 