@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
        <div class="card">
            <h5 class="card-header">Flash Test Data Inputs</h5>
                <div class="card-body">
                        {!! Form::open(['action' => 'FlashController@store', 'method' => 'POST']) !!}
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Date', 'Date:')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::text('Date', '', ['class' => 'form-control', 'placeholder'=>'Date'])}}
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Difference', '%Difference:')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::text('Difference', '', ['class' => 'form-control', 'placeholder'=>'Difference','required'=>'true'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Difference') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('CalSerial', 'Cal.Serial:')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::text('CalSerial', '', ['class' => 'form-control', 'placeholder'=>'Calibration Serial'])}}
                                    <small class="form-text text-danger">{{ $errors->first('CalSerial') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Remarks', 'Remarks:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Remarks', '', ['class' => 'form-control', 'placeholder'=>'Remarks'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Remarks') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Target', 'Target:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Target', '', ['class' => 'form-control', 'placeholder'=>'Target'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Target') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Actual', 'Actual:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Actual', '', ['class' => 'form-control', 'placeholder'=>'Actual'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Actual') }}</small>
                                </div>
                        </div><br>
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}   
                        {!! Form::close() !!}
                    </div>
            </div>
    </div>
                    
@endsection