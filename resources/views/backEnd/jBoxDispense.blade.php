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
            <table class="table table-striped" style="font-size:12px;">
            <tr>
                <th>Seq</th>
                <th>Shift</th>
                <th>Date</th>
                <th>Qual Time</th>
                <th>JBox</th>
                <th>Sealant</th>
                <th>Target</th>
                <th>Bead Wt.</th>
                <th>CDA Pressure</th>
                <th>Main CDA <br/> Supply</th>
                <th>RAM CDA</th>
                <th>Down <br/> Stream</th>
                <th>Result</th>
                <th>Remarks</th>
            </tr>

             
                @if(count($disLogs) > 0)
                @foreach($disLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->qualTime}}</td>
                    <td>{{$potLog->jBox}}</td>
                    <td>{{$potLog->sealant}}</td>
                    <td>{{$potLog->target}}</td>
                    <td>{{$potLog->beadWt}}</td>
                    <td>{{$potLog->cdaPressure}}</td>
                    <td>{{$potLog->mainCDASupply}}</td>
                    <td>{{$potLog->RAMCDA}}</td>
                    <td>{{$potLog->downStream}}</td>
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


 