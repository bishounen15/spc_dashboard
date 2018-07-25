


@extends('layouts.app')
  
@section('content')



<div class="row">
    <div class="container">
     
           
       
    
    <div class="row">
        <div class = "col-sm-12" >          
        <div class="card">
        <div class="card-header"> Curing Line Snap Test Monitoring</div> 
 
            
                <br/>
                {!! Form::open(['action' => 'CuringController@store','method' => 'POST']) !!}
                <div class="form-group">
                    <div class="row"  style="font-size:12px;">
                        <div class="col-md-12">
                        <div class = "row">
                                <div class = "col-sm-1"> </div>

                                <div class = "col-sm-2"> 
                                        <div class = "row">
                                           <div class = "col-sm-3">    {{Form::label('Shift','Shift'),['class'=>'form-control']}}  </div>
                                       <div class="col-sm-9">      {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control form-control-sm'])}} </div>
                                        </div></div>
       
                                        <div class = "col-sm-3"> 
                                               <div class = "row">
                                                       <div class = "col-sm-2">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                                       <div class="col-sm-10">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control form-control-sm'] )}}  </div>
                                               </div></div>
                                               
                                <div class = "col-sm-3"> 
                                        <div class = "row">
                                <div class = "col-sm-2">  {{Form::label('snaptime','Snap Time'),['class'=>'form-control form-control-sm']}} </div>
                                    <div class = "col-sm-4">   {{ Form::text('snapTime', '',['class'=>'timepicker form-control form-control-sm','placeholder'=>'00:00','style'=>'padding:0;padding-bottom:0.3em;padding-top:0.3em'] )}}  
                                        <small class="form-text text-danger">{{ $errors->first('snapTime') }}</small>
                                    </div>
                                    <div class = "col-sm-2">  {{Form::label('pottingtime','Potting Time'),['class'=>'form-control form-control-sm']}} </div>
                                    <div class = "col-sm-4">   {{ Form::text('pottingTime', '',['class'=>'timepicker form-control form-control-sm','placeholder'=>'00:00','style'=>'padding:0;padding-bottom:0.3em;padding-top:0.3em'] )}}  
                                        <small class="form-text text-danger">{{ $errors->first('pottingTime') }}</small>
                                    </div>
                                        </div></div>
                                   

                            

                                
                                <div class = "col-sm-2"> 
                                                <div class = "row">
                                                    <div class = "col-sm-4">    {{Form::label('Condition'),['class'=>'form-control form-control-sm']}}  </div>
                                                    <div class="col-sm-8">       {{Form::select('condition', array('cured' => 'cured', 'uncured' => 'uncured'), 'S',['class'=>'result form-control form-control-sm']) }} </div>
                                                       
                                                </div></div>

                                <div class = "col-sm-1"></div> 

                               
                       
                        </div>
 
    
  
                <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('SerialNo',''),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{ Form::text('serialNo', '',['class'=>'form-control form-control-sm','id'=>'serialNo'] )}}   
                                   
                                    <small class="form-text text-danger">{{ $errors->first('serialNo') }}</small>
                                  
                                 </div>
                                <div class = "col-sm-1">   {{Form::label('Remarks','Remarks'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class= "col-sm-6">    {{ Form::text('remarks', 'Remarks',['class'=>'form-control form-control-sm']) }} </div>
                    
                           
                               
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                    <br/>
                    &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/Curing" class="btn btn-danger">Cancel</a>
                    {!! Form::close() !!}
                    </div>
               
              <br/>
                    </div>
                </div>
        </div>

    
        </div>
    </div>  
   
    
  

<div class="row">
    <div class="col-md-12">
            <div class="card">
                    <div class="card-header" >Last Qual Record</div> 
             
    <div>
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
        <?php $i=0 ?>
        @foreach($curLogs as $potLog)
        <?php $i++ ?>
         <tr>
            <td>{{ $i }}</td>
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
    
</div>
 @endsection

 @push('jscript')
 <script>

       $('.timepicker').datetimepicker({

format: 'HH:mm'

}); 

    </script>
 @endpush
