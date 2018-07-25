


@extends('layouts.app')
  
@section('content')




<div class="container">
    {{-- <div class="col-md-3">
    
            @include('backEnd.navs')
        </div> --}}
       
     
           
       
    

           
    <div class="row">
            <div class="col-md-12">
               
        <div class="card">
        <div class="card-header">Frame Qual Monitoring Data Input</div> 
 
            
                <br/>
                {!! Form::open(['action' => 'FrameController@store','method' => 'POST']) !!}
                <div class="form-group" >
                    <div class="row" style="font-size:12px;">
                    <div class="col-md-11">
                            <?php $seriallastval = "Qual Frame" ?>
                            <?php $disableCellType = "False" ?>
                            <?php $disableShift = "False" ?>
                            <?php $targetLastVal = "" ?>
                            <?php $ShiftLastVal = "A" ?>

                            @foreach($frameLogs as $curVal)
                            @if( $curVal->qualResult == "fail" )

                            <?php $disableCellType = "True" ?>
                            <?php $disableShift = "True" ?>
                            <?php $targetLastVal = $curVal->TargetParam ?>
                            <?php $ShiftLastVal = $curVal->shift ?>
                            <?php $seriallastval ="Qual Frame" ?>
                            @elseif( $curVal->qualResult == "pass" && $curVal->serialNo =="Qual Frame" )
                            <?php $seriallastval = "" ?>
                            <?php $disableCellType = "True" ?>
                            <?php $disableShift = "True" ?>
                            <?php $targetLastVal = $curVal->TargetParam ?>
                            <?php $ShiftLastVal = $curVal->shift ?>
                            @else
                            <?php $disableCellType = "False" ?>
                            <?php $disableShift = "False" ?>
                            <?php $ShiftLastVal = "A" ?>
                            @endif
                            @endforeach

                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('shift','Shift'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class="col-sm-2">       {{Form::select('shift', array('A' => 'A 6am-2pm', 'B' => 'B 2pm-10pm','C' => 'C 10pm-6am'),$ShiftLastVal,['class'=>'shift form-control form-control-sm']) }} {{Form::hidden('trigShift',$disableShift,['class'=>'trigShift'])}}</div>
                                <div class = "col-sm-1">    {{Form::label('date','Date'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class="col-sm-2">      {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control form-control-sm'] )}}  </div>
                             
                                <div class = "col-sm-1">    {{Form::label('Cell Type'),['class'=>'form-control form-control-sm']}} {{Form::hidden('trigCellType',$disableCellType,['class'=>'trigCellType'])}}  </div>
                                <div class="col-sm-2">       {{Form::select('cellType', array('180' => '72 cell', '150' => '60 cell'), 'S',['class'=>'cellType form-control form-control-sm']) }} </div>
                                <div class = "col-sm-2">   
                                    <div class="row">
                                    <div class="col-sm-6"> {{Form::label('target','Target'),['class'=>'form-control form-control-sm']}} </div>
                                    <div class="col-sm-6">   {{ Form::text('target', $targetLastVal,['class'=>'form-control form-control-sm','id'=>'target','readonly'=>'true']) }} </div>
                                    <small class="form-text text-danger">{{ $errors->first('target') }}</small>
                                    </div>
                                      </div>
                               
                        </div>
                       <br/>
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{Form::label('qualTime','Qual Time'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class = "col-sm-2">    {{Form::label('serialNo','serialNo'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class = "col-sm-1">    {{Form::label('frameLoc','Frame Location'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class="col-sm-1">      {{Form::label('w/o Sealant','w/o Sealant'),['class'=>'form-control form-control-sm']}}   </div>
                                <div class = "col-sm-1">    {{Form::label('w/ Sealant','w/ Sealant'),['class'=>'form-control form-control-sm']}}   </div>
                                <div class="col-sm-1">      {{Form::label('Diff','Difference'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class="col-sm-1">      {{Form::label('sum','Sum'),['class'=>'form-control form-control-sm','readonly'=>'true']}}  </div>
                                <div class = "col-sm-1">    {{Form::label('beadScale','Bead Scale'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class = "col-sm-1">    {{Form::label('facilitySupply','Facility Supply'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class = "col-sm-1">    {{Form::label('mainPressure','Main Pressure'),['class'=>'form-control form-control-sm']}}  </div>
                       
                        </div>
                       
                        <div class = "row">
                                <div class = "col-sm-1"> </div>
                                <div class = "col-sm-1">    {{ Form::text('qualTime', '',['class'=>'timepicker form-control form-control-sm','placeholder'=>'00:00','style'=>'padding:0;padding-bottom:0.5em;padding-top:0.5em'] )}}   <small class="form-text text-danger">{{ $errors->first('qualTime') }}</small></div>
                               
                                <div class="col-sm-2">      {{ Form::text('serialNo',  $seriallastval,['class'=>'form-control form-control-sm'] )}} <small class="form-text text-danger">{{ $errors->first('serialNo') }}</small> </div>
                                
                                <div class = "col-sm-1">    {{Form::label('L1','L1'),['class'=>'form-control form-control-sm']}}  </div>
                                <div class="col-sm-1">      {{ Form::text('L1woSealant', '0',['class'=>'form-control form-control-sm','id'=>'L1woSealant'] )}} <small class="form-text text-danger">{{ $errors->first('L1woSealant') }}</small></div>
                                <div class = "col-sm-1">    {{ Form::text('L1wSealant', '0',['class'=>'form-control form-control-sm','id'=>'L1wSealant'] )}} <small class="form-text text-danger">{{ $errors->first('L1wSealant') }}</small> </div>
                                <div class="col-sm-1">        {{ Form::text('L1diff', '0',['class'=>'form-control form-control-sm','id'=>'L1diff','readonly'=>'true'] )}}  <small class="form-text text-danger">{{ $errors->first('L1diff') }}</small></div>
                                <div class = "col-sm-1">     {{ Form::text('sum', '0',['class'=>'form-control form-control-sm', 'id'=>'sum','readonly'=>'true'] )}}  <small class="form-text text-danger">{{ $errors->first('sum') }}</small></div>
                                <div class = "col-sm-1">    {{ Form::text('beadScale', '0',['class'=>'beadScale form-control form-control-sm'] )}} <small class="form-text text-danger">{{ $errors->first('beadScale') }}</small> </div>
                                <div class = "col-sm-1">   {{ Form::text('facilitySupply', '0',['class'=>'form-control form-control-sm'] )}}  <small class="form-text text-danger">{{ $errors->first('facilitySupply') }}</small> </div>
                                <div class = "col-sm-1">     {{ Form::text('mainPressure', '0',['class'=>'form-control form-control-sm'] )}}  <small class="form-text text-danger">{{ $errors->first('mainPressure') }}</small> </div>
                       
                        </div>
                        <div class = "row">
                            <div class = "col-sm-1"> </div>
                            <div class = "col-sm-1"> </div>
                            <div class="col-sm-2">       </div>
                            <div class = "col-sm-1">    {{Form::label('L2','L2'),['class'=>'form-control form-control-sm']}}  </div>
                            <div class="col-sm-1">      {{ Form::text('L2woSealant', '0',['class'=>'form-control form-control-sm','id'=>'L2woSealant'] )}} <small class="form-text text-danger"> {{ $errors->first('L2woSealant') }}</small></div>
                            <div class = "col-sm-1">    {{ Form::text('L2wSealant', '0',['class'=>'form-control form-control-sm','id'=>'L2wSealant'] )}}  <small class="form-text text-danger">{{ $errors->first('L2wSealant') }}</small></div>
                            <div class="col-sm-1">        {{ Form::text('L2diff', '0',['class'=>'form-control form-control-sm','id'=>'L2diff','readonly'=>'true'] )}}  <small class="form-text text-danger">{{ $errors->first('L2diff') }} </small> </div>
                            <div class = "col-sm-1">    </div>
                            <div class = "col-sm-3">    </div>
                   
                    </div>

                    <div class = "row">
                        <div class = "col-sm-1"> </div>
                        <div class = "col-sm-1">     </div>
                        <div class="col-sm-2">       </div>
                        <div class = "col-sm-1">    {{Form::label('S1','S1'),['class'=>'form-control form-control-sm']}}  </div>
                        <div class="col-sm-1">      {{ Form::text('S1woSealant', '0',['class'=>'form-control form-control-sm','id'=>'S1woSealant'] )}}  <small class="form-text text-danger">{{ $errors->first('S1woSealant') }} </small></div>
                        <div class = "col-sm-1">    {{ Form::text('S1wSealant', '0',['class'=>'form-control form-control-sm','id'=>'S1wSealant'] )}}  <small class="form-text text-danger">{{ $errors->first('S1wSealant') }}</small></div>
                        <div class="col-sm-1">        {{ Form::text('S1diff', '0',['class'=>'form-control form-control-sm','id'=>'S1diff','readonly'=>'true'] )}}  <small class="form-text text-danger">{{ $errors->first('S1diff') }} </small>  </div>
                        <div class = "col-sm-1">      </div>
                        <div class = "col-sm-3">    </div>
               
                    </div>

                <div class = "row">
                    <div class = "col-sm-1"> </div>
                    <div class = "col-sm-1">     </div>
                    <div class="col-sm-2">       </div>
                    <div class = "col-sm-1">    {{Form::label('S2','S2'),['class'=>'form-control form-control-sm']}}  </div>
                    <div class="col-sm-1">      {{ Form::text('S2woSealant', '0',['class'=>'form-control form-control-sm','id'=>'S2woSealant'] )}} </div>
                    <div class = "col-sm-1">    {{ Form::text('S2wSealant', '0',['class'=>'form-control form-control-sm','id'=>'S2wSealant'] )}} </div>
                    <div class="col-sm-1">        {{ Form::text('S2diff', '0',['class'=>'form-control form-control-sm','id'=>'S2diff','readonly'=>'true'] )}}  <small class="form-text text-danger">{{ $errors->first('S2diff') }} </small>   </div>
                    <div class = "col-sm-1">      </div>
                    <div class = "col-sm-3">    </div>
                </div>
                <br/>
                <div class = "row">
                    <div class = "col-sm-1"> </div>
                    <div class = "col-sm-3">   
                            <div class="row">
                                    <div class="col-sm-5"> {{Form::label('remarks','Qual Result'),['class'=>'form-control form-control-sm']}} </div>
                                    <div class="col-sm-7">   {{ Form::text('remarks', '',['class'=>'form-control form-control-sm','id'=>'remarks','readonly'=>'true']) }} </div>
                                    </div>    
                    </div>
                   
                    <div class = "col-sm-1">    {{Form::label('remarks','Remarks'),['class'=>'form-control form-control-sm']}}  </div>
                    <div class="col-sm-7">      {{Form::text('remarks2', '',['class'=>'form-control form-control-sm','id'=>'remarks2'] )}}  <small class="form-text text-danger">{{ $errors->first('remarks2') }}</small> </div>
                   
                 

                   
            </div>
                  
            
               
                  
                   
                 
                
                    <br/>
                </div>
                <div class="col-md-1">
                      
                </div>
                    </div>

                 
                <!--   &emsp;&emsp; <input type="button" class="add-row" value="Add Row">
                    <div class="row" >
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-11">
                        
                                    <table>
                                            <thead>
                                                <tr>
                                                    <th>qualTime</th>
                                                    <th>Serial No</th>
                                                    <th>Frame Location</th>
                                                    <th>w/ Sealant</th>
                                                    <th>w/o Sealant</th>
                                                    <th>Difference</th>
                                                    <th>Sum</th>
                                                    <th>Bead Scale</th>
                                                    <th>Facility Supply</th>
                                                    <th>Main Pressure</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    
                                                    
                                                </tr>
                                            </tbody>
                                        </table>


                    </div>
                    </div> -->
                    </div>
                &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; 

                <a href="/Frame" class="btn btn-danger">Cancel</a>
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
                   
                    <table class="table table-striped" style="font-size:12px;">
                            <tr>
                                <th>Seq</th>
                               
                                <th>Shift</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Serial No</th>
                                <th>Frame <br/>Location</th>
                                <th>w/o Sealant <br/> weight</th>
                                <th>w/ Sealant <br/> weight</th>
                                <th>difference</th>
                                <th>Wt.</th>
                                <th>Bead <br/>Scale</th>
                                <th>Facility <br/>Supply</th>
                                <th>Main <br/>Pressure</th>
                                <th>Target<br/> (+)(-)10</th>
                                <th>Qual <br/>Result</th>
                                <th>Remarks</th>
                            </tr>
                  
                            @if(count($frameLogs) > 0)
                            <?php $i=0 ?>
                          
                            @foreach($frameLogs as $potLog)
                            <?php $i++ ?>
                           
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{$potLog->shift}}</td>
                        <td>{{$potLog->date}}</td>
                        <td>{{$potLog->qualTime}}</td>
                        <td>{{$potLog->serialNo}}</td>
                        <td>L1</td>
                        <td>{{$potLog->L1woSealantWt}}</td>
                        <td>{{$potLog->L1wSealantWt}}</td>
                        <td>{{$potLog->L1diff}}</td>
                        <td>{{$potLog->weight}}</td>
                        <td>{{$potLog->beadScale}}</td>
                        <td>{{$potLog->facilitySupply}}</td>
                        <td>{{$potLog->mainPressure}}</td>
                        <td>{{$potLog->TargetParam}}</td>
                        <td>{{$potLog->qualResult}}</td>
                        <td>{{$potLog->remarks}}</td>
                     </tr>
                     <tr>
                        <td> <td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                       
                        <td>L2</td>
                        <td>{{$potLog->L2woSealantWt}}</td>
                        <td>{{$potLog->L2wSealantWt}}</td>
                        <td>{{$potLog->L2diff}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                     </tr>
            
                     <tr>
                        <td> <td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        
                        <td>S1</td>
                        <td>{{$potLog->S1woSealantWt}}</td>
                        <td>{{$potLog->S1wSealantWt}}</td>
                        <td>{{$potLog->S1diff}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                     </tr>
            
                     <tr>
                        <td> <td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        
                        <td>S2</td>
                        <td>{{$potLog->S2woSealantWt}}</td>
                        <td>{{$potLog->S2wSealantWt}}</td>
                        <td>{{$potLog->S2diff}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                     </tr>
                   
                @endforeach  
            </table>
            @else
            <p> No Records Found.</p>
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
	checkPassFail: function(x, y) {
            
            var Uval = 0;
            var Lval = 0;
            var target = parseInt(x);
            var sum = parseInt(y);
        
            Uval = parseInt(x)+10;
            Lval = parseInt(x)-10;

        if( sum <= Uval && sum >= target )
        {
            return ("pass");
        }else if(sum >= Lval && sum <= target )
        {
            return ("pass");
        }else
{
            return ("fail");
        }
		//return (x * y);
	}

}

//function call

        
 
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
    var target = $('#target').val();
   
   // alert(remlastval + seriallastval );
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
    
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

      var target = $('#target').val();
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
     // alert(val);
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

     var target = $('#target').val();
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
      //alert(val);
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
    var target = $('#target').val();
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
      //alert(val);
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
    var target = $('#target').val();
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
     // alert(val);
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
    
    var target = $('#target').val();
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
      //alert(val);
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

     var target = $('#target').val();
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
      //alert(val);
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


    var target = $('#target').val();
    var val = JQUERY4U.checkPassFail(target,sum);
      $('#remarks').val(val);
      //alert(val);
   
    }); 

   $('.cellType').change(function(){
        $('#target').val($('.cellType').val());
    });

    //   $('.shift').change(function(){
    //   alert( $('.shift').val());
     //   });


     $(document).ready(function(){
         if( $('#serialNo').val()=="Qual Frame")
         {    $('#serialNo').attr('readonly',true); } else {   $('#serialNo').attr('readonly',false); $('#serialNo').attr('placeholder','insert serial');}
        if($('#target').val()==""){
            $('#target').val($('.cellType').val());
        }

        //  $('.shift').val( $('#targetshift').val());
        
         //$('#target').val($('.cellType').val());
             $('#target').attr('readonly',true);
         if($('.trigCellType').val()=='True'){
            $('.cellType').val( $('#target').val());
            $('.cellType').attr('disabled',true);
           
         }else{
            $('.cellType').attr('disabled',false);
         }

        

/*       if($('.trigShift').val()=="True"){
            
         
           $('.shift').attr('disabled',true);
         }else{
            $('.shift').attr('disabled',false);
         }  */
        $(".add-row").click(function(){

             var qualTime = $('.timepicker').val();
            /* var SerialNo
             var Frame Location</th>
             var w/ Sealant</th>
             var w/o Sealant</th>
             var Difference</th>
             var Sum</th>
             var Bead Scale</th>
             var Facility Supply</th>
             var Main Pressure</th> */

          
            var markup = "<tr><td>" + qualTime + "</td><td> </td></tr>";
            $("table tbody").append(markup);
        });
    });

  
    </script>
 @endpush