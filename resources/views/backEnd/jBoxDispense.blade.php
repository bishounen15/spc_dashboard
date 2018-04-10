@extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-12">
                <div class="card">
            <div class="card-header">J-Box Dispense Weight Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/JBox/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped">
            <tr>
                <th>Seq</th>
               
                <th>Shift</th>
                <th>Date</th>
                <th>Bead Wt.</th>
                <th>Material PN</th>
                <th>cda Pressure</th>
                <th>J-Box</th>
                <th>Remarks</th>
            </tr>

             
                @if(count($disLogs) > 0)
                @foreach($disLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->beadWt}}</td>
                    <td>{{$potLog->materialPN}}</td>
                    <td>{{$potLog->cdaPressure}}</td>
                    <td>{{$potLog->JBox}}</td>
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


 