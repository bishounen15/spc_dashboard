@extends('layouts.app')
  
@section('content')


    <div class="container">
 
        <div class="row">
            <div class="col-12">
                <div class="card">
            <div class="card-header">Mixing Ratio Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/MixRatio/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped" style="font-size:10px;">
            <tr>
                <th>Seq</th>
                <th>Date</th>
                <th>Shift</th>
                <th>Sample No.</th>
                <th>Part</th>
                <th>Before <br/>Dispense Wt</th>
                <th>Dispensed <br/>Wt</th>
                <th>Weight</th>
                <th>Total Wt</th>
                <th>Ratio</th>
                <th>Remarks</th>
           
            </tr>
<?php $i=0; ?>
             
                @if(count($MixLogs) > 0)
                @foreach($MixLogs as $potLog)
                <?php $i++ ?>
                 <tr>
                    <td>{{ $i }}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->sampleCount}}</td>
                    <td>A</td>
                    <td>{{$potLog->befDispenseWtA }}</td>
                    <td>{{$potLog->dispensedWtA }}</td>
                    <td>{{$potLog->weightA}}</td>
                    <td>{{$potLog->totalWt}}</td>
                    <td>{{$potLog->ratioVal}}</td>
                    <td>{{$potLog->qualRes}}</td>
             
                 </tr>
                 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>B</td>
                    <td>{{$potLog->befDispenseWtB }}</td>
                    <td>{{$potLog->dispensedWtB }}</td>
                    <td>{{$potLog->weightB}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
             
             
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


 