@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            <div class="col-md-12"> 
                <div class="card">
            <div class="card-header">Matrix Soldering Temp Monitoring</div> 
           
        <div class="card-body">        
        <a href="/Summary" class="btn btn-secondary">Go Back</a>
        <a href="/matsolder/create" class="btn btn-success">Add Record </a>
     
            <table class="table table-striped" style="font-size:10px;">
            <tr>
                
                <th>Employee ID</th>
                <th>Process</th>
                <th>Location</th>
                <th>Shift</th>
                <th>Node</th>
                <th>Supplier</th>
                <th>Product </br> Built</th>
                <th>Temp 1</th>
                <th>Temp 2</th>
                <th>Temp 3</th>
                <th>Average</th>
                <th>Remarks</th>
                <th>Date</th>


            </tr>

                @if(count($matsolderingtemp) > 0)
        <?php $i=0 ?>
                @foreach($matsolderingtemp as $potLog)
                <?php $i++ ?>
                 <tr>
                    <td>{{$potLog->employeeid}}</td>
                    <td>{{$potLog->process}}</td>
                    <td>{{$potLog->Location}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->node}}</td>
                    <td>{{$potLog->supplier}}</td>
                    <td>{{$potLog->productBuilt}}</td>
                    <td>{{$potLog->temp1}}</td>
                    <td>{{$potLog->temp2}}</td>
                    <td>{{$potLog->temp3}}</td>
                    <td style="font-size:12px;">{{$potLog->average}}</td>
                 
                    <td>{{$potLog->remarks}}</td>
                    <td>{{$potLog->date}}</td>
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
</div>      
 @endsection