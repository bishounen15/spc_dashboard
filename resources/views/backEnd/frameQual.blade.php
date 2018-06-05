@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            {{-- <div class="col-md-12"> --}}
            <div class="card">
            <div class="card-header">Frame Qual Monitoring</div> 
            {{-- <div class="card"> --}}
        <div class="card-body">        
        <a href="/Summary" class="btn btn-secondary">Go Back</a>
        <a href="/Frame/create" class="btn btn-success">Add Record</a>
        
            <table class="table table-striped">
            <tr>
                <th>Seq</th>
               
                <th>Shift</th>
                <th>Date</th>
                <th>Time</th>
                <th>Serial No</th>
                <th>Frame <br/>Location</th>
                <th>w/o Sealant <br/> weight</th>
                <th>w/ Sealant <br/> weight</th>
                <th>difference</th>
                <th>Wt.</th>
                <th>Bead <br/>Scale</th>
                <th>Facility <br/>Supply</th>
                <th>Main <br/>Pressure</th>
                <th>Target</th>
                <th>Remarks</th>
            </tr>

             
                @if(count($frameLogs) > 0)
                @foreach($frameLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->qualTime}}</td>
                    <td>{{$potLog->serialNo}}</td>
                    <td>L1</td>
                    <td>{{$potLog->L1woSealantWt}}</td>
                    <td>{{$potLog->L1wSealantWt}}</td>
                    <td>{{$potLog->L1diff}}</td>
                    <td>{{$potLog->weight}}</td>
                    <td>{{$potLog->beadScale}}</td>
                    <td>{{$potLog->facilitySupply}}</td>
                    <td>{{$potLog->mainPressure}}</td>
                    <td>{{$potLog->TargetParam}}</td>
                    <td>{{$potLog->remarks}}</td>
                 </tr>
                 <tr>
                    <td> <td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                   
                    <td>L2</td>
                    <td>{{$potLog->L2woSealantWt}}</td>
                    <td>{{$potLog->L2wSealantWt}}</td>
                    <td>{{$potLog->L2diff}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>

                 <tr>
                    <td> <td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    
                    <td>S1</td>
                    <td>{{$potLog->S1woSealantWt}}</td>
                    <td>{{$potLog->S1wSealantWt}}</td>
                    <td>{{$potLog->S1diff}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>

                 <tr>
                    <td> <td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    
                    <td>S2</td>
                    <td>{{$potLog->S2woSealantWt}}</td>
                    <td>{{$potLog->S2wSealantWt}}</td>
                    <td>{{$potLog->S2diff}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
    {{-- </div> --}}
    </div>
    {{-- </div> --}}
    </div>
</div>
</div>      
 @endsection


 