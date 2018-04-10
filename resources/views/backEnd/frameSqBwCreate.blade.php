


@extends('layouts.app')
  
@section('content')



<div class="row">
    <div class="container">
     
           
       
    

           
    <div class="row">
               
        <div class="card">
        <div class="card-header">Frame Squareness and Bowing Qual Monitoring</div> 
 
            
                <h1>&emsp;Add Record</h1>
                {!! Form::open(['action' => 'SqBwController@store','method' => 'POST']) !!}
                <div class="form-group">
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('shift','Shift'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control'])}} </div>
                                <div class = "col-sm-1">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-3">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::label('serialNo','Serial No.'),['class'=>'form-control']}}  </div>
                                <div class="col-sm-2">      {{ Form::text('serialNo', 'Serial No',['class'=>'form-control'] )}}  </div>
                                <div class = "col-sm-1">    {{Form::hidden('transID','1'),['class'=>'form-control']}} </div>
                       
                        </div>
                        <br/>
                        <div class = "row">
                            <div class = "col-sm-1"> </div>
                            <div class = "col-sm-1">   </div>
                            <div class="col-sm-2">       {{Form::label('L1','L1'),['class'=>'form-control']}} </div>
                            <div class = "col-sm-2">    {{Form::label('L2','L2'),['class'=>'form-control']}}    </div>
                            <div class="col-sm-2">      {{Form::label('L3','L3'),['class'=>'form-control']}}  </div>
                            <div class = "col-sm-2">    {{Form::label('Diff','L-Diff'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-1">    </div>
                            <div class = "col-sm-1">    </div>
                   
                    </div>
                    <div class = "row">
                        <div class = "col-sm-1"> </div>
                        <div class = "col-sm-1">  </div>
                        <div class="col-sm-2">     {{ Form::text('L1', '0',['class'=>'form-control'] )}} </div>
                        <div class = "col-sm-2">   {{ Form::text('L2', '0',['class'=>'form-control'] )}}    </div>
                        <div class="col-sm-2">     {{ Form::text('L3', '0',['class'=>'form-control'] )}}  </div>
                        <div class = "col-sm-2">    {{ Form::text('LDiff', '0',['class'=>'form-control', 'read-only'] )}}   </div>
                        <div class="col-sm-1">    </div>
                        <div class = "col-sm-1">   </div>
               
                </div>
                
                <div class = "row">
                    <div class = "col-sm-1"> </div>
                    <div class = "col-sm-1">   </div>
                    <div class="col-sm-2">       {{Form::label('S1','S1'),['class'=>'form-control']}} </div>
                    <div class = "col-sm-2">    {{Form::label('S2','S2'),['class'=>'form-control']}}    </div>
                    <div class="col-sm-2">      {{Form::label('S3','S3'),['class'=>'form-control']}}  </div>
                    <div class = "col-sm-2">    {{Form::label('Diff','S-Diff'),['class'=>'form-control']}}  </div>
                    <div class="col-sm-1">    </div>
                    <div class = "col-sm-1">    </div>
           
            </div>
            <div class = "row">
                <div class = "col-sm-1"> </div>
                <div class = "col-sm-1">  </div>
                <div class="col-sm-2">     {{ Form::text('S1', '0',['class'=>'form-control'] )}} </div>
                <div class = "col-sm-2">   {{ Form::text('S2', '0',['class'=>'form-control'] )}}    </div>
                <div class="col-sm-2">     {{ Form::text('S3', '0',['class'=>'form-control'] )}}  </div>
                <div class = "col-sm-2">    {{ Form::text('SDiff', '0',['class'=>'form-control', 'read-only'] )}}   </div>
                <div class="col-sm-1">    </div>
                <div class = "col-sm-1">   </div>
       
        </div>
        <div class = "row">
            <div class = "col-sm-1"> </div>
            <div class = "col-sm-1">   </div>
            <div class="col-sm-2">       {{Form::label('D1','D1'),['class'=>'form-control']}} </div>
            <div class = "col-sm-2">    {{Form::label('D2','D2'),['class'=>'form-control']}}    </div>
            <div class="col-sm-2">      </div>
            <div class = "col-sm-2">    {{Form::label('Diff','D-Diff'),['class'=>'form-control']}}  </div>
            <div class="col-sm-1">    </div>
            <div class = "col-sm-1">    </div>
   
    </div>
    <div class = "row">
        <div class = "col-sm-1"> </div>
        <div class = "col-sm-1">  </div>
        <div class="col-sm-2">     {{ Form::text('D1', '0',['class'=>'form-control'] )}} </div>
        <div class = "col-sm-2">   {{ Form::text('D2', '0',['class'=>'form-control'] )}}    </div>
        <div class="col-sm-2">       </div>
        <div class = "col-sm-2">    {{ Form::text('DDiff', '0',['class'=>'form-control', 'read-only'] )}}   </div>
        <div class="col-sm-1">    </div>
        <div class = "col-sm-1">   </div>

</div>

   <br/>
  
                <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   {{Form::label('remarks','Remarks'),['class'=>'form-control']}}  </div>
                                <div class= "col-sm-9">    {{ Form::text('remarks', 'Remarks',['class'=>'form-control']) }} </div>
                    
                           
                               
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                    <br/>
           
                    </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/Framming" class="btn btn-danger">Cancel</a>
                {!! Form::close() !!}
              <br/>
     
        </div>
      
        </div>
    </div>      
    
    
</div>

 @endsection

 