


@extends('layouts.app')
  
@section('content')



<div class="container">
    
        <div class="col-12">
     
           
       
    

           
    <div class="row">
               
        <div class="card">
        <div class="card-header">J-Box Dispense Weight Monitoring</div> 
 
            
                <h1>&emsp;Add Record</h1>
                {!! Form::open(['action' => 'JBoxController@store','method' => 'POST']) !!}
                <div class="form-group">
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('shift','Shift'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('beadWt','Bead Wt.'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{ Form::text('beadWt', '0',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1"> {{Form::hidden('transID','1'),['class'=>'form-control']}} </div>
                      
                        </div>
                        <br/>
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   {{Form::label('MaterialPN','Material PN'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{Form::text('materialPN','Material PN' ,['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1">    {{Form::label('J-Box','J-Box'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">     {{ Form::select('jboxName', array('Sunter' => 'Sunter'),'Sunter',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">   {{Form::label('cdaPressure','cda Pressure'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">    {{ Form::text('cdaPress', '0',['class'=>'form-control']) }} </div>
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                        <br/>
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   {{Form::label('remarks','remarks'),['class'=>'form-control']}}  </div>
                                <div class= "col-sm-9">    {{ Form::text('remarks', 'Remarks',['class'=>'form-control']) }} </div>
                    
                           
                               
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                    <br/>
           
                    </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/JBox" class="btn btn-danger">Cancel</a>
                {!! Form::close() !!}
              <br/>
     
        </div>
      
        </div>
    </div>      
    
    
</div>

 @endsection

 