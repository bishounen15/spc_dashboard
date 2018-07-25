


@extends('layouts.app')
  
@section('content')



<div class="container">
    
        <div class="col-12">
     
           
       
    

           
    <div class="row"  >
               
        <div class="card">
        <div class="card-header">J-Box Dispense Weight Monitoring</div> 
 <br/>
                {!! Form::open(['action' => 'JBoxController@store','method' => 'POST']) !!}
                <div class="form-group" style="font-size:12px;">

                                <div class = "row">
                                                <div class = "col-sm-1"> </div>

                                                <div class = "col-sm-3"> 
                                                                <div class = "row">
                                                                        <div class = "col-sm-3">    {{Form::label('date','Date'),['class'=>'form-control']}}  </div>
                                                                        <div class="col-sm-9">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control form-control-sm'] )}}  </div>
                                                                </div>
                                                </div>

                                                <div class = "col-sm-2"> 
                                                        <div class = "row">
                                                           <div class = "col-sm-3">    {{Form::label('Shift','Shift'),['class'=>'form-control']}}  </div>
                                                       <div class="col-sm-9">      {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'), 'S',['class'=>'form-control form-control-sm'])}} </div>
                                                        </div>
                                                 </div>
                           
                                                               
                                                <div class = "col-sm-4"> 
                                                        <div class = "row">
                                                <div class = "col-sm-2">  {{Form::label('qualtime','Qual Time'),['class'=>'form-control form-control-sm']}} </div>
                                                    <div class = "col-sm-3">   {{ Form::text('qualTime', '',['class'=>'timepicker form-control form-control-sm','placeholder'=>'00:00','style'=>'padding:0;padding-bottom:0.3em;padding-top:0.3em'] )}}  
                                                        <small class="form-text text-danger">{{ $errors->first('qualTime') }}</small>
                                                    </div>
                                                         <div class = "col-sm-3">    {{Form::label('Type'),['class'=>'form-control form-control-sm']}}  </div>
                                                         <div class="col-sm-4">       {{Form::select('type', array('13' => 'Pail', '11.5' => 'Sausage'), 'S',['class'=>'type form-control form-control-sm']) }} </div>
                                                        </div>
                                                </div>
                                                   
                
                                                <div class = "col-sm-2"> 
                                                                <div class = "row">
                                                                        <div class = "col-sm-3">    {{Form::label('Target',''),['class'=>'form-control']}}  </div>
                                                                        <div class="col-sm-6">      {{ Form::text('target', '',['class'=>'target form-control form-control-sm','readonly'=>'true'] )}}   
                                                                           
                                                                            <small class="form-text text-danger">{{ $errors->first('serialNoTxt') }}</small>
                                                                            {{Form::hidden('transID','1'),['class'=>'form-control form-control-sm']}} 
                                                                         </div>
                                                                         <div class = "col-sm-2"></div>
                                                                </div>
                                                </div>
                                                <div class = "col-sm-1"></div>       
                                </div>

                                <div class = "row">
                                                <div class = "col-sm-1"> </div>

                                                <div class = "col-sm-3"> 
                                                                <div class = "row">
                                                                   <div class = "col-sm-3">    {{Form::label('JBox','JBox'),['class'=>'form-control']}}  </div>
                                                               <div class="col-sm-9">      {{Form::select('jBox', array('sunter' => 'Sunter'), 'S',['class'=>'jBox form-control form-control-sm'])}} </div>
                                                                </div>
                                                         </div>

                                                <div class = "col-sm-2"> 
                                                        <div class = "row">
                                                           <div class = "col-sm-3">    {{Form::label('Sealant','Sealant'),['class'=>'form-control']}}  </div>
                                                       <div class="col-sm-9">      {{Form::select('sealant', array('Tonsan' => 'Tonsan'), 'S',['class'=>'sealant form-control form-control-sm'])}} </div>
                                                        </div>
                                                 </div>
                           
                                                               
                                                <div class = "col-sm-4"> 
                                                        <div class = "row">
                                                <div class = "col-sm-2">  {{Form::label('beadWt','Bead Wt.'),['class'=>'form-control form-control-sm']}} </div>
                                                    <div class = "col-sm-3">   {{ Form::text('beadWt', '0',['class'=>'beadWt form-control form-control-sm'] )}}  
                                                        <small class="form-text text-danger">{{ $errors->first('beadWt') }}</small>
                                                    </div>
                                                         <div class = "col-sm-3">    {{Form::label('cdaPressure','CDA/Robot Pressure'),['class'=>'cdaLabel form-control form-control-sm']}}  </div>
                                                         <div class="col-sm-4">      {{ Form::text('cdaPressure', '0',['class'=>'cdaPressure form-control form-control-sm'] ) }} </div>
                                                        </div>
                                                </div>
                                                   
                
                                                <div class = "col-sm-2"> 
                                                                <div class = "row">
                                                                        <div class = "col-sm-3">    {{Form::label('mainCDASupply','Main CDA Supply'),['class'=>'form-control']}}  </div>
                                                                        <div class="col-sm-6">      {{ Form::text('mainCDASup', '0',['class'=>'mainCDASup form-control form-control-sm'] )}}   
                                                                           
                                                                       
                
                                                                         </div>
                                                                         <div class = "col-sm-2"></div>
                                                                </div>
                                                </div>
                                                <div class = "col-sm-1"></div>       
                                </div>
                               
                                <div class = "row">
                                                <div class = "col-sm-1"> </div>

                                                <div class = "col-sm-3"> 
                                                                <div class = "row">
                                                                   <div class = "col-sm-3">     {{Form::label('RAMcda','RAM CDA'),['class'=>'form-control']}}   </div>
                                                               <div class="col-sm-9">     {{ Form::text('ramCDA', '0',['class'=>'ramCDA form-control form-control-sm'] )}}  </div>
                                                                </div>
                                                         </div>

                                                <div class = "col-sm-2"> 
                                                        <div class = "row">
                                                           <div class = "col-sm-3">   {{Form::label('downStream','Down Stream'),['class'=>'form-control']}}  </div>
                                                       <div class="col-sm-9">      {{ Form::text('downStream', '0',['class'=>'downStream form-control form-control-sm'] )}} </div>
                                                        </div>
                                                 </div>
                           
                                                               
                                                <div class = "col-sm-2"> 
                                                        <div class = "row">
                                                <div class = "col-sm-4">  {{Form::label('qualRes','Qual Res'),['class'=>'form-control form-control-sm']}} </div>
                                                    <div class = "col-sm-8">   {{ Form::text('result', '0',['class'=>'qualRes form-control form-control-sm'] )}}  
                                                      
                                                    </div>
                                                        
                                                        </div>
                                                </div>
                                                   
                
                                                <div class = "col-sm-4"> 
                                                                <div class = "row">
                                                                                <div class = "col-sm-2">  {{Form::label('remarks','Remarks'),['class'=>'form-control form-control-sm']}} </div>
                                                                                <div class = "col-sm-8">   {{ Form::text('remarks', '',['class'=>'remarks form-control form-control-sm'] )}}  </div>
                                                                       
                                                                                <div class = "col-sm-2"></div> 
                                                                         </div>
                                                                       
                                                 </div>
                                 </div>
                                               

                


             
                    <br/>
           
                    </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/JBox" class="btn btn-danger">Cancel</a>
                {!! Form::close() !!}
              <br/>
     
        </div>
      
        </div>


        <div class="row">
                <table class="table table-striped" style="font-size:12px;">
                        <tr>
                            <th>Seq</th>
                            <th>Shift</th>
                            <th>Date</th>
                            <th>Qual Time</th>
                            <th>JBox</th>
                            <th>Sealant</th>
                            <th>Target</th>
                            <th>Bead Wt.</th>
                            <th>CDA Pressure</th>
                            <th>Main CDA <br/> Supply</th>
                            <th>RAM CDA</th>
                            <th>Down <br/> Stream</th>
                            <th>Result</th>
                            <th>Remarks</th>
                        </tr>
            
                         <?php $i=0 ?>
                            @if(count($disLogs) > 0)
                            @foreach($disLogs as $potLog)
                            <?php $i++ ?>
                             <tr>
                                <td>{{ $i }}</td>
                                <td>{{$potLog->shift}}</td>
                                <td>{{$potLog->date}}</td>
                                <td>{{$potLog->qualTime}}</td>
                                <td>{{$potLog->jBox}}</td>
                                <td>{{$potLog->sealant}}</td>
                                <td>{{$potLog->target}}</td>
                                <td>{{$potLog->beadWt}}</td>
                                <td>{{$potLog->cdaPressure}}</td>
                                <td>{{$potLog->mainCDASupply}}</td>
                                <td>{{$potLog->RAMCDA}}</td>
                                <td>{{$potLog->downStream}}</td>
                                <td>{{$potLog->qualRes}}</td>
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

 @endsection

 
 @push('jscript')
 <script>

       $('.timepicker').datetimepicker({

format: 'HH:mm'

}); 

 $(document).ready(function () {
        
        $('.type select').val("13");
        $('.target').val("13");
});

 
 JQUERY4U = {
	checkBeadWt: function(beadWt,target) {
                var beadWtUL = parseFloat( target) + 1;
                var beadWtLL = parseFloat( target) - 1;
                if(beadWtLL <= beadWt && beadWt <= beadWtUL){
                        return "passed";
               // return beadWtUL;
               }else{
                 return "failed";
                }
        }

        }

         $('.type' ).change(function(){
                $('.target').val( $('.type').val() );
               var target = $('.type').val();
           if( target == '11.5'){
              $('.ramCDA').attr('readonly',true);
              $('.mainCDASup').attr('readonly',true);
              $('.downStream').attr('readonly',true);
           }
           if( target == '13'){
              $('.ramCDA').attr('readonly', false);
              $('.mainCDASup').attr('readonly', false);
              $('.downStream').attr('readonly', false);
           }
          
             

              
         });

         $('.beadWt').keyup(function(){
                 var beadWt = 0;
                 var target = 0;
                  beadWt =  $('.beadWt').val();
                  target =  $('.target').val();
            var res =  JQUERY4U.checkBeadWt(beadWt, target);
                $('.qualRes').val(res);
         });

        
  
    </script>
 @endpush