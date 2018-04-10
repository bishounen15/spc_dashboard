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
                                    {{Form::select('Laminator', array('Laminator 1' => 'Laminator 1', 'Laminator 2' => 'Laminator 2'),'Select Shift',['class'=>'form-control'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Laminator') }}</small>
                                </div>
                                <div class="col-md-1">
                                        {{Form::label('Shift', 'Shift:')}}   
                                </div>    
                                <div class="col-md-3">
                                 {{Form::select('Shift', array('Shift A' => 'Shift A', 'Shift B' => 'Shift B','Shift C' => 'Shift C'), '',['class'=>'form-control'])}}
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
                                    {{Form::label('ModuleID', 'ModuleID:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('ModuleID', '', ['class' => 'form-control', 'placeholder'=>'ModuleID'])}}
                                    <small class="form-text text-danger">{{ $errors->first('ModuleID') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('EVA', 'EVA:')}}
                                </div>    
                                <div class="col-md-3">
                                    {{Form::text('EVA', '', ['class' => 'form-control', 'placeholder'=>'EVA'])}}
                                    <small class="form-text text-danger">{{ $errors->first('EVA') }}</small>
                                </div>
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
                <h5 class="card-header">Pull Test Details</h5>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site1', 'Site1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG1', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEGA', 'Average:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEGA', '', ['class' => 'form-control', 'placeholder'=>'E to G Average'])}}
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB1', 'PTEB1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB1', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEBA', 'Average:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEBA', '', ['class' => 'form-control', 'placeholder'=>'E to B Average'])}}
                                </div>
                        </div><br>  
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site2', 'Site2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG2', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG2') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB2', 'PTEB2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB2', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB2') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site3', 'Site3:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG3', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG3') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB3', 'PTEB3:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB3', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB3') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site4', 'Site4:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG4', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG4') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB4', 'PTEB4:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB4', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB4') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site5', 'Site5:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG5', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG5') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB5', 'PTEB5:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB5', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB5') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site6', 'Site6:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG6', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG6') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB6', 'PTEB6:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB6', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB6') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site7', 'Site7:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG7', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG7') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB7', 'PTEB7:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB7', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB7') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site8', 'Site8:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG8', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG8') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB8', 'PTEB8:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB8', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB8') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site9', 'Site9:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG9', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG9') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB9', 'PTEB9:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB9', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB9') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site10', 'Site10:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEG10', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-G'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEG10') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PTEB10', 'PTEB10:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('PTEB10', '', ['class' => 'form-control', 'placeholder'=>'Pull Test E-B'])}}
                                    <small class="form-text text-danger">{{ $errors->first('PTEB10') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}   
                        {!! Form::close() !!}
                    </div>
            </div>
    </div>
                    
@endsection