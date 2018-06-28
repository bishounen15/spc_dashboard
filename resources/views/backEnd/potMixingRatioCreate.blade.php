


@extends('layouts.app')
  
@section('content')



<div class="container">
    
     
    

           
       
    
       
           
    <div class="row">
        <div class="col-12">     
        <div class="card">
        <div class="card-header">Pottant Mixing Ratio Monitoring 

               
        </div> 
 
            <br/>
                {!! Form::open(['action' => 'MixRatioController@store','method' => 'POST']) !!}
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
                            <div class = "col-sm-3">   {{ Form::text('qualTime', '00:00',['class'=>'timepicker form-control form-control-sm','style'=>'padding:0;padding-bottom:0.3em;padding-top:0.3em'] )}}  
                              
                            </div>
                                 <div class = "col-sm-2">    {{Form::label('Ratio Range'),['class'=>'form-control form-control-sm']}}  </div>
                                 <div class="col-sm-5">    
                                     <div class="row">  
                                          <div class = "col-sm-6"> 
                                         {{ Form::text('ratioFrom', '5.8',['class'=>'ratioFrom form-control form-control-sm'] )}} </div>
                                     
                                         <div class = "col-sm-6"> 
                                          {{ Form::text('ratioTo', '6.2',['class'=>'ratioTo form-control form-control-sm'] )}} </div>
                                      
                                        </div> 
                                    </div>
                                </div>
                        </div>
                           

                        <div class = "col-sm-2"> 
                                        <div class = "row">
                                                <div class = "col-sm-3">    {{Form::label('Target Wt.',''),['class'=>'form-control']}}  </div>
                                                <div class="col-sm-6">      {{ Form::text('target', '34',['class'=>'target form-control form-control-sm'] )}}   </div>
                                                 <div class = "col-sm-2"> {{ Form::hidden('transID', '',['class'=>'target form-control form-control-sm'] )}}</div>
                                        </div>
                        </div>
                        <div class = "col-sm-1"></div>       
        </div>
        <br/>
                        <div class = "row">
                            <div class = "col-sm-1"> </div>
                            <div class = "col-sm-1"> </div>
                            <div class="col-sm-2">       {{Form::label('befDispenseWt','Before Dispense Wt'),['class'=>'form-control']}} </div>
                            <div class = "col-sm-2">    {{Form::label('dispensedWt','Dispensed Wt'),['class'=>'form-control']}}    </div>
                            <div class="col-sm-1">      {{Form::label('wt','Weight'),['class'=>'form-control']}}  </div>
                            <div class = "col-sm-1">    {{Form::label('total','Total Wt.'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-2">      {{Form::label('ratio','Ratio'),['class'=>'form-control']}} </div>
                            <div class="col-sm-1">      {{Form::label('result','Qual Result'),['class'=>'form-control']}} </div>
                            <div class = "col-sm-1">   
                                    <div class="row">  
                                            <div class = "col-sm-9"> 
                                         </div>
                                      </div>  <div class = "col-sm-3"> </div>     
                            </div>
                   
                    </div>
                    <div class = "row">
                        <div class = "col-sm-1">   </div>
                        <div class = "col-sm-1">   {{Form::label('A','PartA'),['class'=>'form-control']}}  </div>
                        <div class="col-sm-2">     {{ Form::text('befDispenseWtA', '0',['class'=>'form-control', 'id'=>'befDispenseWtA'] )}} </div>
                        <div class = "col-sm-2">   {{ Form::text('dispensedWtA', '0',['class'=>'form-control', 'id'=>'dispensedWtA' ] )}}    </div>
                        <div class="col-sm-1">     {{ Form::text('weightA', '0',['class'=>'form-control','id'=>'weightA','readonly'=>'true'] )}}  </div>
                        <div class = "col-sm-1">    {{ Form::text('totalWt', '0',['class'=>'form-control', 'id'=>'totalWt','readonly'=>'true'] )}}   </div>
                        <div class = "col-sm-2">    {{ Form::text('ratio', '0',['class'=>'form-control', 'id'=>'ratio','readonly'=>'true'] )}}   </div>
                        <div class="col-sm-1">   {{Form::text('qualRes','',['class'=>'qualRes form-control form-control-sm','readonly'=>'true']) }}  </div>
                        <div class = "col-sm-1"> 
                          <div class="row">  
                                <div class = "col-sm-9"> 
                           {{ Form::hidden('sampleCount', '',['class'=>'sampCount form-control form-control-sm','readonly'=>'true'] )}}  </div>
                          </div>  <div class = "col-sm-3"> </div> 
                        </div>
                </div>
                <div class = "row">
                    <div class = "col-sm-1">  </div>
                    <div class = "col-sm-1">   {{Form::label('B','PartB'),['class'=>'form-control']}}  </div>
                    <div class = "col-sm-2">   {{ Form::text('befDispenseWtB', '0',['class'=>'form-control','id'=>'befDispenseWtB'] )}} </div>
                    <div class = "col-sm-2">   {{ Form::text('dispensedWtB', '0',['class'=>'form-control', 'id'=>'dispensedWtB'] )}}    </div>
                    <div class = "col-sm-1">   {{ Form::text('weightB', '0',['class'=>'form-control','id'=>'weightB','readonly'=>'true'] )}}  </div>
                    <div class = "col-sm-1">  </div>
                    <div class = "col-sm-2">  </div>
                    <div class = "col-sm-1">  </div>
                    <div class = "col-sm-1">  </div>
           
            </div>
           

  
<br/>
            
           
                    </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/MixRatio" class="btn btn-danger">Cancel</a>
                {!! Form::close() !!}
              <br/>
     
        </div>
      
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
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Sample No.</th>
                    <th>Part</th>
                    <th>Before <br/>Dispense Wt</th>
                    <th>Dispensed <br/>Wt</th>
                    <th>Weight</th>
                    <th>Total Wt</th>
                    <th>Ratio</th>
                    <th>Remarks</th>
               
                </tr>
    <?php $i=0; ?>
                 
                    @if(count($frameLogs) > 0)
                    @foreach($frameLogs as $potLog)
                    <?php $i++ ?>
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{$potLog->date}}</td>
                        <td>{{$potLog->shift}}</td>
                        <td>{{$potLog->sampleCount}}</td>
                        <td>A</td>
                        <td>{{$potLog->befDispenseWtA }}</td>
                        <td>{{$potLog->dispensedWtA }}</td>
                        <td>{{$potLog->weightA}}</td>
                        <td>{{$potLog->totalWt}}</td>
                        <td>{{$potLog->ratioVal}}</td>
                        <td>{{$potLog->qualRes}}</td>
                 
                     </tr>
                     <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>B</td>
                        <td>{{$potLog->befDispenseWtB }}</td>
                        <td>{{$potLog->dispensedWtB }}</td>
                        <td>{{$potLog->weightB}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                 
                 
                     </tr>
                @endforeach  
            </table>
            @else
            <p>No Records Found</p>
                
        @endif
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
    getDiff:function(aftDis,befDis){
        var Diff =  0;
        Diff = parseFloat(aftDis) -  parseFloat(befDis);
       return Diff;
        },
    getSum: function(wA,wB){
        var sum =  0;
        sum = parseFloat(wA) +  parseFloat(wB);
      // return sum.toFixed(2);
       if(sum >0){
            return sum.toFixed(2);
        }else{
            return 0;
        }
},
    getRatio: function(wA,wB){
        var sum =  0;
        sum = parseFloat(wA) /  parseFloat(wB);

        if(sum >0){
            return sum.toFixed(4);
        }else{
            return 0;
        }
      
},
    checkPassFail: function(ratio,rangeFrom,rangeTo,wt,wtTotal)
    {
        var ratioval = parseFloat(ratio);
        var rangeToVal = parseFloat(rangeTo);
        var rangeToFromVal = parseFloat(rangeFrom);
        var wtVal = parseFloat(wt);
        var wtTotalVal = parseFloat(wtTotal);
        var wtUL = parseFloat(wtVal) + 1;
        var wtLL = parseFloat(wtVal) - 1;
        if(rangeToFromVal <= ratioval && ratioval <= rangeToVal && wtLL <= wtTotalVal && wtTotalVal <= wtUL)
        {
            return "passed";
        }else{
            return "failed";
        }
    }

}

        $('#befDispenseWtA').keyup(function(){
            var bef =  $('#befDispenseWtA').val();
            var aft =  $('#dispensedWtA').val();
            var diff = JQUERY4U.getDiff(aft,bef);
           
            $('#weightA').val(diff);
         
            var A = $('#weightA').val();
            var B = $('#weightB').val();
            var sum = JQUERY4U.getSum ( A,B);
            var ratio = JQUERY4U.getRatio ( A,B);
            $('#ratio').val(ratio);
            $('#totalWt').val(sum);

            var from = $('.ratioFrom').val();
            var to = $('.ratioTo').val();
            var target = $('.target').val();
            var wtVal =  $('#totalWt').val();
            var res = JQUERY4U.checkPassFail(ratio,from,to,target,wtVal);
            $('.qualRes').val(res);
         });
         $('#dispensedWtA').keyup(function(){
            var bef =  $('#befDispenseWtA').val();
            var aft =  $('#dispensedWtA').val();
            var diff = JQUERY4U.getDiff(aft,bef);
          
            $('#weightA').val(diff);
            var A = $('#weightA').val();
            var B = $('#weightB').val();
            var sum = JQUERY4U.getSum ( A,B);
            var ratio = JQUERY4U.getRatio ( A,B);
            $('#ratio').val(ratio);
            $('#totalWt').val(sum);

              var from = $('.ratioFrom').val();
            var to = $('.ratioTo').val();
            var target = $('.target').val();
            var wtVal =  $('#totalWt').val();
            var res = JQUERY4U.checkPassFail(ratio,from,to,target,wtVal);
            $('.qualRes').val(res);
         });

           $('#befDispenseWtB').keyup(function(){
            var bef =  $('#befDispenseWtB').val();
            var aft =  $('#dispensedWtB').val();
            var diff = JQUERY4U.getDiff(aft,bef);
         
            $('#weightB').val(diff);
            var A = $('#weightA').val();
            var B = $('#weightB').val();
            var sum = JQUERY4U.getSum ( A,B);
            var ratio = JQUERY4U.getRatio ( A,B);
            $('#ratio').val(ratio);
            $('#totalWt').val(sum);

              var from = $('.ratioFrom').val();
            var to = $('.ratioTo').val();
            var target = $('.target').val();
            var wtVal =  $('#totalWt').val();
            var res = JQUERY4U.checkPassFail(ratio,from,to,target,wtVal);
            $('.qualRes').val(res);

         });

          $('#dispensedWtB').keyup(function(){
            var bef =  $('#befDispenseWtB').val();
            var aft =  $('#dispensedWtB').val();
            var diff = JQUERY4U.getDiff(aft,bef);
            
            $('#weightB').val(diff);
            var A = $('#weightA').val();
            var B = $('#weightB').val();
            var sum = JQUERY4U.getSum ( A,B);
            var ratio = JQUERY4U.getRatio ( A,B);
            $('#ratio').val(ratio);
            $('#totalWt').val(sum);

             var from = $('.ratioFrom').val();
            var to = $('.ratioTo').val();
            var target = $('.target').val();
            var wtVal =  $('#totalWt').val();
            var res = JQUERY4U.checkPassFail(ratio,from,to,target,wtVal);
            $('.qualRes').val(res);

         });

  
          
        
 </script>
 @endpush