@extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">J-Box Solder Temperature Monitoring</div> 
            <div class="card-body">
                
<a href="/SPC/SolderTemp" class="btn btn-secondary">Go Back</a>
<a href="/SPC/SolderTemp/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped" style="font-size:10px;">
            <tr>
                <th>Seq</th>
                <th>Shift</th>
                <th>Qual Time</th>
                <th>Date</th>
                <th>Temp Before <br/> Adjustment 1</th>
                <th>Temp Before <br/> Adjustment 2</th>
                <th>Temp Before <br/> Adjustment 3</th>
                <th>Temp Before <br/> Adj. Ave</th>
                <th>Temp After  <br/>Adjustment 1</th>
                <th>Temp After  <br/>Adjustment 2</th>
                <th>Temp After  <br/>Adjustment 3</th>
                <th>Temp After <br/> Adj. Ave</th>
                <th>J-Box</th>
                <th>Target</th>
                <th>Qual<br/>Result</th>
                <th>Remarks</th>
               
            </tr>

             
                @if(count($tempLogs) > 0)
                @foreach($tempLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->qualTime}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->tempBefAdj1}}</td>
                    <td>{{$potLog->tempBefAdj2}}</td>
                    <td>{{$potLog->tempBefAdj3}}</td>
                    <td>{{$potLog->tempBefAdjAve}}</td>
                    <td>{{$potLog->tempAftAdj1}}</td>
                    <td>{{$potLog->tempAftAdj2}}</td>
                    <td>{{$potLog->tempAftAdj3}}</td>
                    <td>{{$potLog->tempAftAdjAve}}</td>
                    <td>{{$potLog->jBox}}</td>
                    <td>{{$potLog->target}}</td>
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


 