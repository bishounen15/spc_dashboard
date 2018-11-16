@extends('layouts.app')

@section('content')
<?php
$empid='';
$process='';
$shift = '';
$date = '';
$supplier = '';
$remarks = '';
$prodBuilt = '';
$getLastRec = DB::table(DB::select("SELECT * FROM offlinematsoldering ORDER BY id DESC"));
$lastRec = $getLastRec->from[0]->qualRes;
if($lastRec == 'fail'){
$empid=$getLastRec->from[0]->employeeid;
$process=$getLastRec->from[0]->location;
$station = $getLastRec->from[0]->station;
$shift = $getLastRec->from[0]->shift;
$date = $getLastRec->from[0]->date;
$supplier =$getLastRec->from[0]->supplier;
$remarks =$getLastRec->from[0]->remarks;
$prodBuilt = $getLastRec->from[0]->prodBuilt;
}else{
    $empid='';
$process='';
$shift = '';
$date = '';
$supplier = '';
$remarks = '';
$prodBuilt = '';
$station = '1';
}

?>
    {!! Form::open(['action' => 'OfflineMatSolderingPostsController@store', 'method' => 'POST']) !!}
    <div class="container" style="width:120%">
        <div class="card">
            <h5 class="card-header">Offline Matrix Soldering Temp Data Inputs</h5>
                <div class="card-body">
                    <div class="jumbotron text-center">
                            <div class="row">
                                    <div class="col-md-1"> {{Form::label('employeeid', 'Employee ID:')}} </div>  
                                    <div class="col-md-5"> {{ Form::text('employeeid', $empid,['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('employeeid') }}</small> </div>
                                    <div class="col-md-1"> {{Form::label('location', 'Location')}} </div>  
                                    <div class="col-md-5"> {{ Form::text('location', 'Busbar Prep',['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('location') }}</small> </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-1"> {{Form::label('shift', 'Shift')}} </div>  
                                    <div class="col-md-5"> {{Form::select('shift', array('ShiftA' => 'Shift A', 'ShiftB' => 'Shift B', 'ShiftC' => 'Shift C'),$shift,['class' => 'form-control','placeholder' => 'Select Shift'])}} <small class="form-text text-danger">{{ $errors->first('shift') }}</small> </div>
                                    <div class="col-md-1"> {{Form::label('node', 'Node')}} </div>  
                                    <div class="col-md-2"> {{ Form::text('node', 'Soldering Temp',['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('node') }}</small> </div>
                                    <div class="col-md-1"> {{Form::label('station', 'station')}} </div>  
                                    <div class="col-md-2"> {{ Form::text('station', $station,['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('station') }}</small> </div>
                                </div><br>
                                <div class="row">
                                        <div class="col-md-1"> {{Form::label('Date', 'Date:')}} </div>    
                                        <div class="col-md-5"> {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}} </div>
                                   
                        
                                    <div class="col-md-1"> {{Form::label('supplier', 'Supplier:')}} </div>
                                    <div class="col-md-5"> {{Form::select('supplier', array('Gigastorage' => 'Gigastorage', 'YourBest' => 'YourBest'),$supplier,['class' => 'form-control process','placeholder' => 'Select Supplier'])}} <small class="form-text text-danger">{{ $errors->first('supplier') }}</small> </div>      
                                </div><br>
                                <div class="row">
                                    <div class="col-md-1"> {{Form::label('remarks', 'Remarks')}} </div>
                                    <div class="col-md-5"> {{Form::text('remarks',$remarks, ['class' => 'form-control','placeholder' => 'Remarks'])}} <small class="form-text text-danger">{{ $errors->first('remarks') }}</small> </div>                    
                                    <div class="col-md-1"> {{Form::label('ProdBuilt', 'Product Built:')}}</div>  
                                    <div class="col-md-5"> 
                                            <?php  $getLastProd = DB::select("SELECT * FROM prodselect WHERE ProcessName ='Material Preparation' ORDER BY created_at DESC LIMIT 1 "); 
                                             $getProd = DB::select("SELECT * FROM producttype "); 
                                                    $lastSet = "";
                                            ?>
                                              @if(count($getLastProd) > 0)
                                              @foreach($getLastProd as $field)   
                                                     
                                             <?php $lastSet = $field->productName;  ?>
                                                       @endforeach
                                                       @else
                                                       <?php $lastSet = "Not Set.";  ?>
                                                       @endif  
                                      
                                     
                                    
                                        <select id="prodBuilt"  name="prodBuilt" class="form-control" >
                                                <option selected value="{{$lastSet}}">{{$lastSet}}</option>
                                                        @foreach ($getProd as $s)
                                                                <option value="{{ $s->prodName }}">{{ $s->prodName }}</option> 
                                                        @endforeach
                                        </select> 
                                        <small class="form-text text-danger">{{ $errors->first('prodBuilt') }}</small>  
                                    </div>
                                </div></br>
                            </div> 
                    <div class="card">
                        <h5 class="card-header">Offline Matrix Soldering Temp Data Details</h5>
                        <div class="card-body">
                        <div class="jumbotron text-center">
                        <div class="row">
                            <div class="col-md-1">  {{Form::label('temp1', 'Temp 1:')}} </div>
                            <div class="col-md-5">  {{Form::text('temp1','', ['class' => 'temp1 form-control','placeholder' => 'Temp 1', 'id' => 'temp1', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('temp1') }}</small> </div> 
                            <div class="col-md-1">  {{Form::label('average', 'Average:')}} </div>
                            <div class="col-md-5">  {{Form::text('average','', ['class' => ' average form-control','placeholder' => 'Average', 'id' => 'average', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('average') }}</small> </div>     
                        </div></br> 
                        <div class="row">
                            <div class="col-md-1"> {{Form::label('temp2', 'Temp 2:')}} </div>
                            <div class="col-md-5"> {{Form::text('temp2','', ['class' => 'temp2 form-control','placeholder' => 'Temp 2', 'id' => 'temp2', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('temp2') }}</small> </div>  
                        </div></br> 
                        <div class="row">
                            <div class="col-md-1"> {{Form::label('temp3', 'Temp 3:')}} </div>
                            <div class="col-md-5"> {{Form::text('temp3','', ['class' => 'temp3 form-control','placeholder' => 'Temp 3', 'id' => 'temp3', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('temp3') }}</small> </div>      
                        </div></br>
                    </div>
                        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}
                @endsection
                    @push('jscript')
                        <script>
                            function calc(){
                                document.getElementById('average').value = ((
                                parseFloat(document.getElementById('temp1').value) + 
                                parseFloat(document.getElementById('temp2').value) + 
                                parseFloat(document.getElementById('temp3').value)) / 3);
                            }           
                        </script>
                @endpush