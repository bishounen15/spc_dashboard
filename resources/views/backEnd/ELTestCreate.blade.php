


@extends('layouts.app')
  
@section('content')



<div class="row">
    <div class="container">
     
           
       
    
    <div class="row">
        <div class = "col-sm-12" >          
        <div class="card">
        <div class="card-header">EL Test Monitoring</div> 
 
            
                <br/>
                {!! Form::open(['action' => 'ELTestController@store','method' => 'POST']) !!}
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
                                    <div class = "col-sm-3">   {{ Form::text('qualTime', '00:00',['class'=>'timepicker form-control form-control-sm','style'=>'padding:0;padding-bottom:0.3em;padding-top:0.3em'] )}}  
                                      
                                    </div>
                                         <div class = "col-sm-2">    {{Form::label('Result'),['class'=>'form-control form-control-sm']}}  </div>
                                         <div class="col-sm-5">       {{Form::select('result', array('passed' => 'passed', 'failed' => 'failed'), 'S',['class'=>'result form-control form-control-sm']) }} </div>
                                        </div></div>
                                   

                            

                                
                                <div class = "col-sm-3"> 
                                                <div class = "row">
                                                        <div class = "col-sm-3">    {{Form::label('SerialNo',''),['class'=>'form-control']}}  </div>
                                                        <div class="col-sm-8">      {{ Form::text('serialNo', '',['class'=>'form-control form-control-sm','id'=>'serialNo'] )}}   
                                                           
                                                            <small class="form-text text-danger">{{ $errors->first('serialNoTxt') }}</small>
                                                          
                                                         </div>
                                                       
                                                </div></div>

                                <div class = "col-sm-1"></div> 

                               
                       
                        </div>
                        <br/>
                        
         


   <br/>
  
                <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">   {{Form::label('Remarks','Remarks'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class= "col-sm-9">    {{ Form::text('remarks', 'Remarks',['class'=>'form-control form-control-sm']) }} </div>
                    
                           
                               
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
            

            <table class="table table-striped">
                <tr>
                <th>Seq</th>
                <th>Date</th>
                <th>Time</th>
                <th>Shift</th>
                <th>Serial No</th>
                <th>Result</th>
                <th>Remarks</th>
                </tr>
    
                 
                    @if(count($ELTestLogs) > 0)
                    @foreach($ELTestLogs as $potLog)
                     <tr>
                        <td>{{$potLog->id}}</td>
                        <td>{{$potLog->date}}</td>
                        <td>{{$potLog->qualTime}}</td>
                        <td>{{$potLog->shift}}</td>
                        <td>{{$potLog->serialNo}}</td>
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

    </script>
 @endpush
