


@extends('layouts.app')
  
@section('content')



<div class="container">
    
        <div class="col-12">
     
           
       
    

           
    <div class="row">
               
        <div class="card">
        <div class="card-header">Curing Line Snap Test Monitoring</div> 
 
            
                <h1>&emsp;Add Record</h1>
                {!! Form::open(['action' => 'CuringController@store','method' => 'POST']) !!}
                <div class="form-group">
                    <div class = "row">
                            <div class = "col-sm-1"> </div>
                            <div class = "col-sm-1">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-2">      {{Form::date('fixture_date', \Carbon\Carbon::now(),['class'=>'form-control'] )}}  </div>
                            <div class = "col-sm-1">    {{Form::label('shift','Shift'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-2">       {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control'])}} </div>
                            <div class = "col-sm-1">    {{Form::label('serialNo','Serial No'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-3">      {{Form::text('serialNo','Serial no',['class'=>'form-control'])}} </div>
                            <div class = "col-sm-1"> </div>
                  
                    </div>
                    <br/>
                    <div class = "row">

                            <div class = "col-sm-1"> </div>
                        <div class = "col-sm-1">    {{Form::label('snaptestTime','Snap test time'),['class'=>'form-control']}}  </div>
                        <div class="col-sm-2">      {{Form::text('snaptestTime', 'Snap Time',['class'=>'form-control'] )}}  </div>
                        <div class = "col-sm-1">    {{Form::label('pottingTime','Potting Time'),['class'=>'form-control']}}  </div>
                        <div class="col-sm-2">      {{Form::text('pottingTime','Potting Time',['class'=>'form-control'])}} </div>
                        <div class = "col-sm-1">    {{Form::label('Condition','Condition'),['class'=>'form-control']}}  </div>
                        <div class="col-sm-3">      {{Form::select('condition', array('Cured' => 'Cured', 'Uncured' => 'Uncured'), 'Cured',['class'=>'form-control'])}} </div>
                        <div class = "col-sm-1"> </div>
                    </div>
               
                   
                </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/Curing" class="btn btn-danger">Cancel</a>
                {!! Form::close() !!}
              <br/>
     
        </div>
      
        </div>
    </div>      
    
    
</div>

 @endsection

 