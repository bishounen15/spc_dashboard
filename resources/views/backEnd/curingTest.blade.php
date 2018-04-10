 @extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-12">
            <div class="card">
            <div class="card-header">Curing Line Snap Test Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/Curing/create" class="btn btn-success">Add Record</a>
            <table class="table table-striped default">
            <tr>
                <th>Row</th>
                <th>Serial</th>
                <th>Shift</th>
                <th>Date</th>
                <th>Snap Testing Time</th>
                <th>Potting Time</th>
                <th>Condition</th>
            </tr>

             
                @if(count($curLogs) > 0)
                @foreach($curLogs as $potLog)
                 <tr>
                    <td>{{$potLog->id}}</td>
                    <td>{{$potLog->shift}}</td>
                    <td>{{$potLog->serialNo}}</td>
                    <td>{{$potLog->date}}</td>
                    <td>{{$potLog->snapTime}}</td>
                    <td>{{$potLog->pottingTime}}</td>
                    <td>{{$potLog->condition}}</td>
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


 