@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            {{-- <div class="col-md-12"> --}}
                <div class="card">
            <div class="card-header">Matrix Soldering Temp Monitoring</div> 
            {{-- <div class="card"> --}}
        <div class="card-body">        
        <a href="/Summary" class="btn btn-secondary">Go Back</a>
        <a href="/matsolder/create" class="btn btn-success">Add Record</a>
        
            <table class="table table-striped" style="font-size:12px;">
            <tr>
                <th></th>
                <th>Station</th>
                <th>Location</th>
                <th>Shift</th>
                <th>Supplier</th>
                <th>Node</th>
                <th>Temp 1</th>
                <th>Temp 2</th>
                <th>Temp 3</th>
                <th>Remarks</th>
                <th>Average</th>
                <th>Bottom 1</th>
                <th>Bottom 2</th>
                <th>Bottom 3</th>
                <th>Bottom Average</th>
                <th>Date</th>


            </tr>

                @if(count($matsolderingtemp) > 0)
        <?php $i=0 ?>
                @foreach($matsolderingtemp as $potLog)
                <?php $i++ ?>
                 <tr>
                 <td>
                    <td>{{$potLog->EmployeeID}}</td>
                    <td>{{$potLog->Location}}</td>
                    <td>{{$potLog->Shift}}</td>
                    <td>{{$potLog->Supplier}}</td>
                    <td>{{$potLog->Node}}</td>
                    <td>{{$potLog->Temp1}}</td>
                    <td>{{$potLog->Temp2}}</td>
                    <td>{{$potLog->Temp3}}</td>
                    <td>{{$potLog->Remarks}}</td>
                    <td style="font-size:12px;">{{$potLog->Average}}</td>
                    <td>{{$potLog->botTemp1}}</td>
                    <td>{{$potLog->botTemp2}}</td>
                    <td>{{$potLog->botTemp3}}</td>
                    <td style="font-size:12px;">{{$potLog->botAverage}}</td>
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