


@extends('layouts.app')
  
@section('content')



<div class="container">
    
        <div class="col-12">
     
           
       
    

           
    <div class="row"  >
               
        <div class="card">
        <div class="card-header">Potting Qual Monitoring</div> 
 <br/>
                {!! Form::open(['action' => 'PottingController@store','method' => 'POST']) !!}
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
                                                         <div class = "col-sm-3">    {{Form::label('Qual Result'),['class'=>'form-control form-control-sm']}}  </div>
                                                         <div class="col-sm-4">       {{Form::text('qualRes','',['class'=>'qualRes form-control form-control-sm','readonly'=>'true']) }} </div>
                                                        </div>
                                                </div>
                                                   
                
                                                <div class = "col-sm-2"> 
                                                                <div class = "row">
                                                                        <div class = "col-sm-3">    {{Form::label('Target',''),['class'=>'form-control']}}  </div>
                                                                        <div class="col-sm-6">      {{ Form::text('target', '33',['class'=>'target form-control form-control-sm','readonly'=>'true'] )}}   
                                                                           
                                                                          
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
                                                <div class = "col-sm-2">  {{Form::label('PottantWt','Pottant Wt.'),['class'=>'form-control form-control-sm']}} </div>
                                                    <div class = "col-sm-3">   {{ Form::text('pottantWt', '',['class'=>'pottantWt form-control form-control-sm','placeholder'=>'0'] )}}  
                                                        <small class="form-text text-danger">{{ $errors->first('pottantWt') }}</small>
                                                    </div>
                                                         <div class = "col-sm-3">    {{Form::label('snapTime','Snap Time'),['class'=>'cdaLabel form-control form-control-sm']}}  </div>
                                                         <div class="col-sm-4">      {{ Form::text('snapTime', '',['class'=>'snapTime form-control form-control-sm','placeholder'=>'in mins'] ) }} 
                                                                <small class="form-text text-danger">{{ $errors->first('snapTime') }}</small>
                                                        </div>
                                                        </div>
                                                </div>
                                                   
                
                                                <div class = "col-sm-2"> 
                                                                <div class = "row">
                                                                     
                
                                                                         </div>
                                                                         <div class = "col-sm-2"></div>
                                                                </div>
                                                </div>
                                               

                                <div class = "row">
                                        <div class = "col-sm-1"> </div>

                                        <div class = "col-sm-3"> 
                                                        <div class = "row">
                                                                <div class = "col-sm-3">    {{Form::label('crossSection','Cross Section'),['class'=>'form-control']}}  </div>
                                                                <div class="col-sm-9">      {{Form::select('crossSec', array('cured' => 'cured','uncured'=>'uncured'), 'cured',['class'=>'sealant form-control form-control-sm'])}}  
                                                                    </div>
                                                        </div>
                                                 </div>

                                        
                   
                                                       
                                        <div class = "col-sm-6"> 
                                                <div class = "row">
                                        <div class = "col-sm-2">  {{Form::label('remarks','Remarks'),['class'=>'form-control form-control-sm']}} </div>
                                            <div class = "col-sm-10">   {{ Form::text('remarks', '',['class'=>'beadWt form-control form-control-sm'] )}}  
                                              
                                            
                                        </div>
                                           
        
                                        <div class = "col-sm-2"> 
                                                        <div class = "row">
                                                              
                                                                 <div class = "col-sm-2"></div>
                                                        </div>
                                        </div>
                                        <div class = "col-sm-1"></div>       
                        </div>
                               
                             
                                               

                        <div class = "col-sm-1"></div>       
                </div>


             
                    <br/>
           
                    </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; <a href="/Potting" class="btn btn-danger">Cancel</a>
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
                        <table class="table table-striped">
                                        <tr>
                                        <th>Row</th>
                                        <th>Shift</th>
                                        <th>Time</th>
                                        <th>Pottant Name</th>
                                        <th>JBox Name</th>
                                        <th>Pottant Wt.</th>
                                        <th>Snap Time</th>
                                        <th>Cross Section</th>
                                       
                                        </tr>
                                
                                        @if(count($potLogs) > 0)
                                        <?php $i=0 ?>
                                        @foreach($potLogs as $potLog)
                                        <?php $i++ ?>
                                         <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{$potLog->shift}}</td>
                                            <td>{{$potLog->time}}</td>
                                            <td>{{$potLog->pottantName}}</td>
                                            <td>{{$potLog->jBoxName}}</td>
                                            <td>{{$potLog->pottantWeight}}</td>
                                            <td>{{$potLog->snapTime}}</td>
                                            <td>{{$potLog->crossSection}}</td>
                                           
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

 $(document).ready(function () {
        
       
});

JQUERY4U = {
getQualRes: function(ave,target,uLlL){
        var targetUL =  parseFloat(target) +  parseFloat(uLlL);
        var targetLL =  parseFloat(target) -  parseFloat(uLlL);
        if(targetLL <= ave && ave <= targetUL){
         return "passed";
        }else {
         return "failed";
        }
}
}

$('.pottantWt').keyup(function(){
        var val = $('.pottantWt').val();
        var target = $('.target').val();
        var res = JQUERY4U.getQualRes(val,target,1);
        $('.qualRes').val(res);
});
  
    </script>
 @endpush