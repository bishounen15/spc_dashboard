


@extends('layouts.app')
  
@section('content')

<div class="container">

    <div class="col-12">
 
        <div class="row">
           
            <div class="card">
            <div class="card-body">Potting Qual Monitoring</div> 
           
                
                    <h1>&emsp;Add Record</h1>
                    {!! Form::open(['action' => 'PottingController@store','method' => 'POST']) !!}
                    <div class="form-group">
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('time','Time'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{Form::text('time','Time',['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1">    {{Form::label('shift','Shift'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">      {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control'])}} </div>
                               
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                        <br/>
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('pottantName','Pottant Name'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{ Form::select('pottantName', array('Tonsan' => 'Tonsan') ,'Tonsan',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('jBoxName','JBox Name'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{ Form::select('jboxName', array('Sunter' => 'Sunter'),'Sunter',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('pottantWeight','Pottant Weight'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">      {{Form::text('pottantWt','00.00' ,['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                    <br/>
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('snapTime','Snap Time(Mins)'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{ Form::text('snapTime','00' ,['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('crossSection','Cross Section'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{ Form::select('crossSection', array('Cured' => 'Cured','Uncured' => 'Uncured'),'Cured',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('remarks','Remarks'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">      {{Form::text('remarks','Remarks' ,['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                    </div>
                    
                    &emsp;&emsp;&emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}} &emsp; <a href="/Potting" class="btn btn-danger">Cancel</a>
                    {!! Form::close() !!}

            <br/>
            </div>
          
            </div>


 
    </div>      


</div>




           


 @endsection

 