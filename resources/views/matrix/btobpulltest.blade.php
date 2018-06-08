@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            {{-- <div class="col-md-12"> --}}
                <div class="card">
            <div class="card-header">Busbar to Busbar Pulltest Monitoring</div> 
            {{-- <div class="card"> --}}
        <div class="card-body">        
        <a href="/Summary" class="btn btn-secondary">Go Back</a>
        <a href="/offlinebtob/create" class="btn btn-success">Add Record</a>
        
            <table class="table table-striped" style="font-size:12px;">
            <tr>
                <th></th>
                <th>Employee ID</th>
                <th>Location</th>
                <th>Shift</th>
                <th>Node</th>
                <th>Supplier</th>
                <th>Site 1</th>
                <th>Pull Test 1</th>
                <th>Site 2</th>
                <th>Pull Test 2</th>
                <th>Site 3</th>
                <th>Pull Test 3</th>
                <th>Remarks</th>
                <th>Average</th>
                <th>Date</th>
            </tr>

        
                @if(count($btobpulltest) > 0)
        <?php $i=0 ?>
                @foreach($btobpulltest as $potLog)
                <?php $i++ ?>
                 <tr>
                 <td>
                    <td>{{$potLog->employeeid}}</td>
                    <td>{{$potLog->location}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->node}}</td>
                    <td>{{$potLog->supplier}}</td>
                    <td>{{$potLog->site1}}</td>
                    <td>{{$potLog->pulltest1}}</td>
                    <td>{{$potLog->site2}}</td>
                    <td>{{$potLog->pulltest2}}</td>
                    <td>{{$potLog->site3}}</td>
                    <td>{{$potLog->pulltest3}}</td>
                    <td>{{$potLog->remarks}}</td>
                    <td style="font-size:12px;">{{$potLog->average}}</td>
                    <td>{{$potLog->created_at}}</td>
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