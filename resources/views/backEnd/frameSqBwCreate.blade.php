


@extends('layouts.app')
  
@section('content')



<div class="row">
    <div class="container">
     
           
       
    
    <div class="row">
        <div class = "col-sm-12" >          
        <div class="card">
        <div class="card-header">Frame Squareness and Bowing Qual Monitoring</div> 
 
            
                <br/>
                {!! Form::open(['action' => 'SqBwController@store','method' => 'POST']) !!}
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
                                                       <div class = "col-sm-3">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                                       <div class="col-sm-9">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control form-control-sm'] )}}  </div>
                                               </div></div>
                                               
                                <div class = "col-sm-3"> 
                                        <div class = "row">
                                <div class = "col-sm-2">  {{Form::label('qualtime','Qual Time'),['class'=>'form-control form-control-sm']}} </div>
                                    <div class = "col-sm-3">   {{ Form::text('qualTime', '',['class'=>'timepicker form-control form-control-sm','placeholder'=>'00:00','style'=>'padding:0;padding-bottom:0.3em;padding-top:0.3em'] )}}  
                                        <small class="form-text text-danger">{{ $errors->first('qualTime') }}</small>
                                      
                                    </div>
                                         <div class = "col-sm-2">    {{Form::label('Cell Type'),['class'=>'form-control form-control-sm']}}  </div>
                                         <div class="col-sm-5">       {{Form::select('cellType', array('72' => '72 cell', '60' => '60 cell'), 'S',['class'=>'cellType form-control form-control-sm']) }} </div>
                                        </div></div>
                                   

                            

                                
                                <div class = "col-sm-3"> 
                                                <div class = "row">
                                                        <div class = "col-sm-3">    {{Form::label('SerialNo',''),['class'=>'form-control']}}  </div>
                                                        <div class="col-sm-8">      {{ Form::text('serialNoTxt', '',['class'=>'form-control form-control-sm','id'=>'serialNo'] )}}   
                                                           
                                                            <small class="form-text text-danger">{{ $errors->first('serialNoTxt') }}</small>
                                                            {{Form::hidden('transID','1'),['class'=>'form-control form-control-sm']}} 
                                                         </div>
                                                       
                                                </div></div>

                                <div class = "col-sm-1"></div> 

                               
                       
                        </div>
                        <br/>
                        
                        <div class = "row">
                                <div class="col-sm-1">  </div>
                                <div class = "col-sm-4"> 
                                    <div class="row">
                                           
                                            <div class="col-sm-3">      {{Form::label('L1','L1'),['class'=>'form-control form-control-sm']}} </div>
                                            <div class = "col-sm-3">    {{Form::label('L2','L2'),['class'=>'form-control form-control-sm']}}    </div>
                                            <div class="col-sm-3">      {{Form::label('L3','L3'),['class'=>'form-control form-control-sm']}}  </div>
                                            <div class = "col-sm-3">    {{Form::label('Diff','L-Diff'),['class'=>'form-control form-control-sm']}}  </div>
                                    </div>
                                </div>
                                <div class = "col-sm-4"> 
                                    <div class="row">
                                           
                                            <div class="col-sm-3">      {{Form::label('S1','S1'),['class'=>'form-control form-control-sm']}} </div>
                                            <div class = "col-sm-3">    {{Form::label('S2','S2'),['class'=>'form-control form-control-sm']}}    </div>
                                            <div class="col-sm-3">      {{Form::label('S3','S3'),['class'=>'form-control form-control-sm']}}  </div>
                                            <div class = "col-sm-3">    {{Form::label('Diff','S-Diff'),['class'=>'form-control form-control-sm']}}  </div>
                                    </div>
                                </div>
                                <div class = "col-sm-3"> 
                                    <div class="row">
                           
                                            <div class="col-sm-4">      {{Form::label('D1','D1'),['class'=>'form-control form-control-sm']}} </div>
                                            <div class = "col-sm-4">    {{Form::label('D2','D2'),['class'=>'form-control form-control-sm']}}    </div>
                                            <div class = "col-sm-3">    {{Form::label('Diff','D-Diff'),['class'=>'form-control form-control-sm']}}  </div>
                                            <div class="col-sm-1">  </div>
                                    </div>
                                </div>
                        </div>


                        <div class = "row">
                                <div class="col-sm-1">  </div>
                                <div class = "col-sm-4"> 
                                    <div class="row">
                                         
                                            <div class="col-sm-3">     {{ Form::text('L1txt', '',['class'=>'form-control form-control-sm','id'=>'L1'] )}}  <small class="form-text text-danger">{{ $errors->first('L1txt') }}</small> </div>
                                            <div class = "col-sm-3">   {{ Form::text('L2txt', '',['class'=>'form-control form-control-sm','id'=>'L2'] )}}  <small class="form-text text-danger">{{ $errors->first('L2txt') }}</small>    </div>
                                            <div class="col-sm-3">     {{ Form::text('L3txt', '',['class'=>'form-control form-control-sm','id'=>'L3'] )}}   <small class="form-text text-danger">{{ $errors->first('L3txt') }}</small>  </div>
                                            <div class = "col-sm-3">    {{ Form::text('LDiff', '0',['class'=>'form-control form-control-sm', 'id'=>'LDiff','readonly'=>'true'] )}}   </div>
                                    </div>
                                </div>
                                <div class = "col-sm-4"> 
                                    <div class="row">
                                        <div class="col-sm-3">     {{ Form::text('S1txt', '',['class'=>'form-control form-control-sm','id'=>'S1'] )}}  <small class="form-text text-danger">{{ $errors->first('S1txt') }}</small>  </div>
                                        <div class = "col-sm-3">   {{ Form::text('S2txt', '',['class'=>'form-control form-control-sm','id'=>'S2'] )}}   <small class="form-text text-danger">{{ $errors->first('S2txt') }}</small>  </div>
                                        <div class="col-sm-3">     {{ Form::text('S3txt', '',['class'=>'form-control form-control-sm','id'=>'S3'] )}}   <small class="form-text text-danger">{{ $errors->first('S3txt') }}</small> </div>
                                        <div class = "col-sm-3">    {{ Form::text('SDiff', '0',['class'=>'form-control form-control-sm','id'=>'SDiff','readonly'=>'true'] )}}   </div>
                                    </div>
                                </div>
                                <div class = "col-sm-3"> 
                                    <div class="row" style="align:left">
                                        <div class="col-sm-4">     {{ Form::text('D1txt', '',['class'=>'form-control form-control-sm','id'=>'D1'] )}}   <small class="form-text text-danger">{{ $errors->first('D1txt') }}</small> </div>
                                        <div class = "col-sm-4">   {{ Form::text('D2txt', '',['class'=>'form-control form-control-sm','id'=>'D2'] )}}    <small class="form-text text-danger">{{ $errors->first('D2txt') }}</small> </div>
                                        <div class = "col-sm-3">    {{ Form::text('DDiff', '0',['class'=>'form-control form-control-sm','id'=>'DDiff', 'readonly'=>'true'] )}}   </div>
                                        <div class="col-sm-1">  </div>
                                    </div>
                                </div>
                        </div>
                        
   <br/>
  
                <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   {{Form::label('Remarks','Remarks'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class= "col-sm-9">    {{ Form::text('remarkstxt', 'Remarks',['class'=>'form-control form-control-sm']) }} </div>
                    
                           
                               
                                <div class = "col-sm-1"> </div>
                      
                        </div>
                    <br/>
                    &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/Framming" class="btn btn-danger">Cancel</a>
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
        <div class="card-header">Last Qual Records</div> 
        <div class="card-body">
            

        <table class="table table-striped" style="font-size:12px;">
        <tr>
            <th>Seq</th>
            <th>Date</th>
            <th>Time</th>
            <th>Shift</th>
            <th>Serial</th>
            <th>L1</th>
            <th>L2</th>
            <th>L3</th>
            <th>L-Diff</th>
            <th>S1</th>
            <th>S2</th>
            <th>S3</th>
            <th>S-Diff</th>
            <th>D1</th>
            <th>D2</th>
            <th>D-Diff</th>
            <th>Remarks</th>
        </tr>

         
            @if(count($frameSBLogs) > 0)
            @foreach($frameSBLogs as $potLog)
             <tr>
                <td>{{$potLog->id}}</td>
                <td>{{$potLog->date}}</td>
                <td>{{$potLog->qualTime}}</td>
                <td>{{$potLog->shift}}</td>
                <td>{{$potLog->moduleID}}</td>
                <td>{{$potLog->L1}}</td>
                <td>{{$potLog->L2}}</td>
                <td>{{$potLog->L3}}</td>
                <td>{{$potLog->LDiff}}</td>
                <td>{{$potLog->S1}}</td>
                <td>{{$potLog->S2}}</td>
                <td>{{$potLog->S3}}</td>
                <td>{{$potLog->SDiff}}</td>
                <td>{{$potLog->D1}}</td>
                <td>{{$potLog->D2}}</td>
                <td>{{$potLog->DDiff}}</td>
                <td>{{$potLog->remarks}}</td>
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

     var L1 = 0;
     var L2 = 0;
     var L3 = 0;


    
    JQUERY4U = {
	getDiff43: function(L1,L2,L3) {
            
        var L1val = parseFloat(L1);
        var L2val = parseFloat(L2);
        var L3val = parseFloat(L3);
        if(L1val == L2val && L1val == L3val){
            return 0;
        }else if(L1val < L2val && L2val > L3val && L1val == L3val){
            return 1;
        }else if(L1val > L2val && L2val < L3val && L1val == L3val ){
            return -1;
        }else if(L1val >= L2val && L2val == L3val){
            return 0;
        }else if(L1val == L2val && L2val <= L3val){
            return 0;
        }else if(L1val <= L2val && L2val == L3val){
            return 0;
        }else if(L1val == L2val && L2val >= L3val){
            return 0;
        }else if(L1val < L2val && L2val > L3val && L1val > L3val){
            return 1;
        }else if(L1val < L2val && L2val > L3val && L1val < L3val){
            return 1;
        }else if(L1val > L2val && L2val < L3val && L1val > L3val){
            return -1;
        }else if(L1val > L2val && L2val < L3val && L1val < L3val){
            return -1;
        }else{
            return 0;
        }
	},
    getDiff42: function(D1,D2) {
            
            var D1val = parseFloat(D1);
            var D2val = parseFloat(D2);
            var diff  = parseFloat(0);
            if(D1val == D2val ){
                return 0;
            }else if(D1val < D2val ){
               diff  = D2val - D1val;
                return diff;
            }else if(D1val > D2val ){
                diff  = D1val - D2val;
                return diff;
            }
        }

}

     $(document).ready(function () {
        $('.cellType' ).val('72');
       // $('.cellType' ).val('60');


   //for 72 cell
             $('#L1').val('1956');
            $('#L2').val('1956');
            $('#L3').val('1956');
            $('#S1').val('990');
            $('#S2').val('990');
            $('#S3').val('990');
            $('#D1').val('2190');
            $('#D2').val('2190');
   //for 60 cell   
      /*      $('#L1').val('1640');
            $('#L2').val('1640');
            $('#L3').val('1640');
            $('#S1').val('990');
            $('#S2').val('990');
            $('#S3').val('990');
            $('#D1').val('1915');
            $('#D2').val('1915');
      */
     });

    $('#L1').keyup(function(){
        var L1 = $('#L1').val();
        var L2 = $('#L2').val();
        var L3 = $('#L3').val();
        var val = JQUERY4U.getDiff43(L1,L2,L3);
        $('#LDiff').val(val);
       
    });
    
    $('#L2' ).keyup(function(){
        var L1 = $('#L1').val();
        var L2 = $('#L2').val();
        var L3 = $('#L3').val();
        var val = JQUERY4U.getDiff43(L1,L2,L3);
        $('#LDiff').val(val);
        
      
    });
    
    $('#L3' ).keyup(function(){
      
        var L1 = $('#L1').val();
        var L2 = $('#L2').val();
        var L3 = $('#L3').val();
        var val = JQUERY4U.getDiff43(L1,L2,L3);
        $('#LDiff').val(val);
            
       
        
    });


    $('#S1' ).keyup(function(){
       
        var S1 = $('#S1').val();
        var S2 = $('#S2').val();
        var S3 = $('#S3').val();
        var val = JQUERY4U.getDiff43(S1,S2,S3);
        $('#SDiff').val(val);
        
    });
    
    $('#S2' ).keyup(function(){
       
        var S1 = $('#S1').val();
        var S2 = $('#S2').val();
        var S3 = $('#S3').val();
        var val = JQUERY4U.getDiff43(S1,S2,S3);
        $('#SDiff').val(val);
        
    });
    
    $('#S3' ).keyup(function(){
         
        var S1 = $('#S1').val();
        var S2 = $('#S2').val();
        var S3 = $('#S3').val();
        var val = JQUERY4U.getDiff43(S1,S2,S3);
        $('#SDiff').val(val);
    });

    
    $('#D1' ).keyup(function(){
      
        var D1 = $('#D1').val();
        var D2 = $('#D2').val();
     
        var val = JQUERY4U.getDiff42(D1,D2);
        $('#DDiff').val(val);
    });
    
    $('#D2' ).keyup(function(){
        var D1 = $('#D1').val();
        var D2 = $('#D2').val();
     
        var val = JQUERY4U.getDiff42(D1,D2);
        $('#DDiff').val(val);
        
    });

     $('.cellType' ).change(function(){
        if( $('.cellType' ).val()=='72')
        {
            $('#L1').val('1956');
            $('#L2').val('1956');
            $('#L3').val('1956');
            $('#S1').val('990');
            $('#S2').val('990');
            $('#S3').val('990');
            $('#D1').val('2190');
            $('#D2').val('2190');
        }
        if( $('.cellType' ).val()=='60')
        {
            $('#L1').val('1640');
            $('#L2').val('1640');
            $('#L3').val('1640');
            $('#S1').val('990');
            $('#S2').val('990');
            $('#S3').val('990');
            $('#D1').val('1915');
            $('#D2').val('1915');
        }
    });
    </script>
 @endpush
