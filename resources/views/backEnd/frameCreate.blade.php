


@extends('layouts.app')
  
@section('content')



<div class="container">
    {{-- <div class="col-md-3">
    
            @include('backEnd.navs')
        </div> --}}
        <div class="col-md-12">
     
           
       
    

           
    <div class="row">
               
        <div class="card">
        <div class="card-header">Frame Qual Monitoring</div> 
 
            
                <h1>&emsp;Add Record</h1>
                {!! Form::open(['action' => 'FrameController@store','method' => 'POST']) !!}
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
                            <div class="col-sm-2">      {{Form::label('w/o Sealant','w/o Sealant'),['class'=>'form-control']}}   </div>
                            <div class = "col-sm-2">    {{Form::label('w/ Sealant','w/ Sealant'),['class'=>'form-control']}}   </div>
                            <div class="col-sm-2">      {{Form::label('Diff','Difference'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-1">    </div>
                            <div class = "col-sm-1">     </div>
                            <div class="col-sm-1">    </div>
                            <div class = "col-sm-1">    {{Form::hidden('transID','1'),['class'=>'form-control']}} </div>
                   
                    </div>
                    <div class = "row">
                        <div class = "col-sm-1"> </div>
                        <div class = "col-sm-1">   {{Form::label('L1','L1'),['class'=>'form-control']}}  </div>
                        <div class="col-sm-2">      {{ Form::text('L1woSealant', '0',['class'=>'form-control','id'=>'L1woSealant'] )}} </div>
                        <div class = "col-sm-2">    {{ Form::text('L1wSealant', '0',['class'=>'form-control','id'=>'L1wSealant'] )}} </div>
                        <div class="col-sm-2">     {{ Form::text('L1diff', '0',['class'=>'form-control','id'=>'L1diff','readonly'=>'true'] )}}  </div>
                        <div class="col-sm-1">     {{Form::label('Sum','Sum'),['class'=>'form-control']}}</div>
                        <div class = "col-sm-2">    {{ Form::text('sum', '0',['class'=>'form-control', 'id'=>'sum','readonly'=>'true'] )}}   </div>
                      
                        <div class = "col-sm-1">   </div>
               
                </div>
                <div class = "row">
                    <div class = "col-sm-1"> </div>
                    <div class = "col-sm-1">   {{Form::label('L2','L2'),['class'=>'form-control']}}  </div>
                    <div class="col-sm-2">     {{ Form::text('L2woSealant', '0',['class'=>'form-control','id'=>'L2woSealant'] )}}</div>
                    <div class = "col-sm-2">    {{ Form::text('L2wSealant', '0',['class'=>'form-control','id'=>'L2wSealant'] )}}    </div>
                    <div class="col-sm-2">     {{ Form::text('L2diff', '0',['class'=>'form-control','id'=>'L2diff','readonly'=>'true'] )}}  </div>
                    <div class="col-sm-1">     {{Form::label('Average','Average'),['class'=>'form-control']}}</div>
                    <div class = "col-sm-2">    {{ Form::text('ave', '0',['class'=>'form-control', 'id'=>'ave','readonly'=>'true'] )}}   </div>
                  
                    <div class = "col-sm-1">   </div>
           
            </div>
            <div class = "row">
                <div class = "col-sm-1"> </div>
                <div class = "col-sm-1">   {{Form::label('S1','S1'),['class'=>'form-control']}}  </div>
                <div class="col-sm-2">     {{ Form::text('S1woSealant', '0',['class'=>'form-control','id'=>'S1woSealant'] )}}  </div>
                <div class = "col-sm-2">   {{ Form::text('S1wSealant', '0',['class'=>'form-control', 'id'=>'S1wSealant'] )}}   </div>
                <div class="col-sm-2">     {{ Form::text('S1diff', '0',['class'=>'form-control','id'=>'S1diff','readonly'=>'true'] )}}  </div>
                <div class = "col-sm-2">      </div>
                <div class="col-sm-1">    </div>
                <div class = "col-sm-1">   </div>
       
        </div>

        <div class = "row">
            <div class = "col-sm-1"> </div>
            <div class = "col-sm-1">   {{Form::label('S2','S2'),['class'=>'form-control']}}  </div>
            <div class="col-sm-2">    {{ Form::text('S2woSealant', '0',['class'=>'form-control','id'=>'S2woSealant'] )}}  </div>
            <div class = "col-sm-2">  {{ Form::text('S2wSealant', '0',['class'=>'form-control','id'=>'S2wSealant'] )}}     </div>
            <div class="col-sm-2">     {{ Form::text('S2diff', '0',['class'=>'form-control','id'=>'S2diff','readonly'=>'true'] )}}  </div>
            <div class = "col-sm-2">      </div>
            <div class="col-sm-1">    </div>
            <div class = "col-sm-1">   </div>
   
    </div>
   <br/>
   <div class = "row">
    <div class = "col-sm-1"> </div>
    <div class = "col-sm-1">    {{Form::label('beadScale','Bead Scale'),['class'=>'form-control']}}  </div>
    <div class="col-sm-2">       {{ Form::text('beadScale', '0',['class'=>'form-control'] )}}  </div>
    <div class = "col-sm-1">    {{Form::label('facilitySupply','Facility Supply'),['class'=>'form-control']}}  </div>
    <div class="col-sm-3">      {{ Form::text('facilitySupply', '0',['class'=>'form-control'] )}}  </div>
    <div class = "col-sm-1">    {{Form::label('mainPressure','Main Pressure'),['class'=>'form-control']}}  </div>
    <div class="col-sm-2">      {{ Form::text('mainPressure', '0',['class'=>'form-control'] )}}  </div>
    <div class = "col-sm-1">    </div>

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
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/Frame" class="btn btn-danger">Cancel</a>
                {!! Form::close() !!}
              <br/>
     
        </div>
      
        </div>
    </div>      
    
    
</div>

 @endsection

 @push('jscript')
    <script>
        $(document).ready(function () {
      

        });
   //for L1woSealant diff-------------------------------------
       $('#L1woSealant' ).keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;
    var sum;

    textone = parseFloat($('#L1woSealant').val());
    texttwo = parseFloat($('#L1wSealant').val());
  
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
   
    }
    $('#L1diff').val(result.toFixed(2));
    l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());
    s1diff = parseFloat($('#S1diff').val());
    s2diff = parseFloat($('#S2diff').val());
    sum =  l1diff + l2diff + s1diff + s2diff;
    $('#sum').val(sum.toFixed(2));
    });

     //for L1wSealant diff---------------------------------------
   $('#L1wSealant').keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;
    var sum; 

    textone = parseFloat($('#L1woSealant').val());
    texttwo = parseFloat($('#L1wSealant').val());
   

    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
    
    }
    $('#L1diff').val(result.toFixed(2));

      l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());
    sum =  l1diff + l2diff;
     $('#sum').val(sum.toFixed(2));
    }); 
         //for L2woSealant diff--------------------------------
       $('#L2woSealant' ).keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;
    var sum

    textone = parseFloat($('#L2woSealant').val());
    texttwo = parseFloat($('#L2wSealant').val());

    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
    }
    $('#L2diff').val(result.toFixed(2));
    l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());
    s1diff = parseFloat($('#S1diff').val());
    s2diff = parseFloat($('#S2diff').val());
    sum =  l1diff + l2diff + s1diff + s2diff;
    $('#sum').val(sum.toFixed(2));
    });

     //for L2wSealant diff-------------------------------------
   $('#L2wSealant').keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;

    textone = parseFloat($('#L2woSealant').val());
    texttwo = parseFloat($('#L2wSealant').val());
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
    }
    $('#L2diff').val(result.toFixed(2));
    l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());
    s1diff = parseFloat($('#S1diff').val());
    s2diff = parseFloat($('#S2diff').val());
    sum =  l1diff + l2diff + s1diff + s2diff;
    $('#sum').val(sum.toFixed(2));
    }); 

     //for S1wSealant diff-------------------------------------
   $('#S1wSealant').keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;

    textone = parseFloat($('#S1woSealant').val());
    texttwo = parseFloat($('#S1wSealant').val());
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
    }
    $('#S1diff').val(result.toFixed(2));

    l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());  
    s1diff = parseFloat($('#S1diff').val());
    s2diff = parseFloat($('#S2diff').val());
    sum =  l1diff + l2diff + s1diff + s2diff;
    $('#sum').val(sum.toFixed(2));
    }); 

       //for S1woSealant diff-------------------------------------
   $('#S1woSealant').keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;

    textone = parseFloat($('#S1woSealant').val());
    texttwo = parseFloat($('#S1wSealant').val());
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
    }
    $('#S1diff').val(result.toFixed(2));

    l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());  
    s1diff = parseFloat($('#S1diff').val());
    s2diff = parseFloat($('#S2diff').val());
    sum =  l1diff + l2diff + s1diff + s2diff;
    $('#sum').val(sum.toFixed(2));
    }); 

       //for S2wSealant diff-------------------------------------
   $('#S2wSealant').keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;

    textone = parseFloat($('#S2woSealant').val());
    texttwo = parseFloat($('#S2wSealant').val());
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
    }
    $('#S2diff').val(result.toFixed(2));

    l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());  
    s1diff = parseFloat($('#S1diff').val());
    s2diff = parseFloat($('#S2diff').val());
    sum =  l1diff + l2diff + s1diff + s2diff;
    $('#sum').val(sum.toFixed(2));
    }); 

    //for S2woSealant diff-------------------------------------
   $('#S2woSealant').keyup(function(){
    var textone;
    var texttwo;
    var l1diff;
    var l2diff;
    var s1diff;
    var s2diff;

    textone = parseFloat($('#S2woSealant').val());
    texttwo = parseFloat($('#S2wSealant').val());
    if(texttwo==0){
        var result = 0;
    }else{
        var result = texttwo - textone;
    }
    $('#S2diff').val(result.toFixed(2));

    l1diff = parseFloat($('#L1diff').val());
    l2diff = parseFloat($('#L2diff').val());  
    s1diff = parseFloat($('#S1diff').val());
    s2diff = parseFloat($('#S2diff').val());
    sum =  l1diff + l2diff + s1diff + s2diff;
    $('#sum').val(sum.toFixed(2));
    }); 



  

  
    </script>
 @endpush