@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
        <div class="card">
            <h5 class="card-header">Pull Test Data Inputs</h5>
                <div class="card-body">
                        {!! Form::open(['action' => 'PulltestController@store', 'method' => 'POST']) !!}
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Date', 'Date:')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::date('Date', \Carbon\Carbon::now() ,['class'=>'form-control', 'readonly'] )}} 
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Laminator', 'Laminator:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::select('Laminator', array('Laminator 1' => 'Laminator 1', 'Laminator 2' => 'Laminator 2','Laminator 3' => 'Laminator 3'),'',['class'=>'form-control','placeholder'=>'Select Laminator'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Laminator') }}</small>
                                </div>
                                <div class="col-md-1">
                                        {{Form::label('Shift', 'Shift:')}}   
                                </div>    
                                <div class="col-md-3">
                                 {{Form::select('Shift', array('Shift A' => 'Shift A', 'Shift B' => 'Shift B','Shift C' => 'Shift C'),'',['class'=>'form-control','placeholder'=>'Select Shift'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Shift') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Recipe', 'Recipe:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Recipe', '', ['class' => 'form-control', 'placeholder'=>'Recipe'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Recipe') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Glass', 'Glass:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Glass', '', ['class' => 'form-control', 'placeholder'=>'Glass'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Glass') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('EVA', 'EVA:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('EVA', '', ['class' => 'form-control', 'placeholder'=>'EVA'])}}
                                    <small class="form-text text-danger">{{ $errors->first('EVA') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Backsheet', 'Backsheet:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Backsheet', '', ['class' => 'form-control', 'placeholder'=>'Backsheet'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Backsheet') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Location', 'Location:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Location', '', ['class' => 'form-control', 'placeholder'=>'Location'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Location') }}</small>
                                </div>
                        </div>
                </div>
        </div>
        <br>
        <div class="card">
                <h5 class="card-header">Pull Test EVA to Glass Details</h5>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site1', 'Site1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG1', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG1'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site2', 'Site2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG2', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG2'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG2') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site3', 'Site3:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG3', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG3'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG3') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site4', 'Site4:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG4', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG4'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG4') }}</small>
                                </div>
                        </div><br>  
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site5', 'Site5:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG5', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG5'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG5') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site6', 'Site6:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG6', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG6'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG6') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site7', 'Site7:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG7', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG7'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG7') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site8', 'Site8:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG8', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG8'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG8') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site9', 'Site9:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG9', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG9'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG9') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site10', 'Site10:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG10', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG10'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG10') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site11', 'Site11:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG11', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG11'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG11') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site12', 'Site12:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG12', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG12'  , 'onkeyup' => 'PTEGAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG12') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-1">
                                {{Form::label('Site13', 'Site13:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEG13', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG13'  , 'onkeyup' => 'PTEGAVE()'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEG13') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('Site14', 'Site14:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEG14', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG14'  , 'onkeyup' => 'PTEGAVE()'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEG14') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('Site15', 'Site15:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEG15', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G', 'id' => 'PTEG15'  , 'onkeyup' => 'PTEGAVE()'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEG15') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('PTEGA', 'Average:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEGA', '0', ['class' => 'form-control', 'placeholder'=>'E to G Average','id'=>'PTEGA', 'readonly'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEGA') }}</small>
                            </div>
                        </div><br>
                    </div>
            </div><br>
            <div class="card">
                <h5 class="card-header">Pull Test EVA to Backsheet Details</h5>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site1', 'Site1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB1', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB1'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site2', 'Site2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB2', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB2'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB2') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site3', 'Site3:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB3', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB3'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB3') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site4', 'Site4:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB4', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB4'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB4') }}</small>
                                </div>
                        </div><br>  
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site5', 'Site5:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB5', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB5'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB5') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site6', 'Site6:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB6', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB6'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB6') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site7', 'Site7:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB7', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB7'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB7') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site8', 'Site8:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB8', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB8'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB8') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site9', 'Site9:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB9', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB9'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB9') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site10', 'Site10:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB10', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB10'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB10') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site11', 'Site11:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB11', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB11'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB11') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site12', 'Site12:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB12', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB12'  , 'onkeyup' => 'PTEBAVE()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB12') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-1">
                                {{Form::label('Site13', 'Site13:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEB13', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB13'  , 'onkeyup' => 'PTEBAVE()'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEB13') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('Site14', 'Site14:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEB14', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB14'  , 'onkeyup' => 'PTEBAVE()'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEB14') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('Site15', 'Site15:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEB15', '0', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B', 'id' => 'PTEB15'  , 'onkeyup' => 'PTEBAVE()'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEB15') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('PTEBA', 'Average:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('PTEBA', '0', ['class' => 'form-control', 'placeholder'=>'E to B Average','id'=>'PTEBA','readonly'])}}
                                <small class="form-text text-danger">{{ $errors->first('PTEBA') }}</small>
                                
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                                <div class="col-md-3">
                                      <center>  {{Form::label('Remarks', 'Remarks:')}}</center>
                                </div>
                                <div class="col-md-8">
                                        {{Form::text('remarks', '0', ['class' => 'form-control', 'placeholder'=>'remarks','id'=>'remarks'])}}
                                        <small class="form-text text-danger">{{ $errors->first('PTEBA') }}</small>
                                    </div>
                                    <div class="col-md-1">
                                        
                                        </div>
                            </div>
                            <br>
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}} &emsp; <a href="/pulltestdata" class="btn btn-danger">Cancel</a>  
                        {!! Form::close() !!}
                    </div>
            </div>
    </div>
    <script>
            function PTEGAVE(){
                document.getElementById('PTEGA').value = ((
                parseFloat(document.getElementById('PTEG1').value) + 
                parseFloat(document.getElementById('PTEG2').value) + 
                parseFloat(document.getElementById('PTEG3').value) + 
                parseFloat(document.getElementById('PTEG4').value) + 
                parseFloat(document.getElementById('PTEG5').value) + 
                parseFloat(document.getElementById('PTEG6').value) + 
                parseFloat(document.getElementById('PTEG7').value) + 
                parseFloat(document.getElementById('PTEG8').value) + 
                parseFloat(document.getElementById('PTEG9').value) + 
                parseFloat(document.getElementById('PTEG10').value) + 
                parseFloat(document.getElementById('PTEG11').value) + 
                parseFloat(document.getElementById('PTEG12').value) + 
                parseFloat(document.getElementById('PTEG13').value) + 
                parseFloat(document.getElementById('PTEG14').value) +  
                parseFloat(document.getElementById('PTEG15').value)) / 15);
    
            }

            function PTEBAVE(){
                document.getElementById('PTEBA').value = ((
                parseFloat(document.getElementById('PTEB1').value) + 
                parseFloat(document.getElementById('PTEB2').value) + 
                parseFloat(document.getElementById('PTEB3').value) + 
                parseFloat(document.getElementById('PTEB4').value) + 
                parseFloat(document.getElementById('PTEB5').value) + 
                parseFloat(document.getElementById('PTEB6').value) + 
                parseFloat(document.getElementById('PTEB7').value) + 
                parseFloat(document.getElementById('PTEB8').value) + 
                parseFloat(document.getElementById('PTEB9').value) + 
                parseFloat(document.getElementById('PTEB10').value) + 
                parseFloat(document.getElementById('PTEB11').value) + 
                parseFloat(document.getElementById('PTEB12').value) + 
                parseFloat(document.getElementById('PTEB13').value) + 
                parseFloat(document.getElementById('PTEB14').value) +  
                parseFloat(document.getElementById('PTEB15').value)) / 15);
    
            }
        </Script>

@endsection

