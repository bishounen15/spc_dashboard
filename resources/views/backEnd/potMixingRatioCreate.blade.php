


@extends('layouts.app')
  
@section('content')



<div class="container">
    
        <div class="col-12">
     
           
       
    

           
    <div class="row">
               
        <div class="card">
        <div class="card-header">Mixing Ratio Monitoring</div> 
 
            
                <h1>&emsp;Add Record</h1>
                {!! Form::open(['action' => 'MixRatioController@store','method' => 'POST']) !!}
                <div class="form-group">
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('shift','Shift'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('SampleCount','Sample Count'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{ Form::text('sampCount', '0',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::hidden('transID','1'),['class'=>'form-control']}} </div>
                       
                        </div>
                        <br/>
                        <div class = "row">
                            <div class = "col-sm-1"> </div>
                            <div class = "col-sm-1">   </div>
                            <div class="col-sm-2">       {{Form::label('befDispenseWt','Before Dispense Wt'),['class'=>'form-control']}} </div>
                            <div class = "col-sm-2">    {{Form::label('dispensedWt','Dispensed Wt'),['class'=>'form-control']}}    </div>
                            <div class="col-sm-2">      {{Form::label('wt','Weight'),['class'=>'form-control']}}  </div>
                            <div class = "col-sm-2">    {{Form::label('total','Total Wt.'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-1">    </div>
                            <div class = "col-sm-1">    </div>
                   
                    </div>
                    <div class = "row">
                        <div class = "col-sm-1"> </div>
                        <div class = "col-sm-1">   {{Form::label('A','PartA'),['class'=>'form-control']}}  </div>
                        <div class="col-sm-2">     {{ Form::text('befDispenseWtA', '0',['class'=>'form-control', 'id'=>'befDispenseWtA'] )}} </div>
                        <div class = "col-sm-2">   {{ Form::text('dispensedWtA', '0',['class'=>'form-control', 'id'=>'dispensedWtA' ] )}}    </div>
                        <div class="col-sm-2">     {{ Form::text('weightA', '0',['class'=>'form-control','id'=>'weightA','readonly'=>'true'] )}}  </div>
                        <div class = "col-sm-2">    {{ Form::text('totalWt', '0',['class'=>'form-control', 'id'=>'totalWt','readonly'=>'true'] )}}   </div>
                        <div class="col-sm-1">    </div>
                        <div class = "col-sm-1">   </div>
               
                </div>
                <div class = "row">
                    <div class = "col-sm-1"> </div>
                    <div class = "col-sm-1">   {{Form::label('B','PartB'),['class'=>'form-control']}}  </div>
                    <div class="col-sm-2">     {{ Form::text('befDispenseWtB', '0',['class'=>'form-control','id'=>'befDispenseWtB'] )}} </div>
                    <div class = "col-sm-2">   {{ Form::text('dispensedWtB', '0',['class'=>'form-control', 'id'=>'befDispenseWtB'] )}}    </div>
                    <div class="col-sm-2">     {{ Form::text('weightB', '0',['class'=>'form-control','id'=>'weightB','readonly'=>'true'] )}}  </div>
                    <div class = "col-sm-2">      </div>
                    <div class="col-sm-1">    </div>
                    <div class = "col-sm-1">   </div>
           
            </div>
           

  
<br/>
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   {{Form::label('ratio','Ratio'),['class'=>'form-control']}}  </div>
                                <div class= "col-sm-9">    {{ Form::text('ratio', '0',['class'=>'form-control']) }} </div>
                    
                           
                               
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                    <br/>
           
                    </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/MixRatio" class="btn btn-danger">Cancel</a>
                {!! Form::close() !!}
              <br/>
     
        </div>
      
        </div>
    </div>      
    
    
</div>

 @endsection

 @push('jscript')
 <script>
           $('#befDispensedWtA' ).keyup(function(){
                var wtA;
                var wtB;

    textone = parseFloat($('#befDispensedWtA').val());
    texttwo = parseFloat($('#dispensedWtA').val());
  
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
   
    }
    $('#weightA').val(result.toFixed(2));
    wtA = parseFloat($('#weightA').val());
    wtB = parseFloat($('#weightB').val());
   
    sum =  wtA + wtB;
    $('#totalWt').val(sum.toFixed(2));
    });

      $('#dispensedWtA' ).keyup(function(){
                var wtA;
                var wtB;

    textone = parseFloat($('#befDispensedWtA').val());
    texttwo = parseFloat($('#dispensedWtA').val());
  
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
   
    }
    $('#weightA').val(result.toFixed(2));
    wtA = parseFloat($('#weightA').val());
    wtB = parseFloat($('#weightB').val());
   
    sum =  wtA + wtB;
    $('#totalWt').val(sum.toFixed(2));
    });
 
 </script>
 @endpush