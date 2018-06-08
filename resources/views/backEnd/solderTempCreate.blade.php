


@extends('layouts.app')
  
@section('content')

<div class="container">

    <div class="col-12">
 
        <div class="row">
           
                <div class="card">
            <div class="card-header">J-Box Solder Temperature Monitoring</div> 
           
                
                    <h1>&emsp;Add Record</h1>
                    {!! Form::open(['action' => 'solderTempController@store','method' => 'POST']) !!}
                    <div class="form-group">
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   {{Form::label('shift','Shift'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1">   {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">     {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">   {{Form::label('J-Box','J-Box'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">     {{ Form::select('jboxName', array('Sunter' => 'Sunter'),'Sunter',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">   {{Form::hidden('transID','1'),['class'=>'form-control']}} </div>
                      
                        </div>
                        <br/>
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">     </div>
                                <div class="col-sm-3">    {{Form::label('tempBefAdj','Temp Before Adjustment'),['class'=>'form-control']}} </div>
                                <div class = "col-sm-3">   {{Form::label('tempAftAdj','Temp After Adjustment'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">      {{Form::label('average','Average'),['class'=>'form-control']}}</div>
                                <div class = "col-sm-1"> </div>
                      
                        </div>

                    <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   1  </div>
                                <div class="col-sm-3">    {{Form::text('tempBefAdj','Bef1' ,['class'=>'form-control'])}}   </div>
                                <div class = "col-sm-3">   {{Form::text('tempAftAdj','Aft1' ,['class'=>'form-control'])}}   </div>
                                <div class="col-sm-3">       {{Form::text('tempAvg','Ave' ,['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1"> </div>
              
                </div>
                <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">  2   </div>
                                <div class="col-sm-3">    {{Form::text('tempBefAdj','Bef2' ,['class'=>'form-control'])}}    </div>
                                <div class = "col-sm-3">   {{Form::text('tempAftAdj','Aft2' ,['class'=>'form-control'])}}   </div>
                                <div class="col-sm-3">        </div>
                                <div class = "col-sm-1"> </div>
              
                </div>
                <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">  3   </div>
                                <div class="col-sm-3">    {{Form::text('tempBefAdj','0' ,['class'=>'form-control'])}}  </div>
                                <div class = "col-sm-3">   {{Form::text('tempAftAdj','0' ,['class'=>'form-control'])}}   </div>
                                <div class="col-sm-3">       </div>
                                <div class = "col-sm-1"> </div>
              
                </div>
                <div class = "row">
                                <div class = "col-sm-1"> </div>            
                                <div class = "col-sm-2">   {{Form::label('remarks','remarks'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-5">    {{ Form::select('remarks', array('Passed' => 'Passed','Failed' => 'Failed'),'Passed',['class'=>'form-control'] )}} </div>
                                <div class = "col-sm-4"> </div>
              
                </div>

              
            <br/>
           
                    </div>
                    
                    &emsp;&emsp;&emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}} &emsp; <a href="/SolderTemp" class="btn btn-danger">Cancel</a>
                    {!! Form::close() !!}

            <br/>
            </div>
          
            </div>


 
    </div>      


</div>




           


 @endsection

 