@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
        <br>
        <div class="card">
            <h5 class="card-header">Flash Test Data Inputs</h5>
            {!! Form::open(['action' => 'FlashController@store', 'method' => 'POST']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-1.5">
                        {{Form::label('ModuleID', 'SCAN MODULE ID:')}}
                    </div>
                    <div class="col-md-6">
                        {{Form::text('ModuleID', '', ['class' => 'form-control', 'placeholder'=>'Module ID'])}}
                        <small class="form-text text-danger">{{ $errors->first('ModuleID') }}</small>
                    </div> 
                </div>                
            </div>
        </div>
        <div class="card">
                <div class="card-header"><b>Flash Test Details</b></div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-1.3">
                                    {{Form::label('InspTime', '&nbsp;&nbsp;Inspect Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('InspTime', '', ['class' => 'form-control', 'placeholder'=>'Inspection Time'])}}
                                    <small class="form-text text-danger">{{ $errors->first('InspTime') }}</small>
                                </div>
                                <div class="col-md-1.3">
                                    {{Form::label('ISC', 'ISC:&nbsp;&nbsp;&nbsp;&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('ISC', '', ['class' => 'form-control', 'placeholder'=>'ISC'])}}
                                    <small class="form-text text-danger">{{ $errors->first('ISC') }}</small>
                                </div>
                                <div class="col-md-1.3">
                                    {{Form::label('UOC', 'Uoc:&nbsp;&nbsp;&nbsp;&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::text('UOC', '', ['class' => 'form-control', 'placeholder'=>'Uoc'])}}
                                        <small class="form-text text-danger">{{ $errors->first('UOC') }}</small>
                                </div>
                        </div><br>  
                        <div class="row">
                                <div class="col-md-1.3">
                                    {{Form::label('IMPP', '&nbsp;&nbsp;IMPP:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('IMPP', '', ['class' => 'form-control', 'placeholder'=>'IMPP'])}}
                                    <small class="form-text text-danger">{{ $errors->first('IMPP') }}</small>
                                </div>
                                <div class="col-md-1.3">
                                    {{Form::label('VMPP', 'VMPP:&nbsp;&nbsp;&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('VMPP', '', ['class' => 'form-control', 'placeholder'=>'VMPP'])}}
                                    <small class="form-text text-danger">{{ $errors->first('UMPP') }}</small>
                                </div>
                                <div class="col-md-1.3">
                                    {{Form::label('PMPP', 'Pmpp:&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::text('PMPP', '', ['class' => 'form-control', 'placeholder'=>'PMPP'])}}
                                        <small class="form-text text-danger">{{ $errors->first('PMPP') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1.3">
                                    {{Form::label('ShuntResist', '&nbsp;&nbsp;Shunt Resistance:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('ShuntResist', '', ['class' => 'form-control', 'placeholder'=>'Shunt Resistance'])}}
                                    <small class="form-text text-danger">{{ $errors->first('ShuntResist') }}</small>
                                </div>
                                <div class="col-md-1.3">
                                    {{Form::label('FF', 'FF:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('FF', '', ['class' => 'form-control', 'placeholder'=>'FF'])}}
                                    <small class="form-text text-danger">{{ $errors->first('FF') }}</small>
                                </div>
                                <div class="col-md-1.3">
                                    {{Form::label('BIN', 'BIN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::text('BIN', '', ['class' => 'form-control', 'placeholder'=>'BIN'])}}
                                        <small class="form-text text-danger">{{ $errors->first('BIN') }}</small>
                                </div>
                        </div><br>
                        
                        {{Form::submit('&nbsp;&nbsp;Submit&nbsp;&nbsp;', ['class' => 'btn btn-primary' ])}}  &emsp; <a href="/ftd" class="btn btn-danger">Cancel</a>
                        {!! Form::close() !!}
                    </div>
            </div><br>     
                    </div>
            </div>
                
    </div>
                    
@endsection