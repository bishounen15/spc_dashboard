@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
        <div class="card">
            <h5 class="card-header">Laytec Data Inputs</h5>
                <div class="card-body">
                        {!! Form::open(['action' => 'LaytecController@store', 'method' => 'POST']) !!}
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
                                    {{Form::select('Laminator', array('Laminator 1' => 'Laminator 1', 'Laminator 2' => 'Laminator 2', 'Laminator 3' => 'Laminator 3'), '',['class'=>'form-control','placeholder'=>'Select Laminator'])}}
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
                                    {{Form::label('LXM', 'LXM:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('LXM', '', ['class' => 'form-control', 'placeholder'=>'LXM'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('UCL', 'UCL:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('UCL', '', ['class' => 'form-control', 'placeholder'=>'UCL'])}}
                                    <small class="form-text text-danger">{{ $errors->first('UCL') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('LCL', 'LCL:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('LCL', '', ['class' => 'form-control', 'placeholder'=>'LCL'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LCL') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Average', 'Average:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('AVE', '', ['class' => 'form-control', 'placeholder'=>'Average'])}}
                                    <small class="form-text text-danger">{{ $errors->first('AVE') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Target', 'Target:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Target', '', ['class' => 'form-control', 'placeholder'=>'Target'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Target') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('CL', 'CL:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('CL', '', ['class' => 'form-control', 'placeholder'=>'CL'])}}
                                    <small class="form-text text-danger">{{ $errors->first('CL') }}</small>
                                </div>
                        </div>
                        <br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('USL', 'USL:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('USL', '', ['class' => 'form-control', 'placeholder'=>'USL'])}}
                                    <small class="form-text text-danger">{{ $errors->first('USL') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('LSL', 'LSL:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('LSL', '', ['class' => 'form-control', 'placeholder'=>'LSL'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LSL') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('+1Sigma', '+1Sigma:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Sgmaplus1', '', ['class' => 'form-control', 'placeholder'=>'+1Sigma'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Sgmaplus1') }}</small>
                                </div>
                        </div>
                        <br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('+2Sigma', '+2Sigma:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Sgmaplus2', '', ['class' => 'form-control', 'placeholder'=>'+2Sigma'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Sgmaplus2') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('-1Sigma', '-1Sigma:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Sgmamin1', '', ['class' => 'form-control', 'placeholder'=>'-1Sigma'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Sgmamin1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('-2Sigma', '-2Sigma:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('Sgmamin2', '', ['class' => 'form-control', 'placeholder'=>'-2Sigma'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Sgmamin2') }}</small>
                                </div>
                        </div>
                        <br>
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}   
                        {!! Form::close() !!}
                </div>
        </div>
        
                        
                    </div>
            </div>
    </div>
                    
@endsection