


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
                                <div class="col-sm-2">      {{ Form::text('serialNo', 'Serial No',['class'=>'form-control','id'=>'serialNo'] )}}  </div>
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
                        <div class="col-sm-2">     {{ Form::text('L1', '0',['class'=>'form-control','id'=>'L1'] )}} </div>
                        <div class = "col-sm-2">   {{ Form::text('L2', '0',['class'=>'form-control','id'=>'L2'] )}}    </div>
                        <div class="col-sm-2">     {{ Form::text('L3', '0',['class'=>'form-control','id'=>'L3'] )}}  </div>
                        <div class = "col-sm-2">    {{ Form::text('LDiff', '0',['class'=>'form-control', 'id'=>'LDiff','readonly'=>'true'] )}}   </div>
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
                <div class="col-sm-2">     {{ Form::text('S1', '0',['class'=>'form-control','id'=>'S1'] )}} </div>
                <div class = "col-sm-2">   {{ Form::text('S2', '0',['class'=>'form-control','id'=>'S2'] )}}    </div>
                <div class="col-sm-2">     {{ Form::text('S3', '0',['class'=>'form-control','id'=>'S3'] )}}  </div>
                <div class = "col-sm-2">    {{ Form::text('SDiff', '0',['class'=>'form-control','id'=>'SDiff','readonly'=>'true'] )}}   </div>
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
        <div class="col-sm-2">     {{ Form::text('D1', '0',['class'=>'form-control','id'=>'D1'] )}} </div>
        <div class = "col-sm-2">   {{ Form::text('D2', '0',['class'=>'form-control','id'=>'D2'] )}}    </div>
        <div class="col-sm-2">       </div>
        <div class = "col-sm-2">    {{ Form::text('DDiff', '0',['class'=>'form-control','id'=>'DDiff', 'readonly'=>'true'] )}}   </div>
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

 @push('jscript')
 <script>
     var L1 = 0;
     var L2 = 0;
     var L3 = 0;
     $(document).ready(function () {

     });

    $('#L1' ).change(function(){
        if($('#L1').val()!=''){
           if( parseFloat( $('#L1').val())==parseFloat( $('#L2').val()) && parseFloat( $('#L1').val())==parseFloat( $('#L3').val()))
           { $('#LDiff').val('0'); }else{$('#LDiff').val('1');}
            
        }else{
            $('#L1').val(L1);
        }
        
    });
    
    $('#L2' ).change(function(){
        if($('#L2').val()!=''){
           if( parseFloat( $('#L2').val())==parseFloat( $('#L1').val()) && parseFloat( $('#L2').val())==parseFloat( $('#L3').val()))
           { $('#LDiff').val('0'); }else{$('#LDiff').val('1');}
            
        }else{
            $('#L2').val(L1);
        }
        
    });
    
    $('#L3' ).change(function(){
        if($('#L3').val()!=''){
           if( parseFloat( $('#L3').val())==parseFloat( $('#L1').val()) && parseFloat( $('#L3').val())==parseFloat( $('#L2').val()))
           { $('#LDiff').val('0'); }else{$('#LDiff').val('1');}
            
        }else{
            $('#L3').val(L1);
        }
        
    });


    $('#S1' ).change(function(){
        if($('#S1').val()!=''){
           if( parseFloat( $('#S1').val())==parseFloat( $('#S2').val()) && parseFloat( $('#S1').val())==parseFloat( $('#S3').val()))
           { $('#SDiff').val('0'); }else{$('#SDiff').val('1');}
            
        }else{
            $('#S1').val(L1);
        }
        
    });
    
    $('#S2' ).change(function(){
        if($('#S2').val()!=''){
           if( parseFloat( $('#S2').val())==parseFloat( $('#S1').val()) && parseFloat( $('#S2').val())==parseFloat( $('#S3').val()))
           { $('#SDiff').val('0'); }else{$('#SDiff').val('1');}
            
        }else{
            $('#S2').val(L1);
        }
        
    });
    
    $('#S3' ).change(function(){
        if($('#S3').val()!=''){
           if( parseFloat( $('#S3').val())==parseFloat( $('#S1').val()) && parseFloat( $('#S3').val())==parseFloat( $('#S2').val()))
           { $('#SDiff').val('0'); }else{$('#SDiff').val('1');}
            
        }else{
            $('#S3').val(L1);
        }
        
    });

    
    $('#D1' ).change(function(){
        if($('#D1').val()!=''){
           if( parseFloat( $('#D1').val())==parseFloat( $('#D2').val()) )
           { $('#DDiff').val('0'); }else{$('#DDiff').val('1');}
            
        }else{
            $('#D1').val(L1);
        }
        
    });
    
    $('#D2' ).change(function(){
        if($('#D2').val()!=''){
           if( parseFloat( $('#D2').val())==parseFloat( $('#D1').val()) )
           { $('#DDiff').val('0'); }else{$('#DDiff').val('1');}
            
        }else{
            $('#D2').val(L1);
        }
        
    });
    </script>
 @endpush
