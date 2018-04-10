@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
        <div class="card">
            <h5 class="card-header">Laminator LXM Data Inputs</h5>
                <div class="card-body">
                        {!! Form::open(['action' => 'LamController@store', 'method' => 'POST']) !!}
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
                                    {{Form::select('Laminator', array('Laminator 1' => 'Laminator 1', 'Laminator 2' => 'Laminator 2', 'Laminator 3' => 'Laminator 3'),'',['class'=>'form-control','placeholder'=>'Select Laminator'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Laminator') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Shift', 'Shift:')}}
                                </div>    
                                <div class="col-md-3">
                                        {{Form::select('Shift', array('Shift A' => 'Shift A', 'Shift B' => 'Shift B','Shift C' => 'Shift C'),'',['class'=>'form-control', 'placeholder'=>'Select Shift'])}}
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
                <h5 class="card-header">LXM Data Details</h5>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site1', 'Site1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM1', '', ['class' => 'form-control', 'placeholder'=>'LXM1'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('LXMA', 'Average:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXMA', '', ['class' => 'form-control', 'placeholder'=>'LXM Average'])}}
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel1', 'RelGel1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel1', '', ['class' => 'form-control', 'placeholder'=>'RelGel1'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGelA', 'Average:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGelA', '', ['class' => 'form-control', 'placeholder'=>'RelGelA Average'])}}
                                </div>
                        </div><br>  
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site2', 'Site2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM2', '', ['class' => 'form-control', 'placeholder'=>'LXM2'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM2') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel2', 'RelGel2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel2', '', ['class' => 'form-control', 'placeholder'=>'RelGel2'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel2') }}</small>
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
                                    {{Form::text('LXM3', '', ['class' => 'form-control', 'placeholder'=>'LXM3'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM3') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel3', 'RelGel3:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel3', '', ['class' => 'form-control', 'placeholder'=>'RelGel3'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel3') }}</small>
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
                                    {{Form::text('LXM4', '', ['class' => 'form-control', 'placeholder'=>'LXM4'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM4') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel4', 'RelGel4:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel4', '', ['class' => 'form-control', 'placeholder'=>'RelGel4'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel4') }}</small>
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
                                    {{Form::text('LXM5', '', ['class' => 'form-control', 'placeholder'=>'LXM5'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM4') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel5', 'RelGel5:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel5', '', ['class' => 'form-control', 'placeholder'=>'RelGel5'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel5') }}</small>
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
                                    {{Form::text('LXM6', '', ['class' => 'form-control', 'placeholder'=>'LXM6'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM6') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel6', 'RelGel6:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel6', '', ['class' => 'form-control', 'placeholder'=>'RelGel6'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel6') }}</small>
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
                                    {{Form::text('LXM7', '', ['class' => 'form-control', 'placeholder'=>'LXM7'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM7') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel7', 'RelGel7:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel7', '', ['class' => 'form-control', 'placeholder'=>'RelGel7'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel7') }}</small>
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
                                    {{Form::text('LXM8', '', ['class' => 'form-control', 'placeholder'=>'LXM8'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM8') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel8', 'RelGel8:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel8', '', ['class' => 'form-control', 'placeholder'=>'RelGel8'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel8') }}</small>
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
                                    {{Form::text('LXM9', '', ['class' => 'form-control', 'placeholder'=>'LXM9'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM9') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel9', 'RelGel9:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel9', '', ['class' => 'form-control', 'placeholder'=>'RelGel9'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel9') }}</small>
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
                                    {{Form::text('LXM10', '', ['class' => 'form-control', 'placeholder'=>'LXM10'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM10') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel10', 'RelGel10:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel10', '', ['class' => 'form-control', 'placeholder'=>'RelGel10'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel10') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site11', 'Site11:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM11', '', ['class' => 'form-control', 'placeholder'=>'LXM11'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM11') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel11', 'RelGel11:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel11', '', ['class' => 'form-control', 'placeholder'=>'RelGel11'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel11') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site12', 'Site12:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM12', '', ['class' => 'form-control', 'placeholder'=>'LXM12'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM12') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel12', 'RelGel12:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel12', '', ['class' => 'form-control', 'placeholder'=>'RelGel12'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel12') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site13', 'Site13:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM13', '', ['class' => 'form-control', 'placeholder'=>'LXM13'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM13') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel13', 'RelGel13:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel13', '', ['class' => 'form-control', 'placeholder'=>'RelGel13'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel13') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site14', 'Site14:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM14', '', ['class' => 'form-control', 'placeholder'=>'LXM14'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM14') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel14', 'RelGel14:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel14', '', ['class' => 'form-control', 'placeholder'=>'RelGel14'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel14') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site15', 'Site15:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM15', '', ['class' => 'form-control', 'placeholder'=>'LXM15'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM15') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel15', 'RelGel15:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel15', '', ['class' => 'form-control', 'placeholder'=>'RelGel15'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel15') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site16', 'Site16:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM16', '', ['class' => 'form-control', 'placeholder'=>'LXM16'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM16') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel16', 'RelGel16:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel16', '', ['class' => 'form-control', 'placeholder'=>'RelGel16'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel16') }}</small>
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