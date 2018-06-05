@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => 'OfflineMatSolderingPostsController@store', 'method' => 'POST']) !!}
    <div class="container" style="width:120%">
        <div class="card">
            <h5 class="card-header">Offline Matrix Soldering Temp Data Inputs</h5>
                <div class="card-body">
                    <div class="jumbotron text-center">
                        <div class="row">
                            <div class="col-md-1">
                                {{Form::label('station', 'Station')}}
                                </div>  
                                <div class="col-md-5">  
                                    {{Form::select('station', array('MA1AT&BSolderTemp' => 'MA1A T&B SolderTemp', 'MatrixReworkSolderingTemp' => 'Matrix Rework Soldering Temp', 'BBPrepSolderingTemp' => 'BB Prep Soldering Temp'),'-',['class' => 'form-control','placeholder' => 'Select Station'])}}
                                    <small class="form-text text-danger">{{ $errors->first('station') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('location', 'Location')}}
                                </div>  
                                <div class="col-md-5">  
                                    {{Form::select('location', array('1stTop' => '1st Top', '2ndTop' => '2nd Top', '1stBottom' => '1st Bottom', 'MatrixRework' => 'Matrix Rework','BusbarPrep' => 'Busbar Prep'),'',['class' => 'form-control','placeholder' => 'Select Location'])}}
                                    <small class="form-text text-danger">{{ $errors->first('location') }}</small>
                                </div>
                            </div><br>
                            <div class="row">
                                    <div class="col-md-1">
                                        {{Form::label('shift', 'Shift')}}
                                    </div>  
                                    <div class="col-md-5">  
                                        {{Form::select('shift', array('ShiftA' => 'Shift A', 'ShiftB' => 'Shift B', 'ShiftC' => 'Shift C'),'',['class' => 'form-control','placeholder' => 'Select Shift'])}}
                                        <small class="form-text text-danger">{{ $errors->first('shift') }}</small>
                                    </div>
                                    <div class="col-md-1">
                                            {{Form::label('node', 'Node')}}
                                    </div>  
                                    <div class="col-md-5">  
                                        {{ Form::text('node', 'Soldering Temp',['class'=>'form-control'] )}} 
                                        <small class="form-text text-danger">{{ $errors->first('node') }}</small>
                                    </div>    
                            </div></br>
                            <div class="row">
                                    <div class="col-md-1">        
                                        {{Form::label('supplier', 'Supplier')}}
                                    </div>
                                    <div class="col-md-5">  
                                        {{Form::text('supplier','', ['class' => 'form-control','placeholder' => 'Supplier'])}}   
                                        <small class="form-text text-danger">{{ $errors->first('supplier') }}</small>
                                    </div>            
                                    <div class="col-md-1"> 
                                        {{Form::label('remarks', 'Remarks')}}
                                    </div>
                                    <div class="col-md-5">
                                        {{Form::text('remarks','', ['class' => 'form-control','placeholder' => 'Remarks'])}}
                                        <small class="form-text text-danger">{{ $errors->first('remarks') }}</small>
                                    </div>
                            </div></br>
                            <div class="row">     
                                    <div class="col-md-1">
                                        {{Form::label('Date', 'Date:')}}
                                    </div>    
                                    <div class="col-md-3">
                                        {{Form::date('Date', \Carbon\Carbon::now() ,['class'=>'form-control', 'readonly'] )}}
                                    </div>
                            </div></br>
                        </div> 
                        
                        <div class="card">
                                <h5 class="card-header">Offline Matrix Soldering Temp Data Details</h5>
                                    <div class="card-body">
                            <div class="jumbotron text-center">
                            <div class="row">
                                    <div class="col-md-1">  
                                        {{Form::label('temp1', 'Temp 1:')}}
                                    </div>
                                    <div class="col-md-5">           
                                        {{Form::text('temp1','', ['class' => 'form-control','placeholder' => 'Temp 1', 'id' => 'temp1', 'onkeyup' => 'calc()'])}}
                                        <small class="form-text text-danger">{{ $errors->first('temp1') }}</small>
                                    </div> 
                                
                                    <div class="col-md-1">
                                        {{Form::label('average', 'Average:')}}
                                    </div>
                                    <div class="col-md-5">
                                        {{Form::text('average','', ['class' => 'form-control','placeholder' => 'Average', 'id' => 'average', 'onkeyup' => 'calc()'])}}
                                        <small class="form-text text-danger">{{ $errors->first('average') }}</small>
                                    </div>     
                            </div></br> 
                            
                            <div class="row">
                                        <div class="col-md-1">  
                                            {{Form::label('temp2', 'Temp 2:')}}
                                        </div>
                                        <div class="col-md-5">           
                                            {{Form::text('temp2','', ['class' => 'form-control','placeholder' => 'Temp 2', 'id' => 'temp2', 'onkeyup' => 'calc()'])}}
                                            <small class="form-text text-danger">{{ $errors->first('temp2') }}</small>
                                        </div>  
                            </div></br> 

                            <div class="row">
                                    <div class="col-md-1">  
                                        {{Form::label('temp3', 'Temp 3:')}}
                                    </div>
                                    <div class="col-md-5">           
                                        {{Form::text('temp3','', ['class' => 'form-control','placeholder' => 'Temp 3', 'id' => 'temp3', 'onkeyup' => 'calc()'])}}
                                        <small class="form-text text-danger">{{ $errors->first('temp3') }}</small>
                                    </div>      
                            </div></br>
                        </div>
                    </div>
                </div>        
                    {{Form::submit('Save',['class'=>'btn btn-primary'])}}
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