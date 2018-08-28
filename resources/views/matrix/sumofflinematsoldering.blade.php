@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            {{-- <div class="col-md-12"> --}}
                <div class="card">
            <div class="card-header">Offline Matrix Soldering Temp Monitoring</div> 
            {{-- <div class="card"> --}}
        <div class="card-body">        
        <a href="/Summary" class="btn btn-secondary">Go Back</a>
        <a href="/offlinematsolder/create" class="btn btn-success">Add Record</a>
        
            <table class="table table-striped" style="font-size:12px;">
            <tr>
                <th></th>
                <th>EmployeeID</th>
                <th>Location</th>
                <th>Process</th>
                <th>Shift</th>
                <th>Supplier</th>
                <th>Node</th>
                <th>Temp </th
                <th>Remarks</th>
                <th>Average</th>
                <th>Date</th>
            </tr>

        
                @if(count($offlinematsolderingtemp) > 0)
        <?php $i=0 ?>
                @foreach($offlinematsolderingtemp as $potLog)
                <?php $i++ ?>
                 <tr>
                 <td>
                    <td>{{$potLog->employeeid}}</td>
                    <td>{{$potLog->location}}</td>
                    <td>{{$potlog->process}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->node}}</td>
                    <td>{{$potLog->supplier}}</td>
                    <td>{{$potLog->temp}}</td>
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