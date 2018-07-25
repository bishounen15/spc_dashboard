


@extends('layouts.app')
  
@section('content')

<div class="container">

        <div class="row">
    <div class="col-12">
 
       
           
                <div class="card">
            <div class="card-header">J-Box Solder Temperature Monitoring</div> 
           
                
                 <br/>
                    {!! Form::open(['action' => 'solderTempController@store','method' => 'POST']) !!}
                    <div class="form-group">


                                <div class = "row"  style="font-size:11px;">
                                                <div class = "col-sm-1"> </div>

                                                <div class = "col-sm-4"> 
                                                <div class = "row">
                                                <div class = "col-sm-1">    {{Form::label('Shift','Shift'),['class'=>'form-control']}}  </div>
                                                <div class="col-sm-4">      {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control form-control-sm'])}} </div>
                                                <div class = "col-sm-1">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                                <div class="col-sm-6">     {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control form-control-sm'] )}}  </div>
                                                </div>
                                                </div>

                                            
                                            
                                               

                                                <div class = "col-sm-6"> 
                                                <div class = "row">
                                                <div class = "col-sm-1">  {{Form::label('qualtime','Qual Time'),['class'=>'form-control form-control-sm']}} </div>
                                                <div class = "col-sm-2">   {{ Form::text('qualTime', '',['class'=>'timepicker form-control form-control-sm','placeholder'=>'00:00','style'=>'padding:0;padding-bottom:0.3em;padding-top:0.3em'] )}}    
                                                        <small class="form-text text-danger">{{ $errors->first('qualTime') }}</small>                         
                                                        {{ Form::hidden('qualTransID', '1',['class'=>'form-control form-control-sm'] )}}
                                                </div>
                                                <div class = "col-sm-2">    {{Form::label('J-Box'),['class'=>'form-control form-control-sm']}}  </div>
                                                <div class="col-sm-4">      {{Form::select('jBox', array('380' => 'SUNTER'), 'S',['class'=>'jBox form-control form-control-sm']) }}  {{ Form::hidden('jBoxName', '',['class'=>'jBoxName form-control form-control-sm'] )}} </div>
                                                <div class = "col-sm-1">  {{Form::label('Target','Target'),['class'=>'form-control form-control-sm']}} </div>
                                                <div class = "col-sm-2">   {{ Form::text('target', '',['class'=>'target form-control form-control-sm'] )}} {{ Form::hidden('ULLL', '10',['class'=>'ULLL form-control form-control-sm'] )}}  </div> 
                                                </div></div>
                                                   
                                                
                                                
                                                <div class = "col-sm-1"></div> 
                
                                               
                                       
                                 </div>

                                        <div class = "row" style="font-size:11px;">
                                                        <div class="col-sm-1">  </div>
                                                        <div class = "col-sm-5"> 
                                                            <div class="row">
                                                                 
                                                                    <div class="col-sm-3">     {{Form::label('','Adjustment Before Temp 1'),['class'=>'form-control form-control-sm']}}   </div>
                                                                    <div class = "col-sm-3">   {{ Form::label('', 'Adjustment Before Temp 2'),['class'=>'form-control form-control-sm']}}      </div>
                                                                    <div class="col-sm-3">     {{ Form::label('', 'Adjustment Before Temp 3'),['class'=>'form-control form-control-sm']}}      </div>
                                                                    <div class = "col-sm-3">   {{ Form::label('', 'Adjustment Before Temp Ave'),['class'=>'form-control form-control-sm']}}     </div>
                                                            </div>
                                                        </div>
                                                        <div class = "col-sm-5"> 
                                                            <div class="aftHead row">
                                                                        <div class="col-sm-3">     {{Form::label('','Adjustment After Temp 1'),['class'=>'form-control form-control-sm']}}   </div>
                                                                        <div class = "col-sm-3">   {{ Form::label('', 'Adjustment After Temp 2'),['class'=>'form-control form-control-sm']}}      </div>
                                                                        <div class="col-sm-3">     {{ Form::label('', 'Adjustment After Temp 3'),['class'=>'form-control form-control-sm']}}      </div>
                                                                        <div class = "col-sm-3">   {{ Form::label('', 'Adjustment After Temp Ave'),['class'=>'form-control form-control-sm']}}     </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">  </div>
                                                </div>
                                        
                                        <div class = "row">
                                                        <div class="col-sm-1">  </div>
                                                        <div class = "col-sm-5"> 
                                                            <div class="row">
                                                                 
                                                                    <div class="col-sm-3">     {{ Form::text('AdjBeftTmp1', '',['class'=>'form-control form-control-sm','id'=>'AdjBeftTmp1'] )}} <small class="form-text text-danger">{{ $errors->first('AdjBeftTmp1') }}</small>  </div>
                                                                    <div class = "col-sm-3">   {{ Form::text('AdjBeftTmp2', '',['class'=>'form-control form-control-sm','id'=>'AdjBeftTmp2'] )}} <small class="form-text text-danger">{{ $errors->first('AdjBeftTmp2') }}</small>  </div>
                                                                    <div class="col-sm-3">     {{ Form::text('AdjBeftTmp3', '',['class'=>'form-control form-control-sm','id'=>'AdjBeftTmp3'] )}}  <small class="form-text text-danger">{{ $errors->first('AdjBeftTmp3') }}</small> </div>
                                                                    <div class = "col-sm-3">   {{ Form::text('AdjBeftAve', '0',['class'=>'form-control form-control-sm', 'id'=>'AdjBeftAve','readonly'=>'true'] )}}   </div>
                                                            </div>
                                                        </div>
                                                        <div class = "col-sm-5"> 
                                                            <div class="aftVal row" >
                                                                        <div class="col-sm-3">     {{ Form::text('AdjAftTmp1', '0',['class'=>'form-control form-control-sm','id'=>'AdjAftTmp1'] )}} <small class="form-text text-danger">{{ $errors->first('AdjAftTmp1') }}</small> </div>
                                                                        <div class = "col-sm-3">   {{ Form::text('AdjAftTmp2', '0',['class'=>'form-control form-control-sm','id'=>'AdjAftTmp2'] )}} <small class="form-text text-danger">{{ $errors->first('AdjAftTmp2') }}</small>  </div>
                                                                        <div class="col-sm-3">     {{ Form::text('AdjAftTmp3', '0',['class'=>'form-control form-control-sm','id'=>'AdjAftTmp3'] )}}  <small class="form-text text-danger">{{ $errors->first('AdjAftTmp3') }}</small> </div>
                                                                        <div class = "col-sm-3">   {{ Form::text('AdjAftAve', '0',['class'=>'form-control form-control-sm', 'id'=>'AdjAftAve','readonly'=>'true'] )}}   </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">  </div>
                                                </div>
                                                

                                                <br/>

                <div class = "row" style="font-size:12px;">
                               
                <div class="col-sm-1">  </div>              
                <div class="col-sm-1"> {{Form::label('remarks','Qual Result'),['class'=>'form-control form-control-sm']}} </div>
                <div class="col-sm-2">   {{ Form::text('qualRes', '',['class'=>'form-control form-control-sm','id'=>'qualRes','readonly'=>'true']) }} </div>
                                                       
                                        
                <div class = "col-sm-1">    {{Form::label('remark','Remarks'),['class'=>'form-control form-control-sm']}}  </div>
                <div class="col-sm-6">      {{Form::text('remarks', '',['class'=>'form-control form-control-sm','id'=>'remarks'] )}}   </div>
                <div class="col-sm-1">  </div>
                </div>

              
            <br/>
          
                    </div>
                    
                    &emsp;&emsp;&emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}} &emsp; <a href="/SolderTemp" class="btn btn-danger">Cancel</a>
                    {!! Form::close() !!}

            <br/>
            </div>
          
            </div>

            <div class="row">
                <div class="col-md-12">
                        <div class="card">
                                <div class="card-header" >Last Qual Record</div> 
                         
                <div>
                        <table class="table table-striped" style="font-size:10px;">
                                <tr>
                                    <th>Seq</th>
                                    <th>Shift</th>
                                    <th>Qual Time</th>
                                    <th>Date</th>
                                    <th>Temp Before <br/> Adjustment 1</th>
                                    <th>Temp Before <br/> Adjustment 2</th>
                                    <th>Temp Before <br/> Adjustment 3</th>
                                    <th>Temp Before <br/> Adj. Ave</th>
                                    <th>Temp After  <br/>Adjustment 1</th>
                                    <th>Temp After  <br/>Adjustment 2</th>
                                    <th>Temp After  <br/>Adjustment 3</th>
                                    <th>Temp After <br/> Adj. Ave</th>
                                    <th>J-Box</th>
                                    <th>Target</th>
                                    <th>Qual<br/>Result</th>
                                    <th>Remarks</th>
                                   
                                </tr>
                    
                                 
                                    @if(count($tempLogs) > 0)
                                    @foreach($tempLogs as $potLog)
                                     <tr>
                                        <td>{{$potLog->id}}</td>
                                        <td>{{$potLog->shift}}</td>
                                        <td>{{$potLog->qualTime}}</td>
                                        <td>{{$potLog->date}}</td>
                                        <td>{{$potLog->tempBefAdj1}}</td>
                                        <td>{{$potLog->tempBefAdj2}}</td>
                                        <td>{{$potLog->tempBefAdj3}}</td>
                                        <td>{{$potLog->tempBefAdjAve}}</td>
                                        <td>{{$potLog->tempAftAdj1}}</td>
                                        <td>{{$potLog->tempAftAdj2}}</td>
                                        <td>{{$potLog->tempAftAdj3}}</td>
                                        <td>{{$potLog->tempAftAdjAve}}</td>
                                        <td>{{$potLog->jBox}}</td>
                                        <td>{{$potLog->target}}</td>
                                        <td>{{$potLog->result}}</td>
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

 JQUERY4U = {
	getAve: function(L1,L2,L3) {
        var L1val = parseFloat(L1);
        var L2val = parseFloat(L2);
        var L3val = parseFloat(L3);
        var ave = 0;

        ave = parseFloat((L1val + L2val + L3val)/3).toFixed(0);

        return ave;

        },
        getQualRes: function(ave,target,uLlL){
                var targetUL =  parseFloat(target) +  parseFloat(uLlL);
                var targetLL =  parseFloat(target) -  parseFloat(uLlL);
                if(targetLL <= ave && ave <= targetUL){
                 return "passed";
                }else {
                 return "failed";
                }
               
        },
        checkPassFail: function(resQual){
                if( resQual =='passed'){
                        $('#AdjAftTmp1').attr('readonly',true);
                        $('#AdjAftTmp2').attr('readonly',true);
                        $('#AdjAftTmp3').attr('readonly',true);
                     
                      // $('#AdjAftTmp1').attr('style','background-color:#F08080');
                }
                if(resQual =='failed'){
                        $('#AdjAftTmp1').attr('readonly',false);
                        $('#AdjAftTmp2').attr('readonly',false);
                        $('#AdjAftTmp3').attr('readonly',false);
                      //  $('#AdjAftTmp1').val('');
                      //  $('#AdjAftTmp2').val('');
                     //   $('#AdjAftTmp3').val('');
                      //  alert( $('#AdjAftTmp1').attr('readonly'));
                     // $('#AdjAftTmp1').attr('style','background-color:#F08080');
                }
        },
        //checkEaachAveVal: function()
     


        }

 $(document).ready(function () {
        
         $('.target').val('380');
         $('.target').attr('readonly',true);
         $('.jBox').val('380');

         // $('#AdjAftTmp1').val('');
          //              $('#AdjAftTmp2').val('');
           //             $('#AdjAftTmp3').val('');
        //    $('#AdjAftTmp1').attr('readonly',true);
         //   $('#AdjAftTmp2').attr('readonly',true);
         //  $('#AdjAftTmp3').attr('readonly',true);
 });


  $('#AdjBeftTmp1').keyup(function(){
        var A1 = $('#AdjBeftTmp1').val();
        var A2 = $('#AdjBeftTmp2').val();
        var A3 = $('#AdjBeftTmp3').val();
        var target = $('.target').val();
        var uLlL = $('.ULLL').val();
        var resQual = '';
        var val = JQUERY4U.getAve(A1,A2,A3);
        $('#AdjBeftAve').val(val);
        resQual = JQUERY4U.getQualRes(val,target,uLlL);
        $('#qualRes').val(resQual);
        JQUERY4U.checkPassFail( $('#qualRes').val());
        $('.jBoxName').val( $('.jBox').text());

        
    /*   if(  $('#qualRes').val() =='passed')
                {
                        $('#AdjAftTmp1').attr('readonly','true');
                        $('#AdjAftTmp2').attr('readonly','true');
                        $('#AdjAftTmp3').attr('readonly','true');
                }else if(resqual =='failed'){
                        $('#AdjAftTmp1').attr('readonly','false');
                        $('#AdjAftTmp2').attr('readonly','false');
                        $('#AdjAftTmp3').attr('readonly','false');
                }
                */
    });

    $('#AdjBeftTmp2').keyup(function(){
        var A1 = $('#AdjBeftTmp1').val();
        var A2 = $('#AdjBeftTmp2').val();
        var A3 = $('#AdjBeftTmp3').val();
        var target = $('.target').val();
        var uLlL = $('.ULLL').val();
        var resQual = '';
        var val = JQUERY4U.getAve(A1,A2,A3);
        $('#AdjBeftAve').val(val);
        resQual = JQUERY4U.getQualRes(val,target,uLlL);
        $('#qualRes').val(resQual);
        JQUERY4U.checkPassFail( $('#qualRes').val());
        $('.jBoxName').val( $('.jBox').text());
       
    });
    
    $('#AdjBeftTmp3').keyup(function(){
        var A1 = $('#AdjBeftTmp1').val();
        var A2 = $('#AdjBeftTmp2').val();
        var A3 = $('#AdjBeftTmp3').val();
        var target = $('.target').val();
        var uLlL = $('.ULLL').val();
        var resQual = '';
        var val = JQUERY4U.getAve(A1,A2,A3);
        $('#AdjBeftAve').val(val);
        resQual = JQUERY4U.getQualRes(val,target,uLlL);
        $('#qualRes').val(resQual);
        JQUERY4U.checkPassFail( $('#qualRes').val());
        $('.jBoxName').val( $('.jBox').text());
    });


    //// After Adjustment

     $('#AdjAftTmp1').keyup(function(){
        var A1 = $('#AdjAftTmp1').val();
        var A2 = $('#AdjAftTmp2').val();
        var A3 = $('#AdjAftTmp3').val();
        var target = $('.target').val();
        var uLlL = $('.ULLL').val();
        var resQual = '';
        var val = JQUERY4U.getAve(A1,A2,A3);
        $('#AdjAftAve').val(val);
        resQual = JQUERY4U.getQualRes(val,target,uLlL);
        $('#qualRes').val(resQual);
        JQUERY4U.checkPassFail( $('#qualRes').val());
        $('.jBoxName').val( $('.jBox').text());

        
   
    });
    $('#AdjAftTmp2').keyup(function(){
        var A1 = $('#AdjAftTmp1').val();
        var A2 = $('#AdjAftTmp2').val();
        var A3 = $('#AdjAftTmp3').val();
        var target = $('.target').val();
        var uLlL = $('.ULLL').val();
        var resQual = '';
        var val = JQUERY4U.getAve(A1,A2,A3);
        $('#AdjAftAve').val(val);
        resQual = JQUERY4U.getQualRes(val,target,uLlL);
        $('#qualRes').val(resQual);
        JQUERY4U.checkPassFail( $('#qualRes').val());
        $('.jBoxName').val( $('.jBox').text());
    });
    
    $('#AdjAftTmp3').keyup(function(){
        var A1 = $('#AdjAftTmp1').val();
        var A2 = $('#AdjAftTmp2').val();
        var A3 = $('#AdjAftTmp3').val();
        var target = $('.target').val();
        var uLlL = $('.ULLL').val();
        var resQual = '';
        var val = JQUERY4U.getAve(A1,A2,A3);
        $('#AdjAftAve').val(val);
        resQual = JQUERY4U.getQualRes(val,target,uLlL);
        $('#qualRes').val(resQual);
        JQUERY4U.checkPassFail( $('#qualRes').val());
        $('.jBoxName').val( $('.jBox').text());
    });


    

    

    
    </script>
 @endpush
