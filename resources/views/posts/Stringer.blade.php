@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
        <div class="card">
            <h5 class="card-header">Stringer Data Inputs</h5>
                <div class="card-body">
                        {!! Form::open(['action' => 'StringerController@store', 'method' => 'POST']) !!}
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Date', 'Date:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::date('Date', \Carbon\Carbon::now() ,['class'=>'form-control', 'readonly'] )}}
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Stringer', 'Stringer:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::select('Laminator', array('Stringer 1A' => 'Stringer 1B', 'Stringer 2B' => 'Stringer 2B',
                                    'Stringer 3A' => 'Stringer 3A', 'Stringer 3B' => 'Stringer 3B',
                                    'StrinG Rework' => 'String Rework', 'Solder Temp' => 'Solder Temp'), 'Select Lam',['class'=>'form-control','placeholder'=>'Select Stringer'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Laminator') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Shift', 'Shift:')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::select('Shift', array('Shift A' => 'Shift A', 'Shift B' => 'Shift B','Shift C' => 'Shift C'), '',['class'=>'form-control','placeholder'=>'Select Shift'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Shift') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Cell', 'Cell:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Cell', '', ['class' => 'form-control', 'placeholder'=>'Cell'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Cell') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Ribbon', 'Ribbon:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Ribbon', '', ['class' => 'form-control', 'placeholder'=>'Ribbon'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Ribbon') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Station', 'Station:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Station', '', ['class' => 'form-control', 'placeholder'=>'Station'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Station') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Side', 'Side:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Side', '', ['class' => 'form-control', 'placeholder'=>'Side'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Side') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Cell No.', 'Cell No.:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('CellNo', '', ['class' => 'form-control', 'placeholder'=>'Cell No.'])}}
                                    <small class="form-text text-danger">{{ $errors->first('CellNo') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site', 'Site:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Site', '', ['class' => 'form-control', 'placeholder'=>'Site'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Site') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Location', 'Location:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Location', '', ['class' => 'form-control', 'placeholder'=>'Location'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Location') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PeelTest', 'PeelTest:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('PeelTest', '', ['class' => 'form-control', 'placeholder'=>'Peel Test'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PeelTest') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Creteria', 'Creteria:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Criteria', '', ['class' => 'form-control', 'placeholder'=>'Criteria'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Criteria') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Remarks', 'Remarks:')}}
                                </div>    
                                <div class="col-md-6">
                                    {{Form::text('Remarks', '', ['class' => 'form-control', 'placeholder'=>'Remarks'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Remarks') }}</small>
                                </div>
                                
                        </div>
                </div>
        </div>
        <br>
        
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}   
                        {!! Form::close() !!}
                    </div>
            </div>
    </div>
                    
@endsection