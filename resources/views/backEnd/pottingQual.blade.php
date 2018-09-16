@extends('layouts.app')
  
@section('content')
    <div class="container">
 
        <div class="row">
            <div class="col-12">
                <div class="card">
            <div class="card-header">Potting Qual Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/Potting/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped">
            <tr>
            <th>Row</th>
            <th>Shift</th>
            <th>Time</th>
            <th>Pottant Name</th>
            <th>JBox Name</th>
            <th>Pottant Wt.</th>
            <th>Snap Time</th>
            <th>Cross Section</th>
           
            </tr>
    
            @if(count($potLogs) > 0)
            <?php $i=0 ?>
            @foreach($potLogs as $potLog)
            <?php $i++ ?>
             <tr>
                <td>{{ $i }}</td>
                <td>{{$potLog->shift}}</td>
                <td>{{$potLog->time}}</td>
                <td>{{$potLog->pottantName}}</td>
                <td>{{$potLog->jBoxName}}</td>
                <td>{{$potLog->pottantWeight}}</td>
                <td>{{$potLog->snapTime}}</td>
                <td>{{$potLog->crossSection}}</td>
               
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

 