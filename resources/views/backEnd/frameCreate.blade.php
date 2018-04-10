


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
                            <div class="col-sm-2">       {{Form::label('w/ Sealant','w/ Sealant'),['class'=>'form-control']}} </div>
                            <div class = "col-sm-2">    {{Form::label('w/o Sealant','w/o Sealant'),['class'=>'form-control']}}    </div>
                            <div class="col-sm-2">      {{Form::label('Diff','Difference'),['class'=>'form-control']}}  </div>
                            <div class = "col-sm-2">    {{Form::label('Sum','Sum'),['class'=>'form-control']}}  </div>
                            <div class="col-sm-1">    </div>
                            <div class = "col-sm-1">    {{Form::hidden('transID','1'),['class'=>'form-control']}} </div>
                   
                    </div>
                    <div class = "row">
                        <div class = "col-sm-1"> </div>
                        <div class = "col-sm-1">   {{Form::label('L1','L1'),['class'=>'form-control']}}  </div>
                        <div class="col-sm-2">     {{ Form::text('L1wSealant', '0',['class'=>'form-control'] )}} </div>
                        <div class = "col-sm-2">   {{ Form::text('L1woSealant', '0',['class'=>'form-control'] )}}    </div>
                        <div class="col-sm-2">     {{ Form::text('L1diff', '0',['class'=>'form-control'] )}}  </div>
                        <div class = "col-sm-2">    {{ Form::text('sum', '0',['class'=>'form-control', 'read-only'] )}}   </div>
                        <div class="col-sm-1">    </div>
                        <div class = "col-sm-1">   </div>
               
                </div>
                <div class = "row">
                    <div class = "col-sm-1"> </div>
                    <div class = "col-sm-1">   {{Form::label('L2','L2'),['class'=>'form-control']}}  </div>
                    <div class="col-sm-2">     {{ Form::text('L2wSealant', '0',['class'=>'form-control'] )}} </div>
                    <div class = "col-sm-2">   {{ Form::text('L2woSealant', '0',['class'=>'form-control'] )}}    </div>
                    <div class="col-sm-2">     {{ Form::text('L2diff', '0',['class'=>'form-control'] )}}  </div>
                    <div class = "col-sm-2">      </div>
                    <div class="col-sm-1">    </div>
                    <div class = "col-sm-1">   </div>
           
            </div>
            <div class = "row">
                <div class = "col-sm-1"> </div>
                <div class = "col-sm-1">   {{Form::label('S1','S1'),['class'=>'form-control']}}  </div>
                <div class="col-sm-2">     {{ Form::text('S1wSealant', '0',['class'=>'form-control'] )}} </div>
                <div class = "col-sm-2">   {{ Form::text('S1woSealant', '0',['class'=>'form-control'] )}}    </div>
                <div class="col-sm-2">     {{ Form::text('S1diff', '0',['class'=>'form-control'] )}}  </div>
                <div class = "col-sm-2">      </div>
                <div class="col-sm-1">    </div>
                <div class = "col-sm-1">   </div>
       
        </div>

        <div class = "row">
            <div class = "col-sm-1"> </div>
            <div class = "col-sm-1">   {{Form::label('S2','S2'),['class'=>'form-control']}}  </div>
            <div class="col-sm-2">     {{ Form::text('S2wSealant', '0',['class'=>'form-control'] )}} </div>
            <div class = "col-sm-2">   {{ Form::text('S2woSealant', '0',['class'=>'form-control'] )}}    </div>
            <div class="col-sm-2">     {{ Form::text('S2diff', '0',['class'=>'form-control'] )}}  </div>
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

 