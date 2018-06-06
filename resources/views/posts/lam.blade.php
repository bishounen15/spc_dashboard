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
                                    {{Form::text('LXM1', $lam->LXM1, ['class' => 'form-control', 'placeholder'=>'LXM1', 'id' => 'LXM1'  , 'onkeyup' => 'calc()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('LXMA', 'Average:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXMA', $lam->LXMA, ['class' => 'form-control', 'placeholder'=>'LXM Average', 'id' => 'LXMA', 'readonly'])}}
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel1', 'RelGel1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel1', $lam->RelGel1, ['class' => 'form-control', 'placeholder'=>'RelGel1','readonly' , 'id' => 'RelGel1'])}}
                                    <small class="form-text text-danger">{{ $errors->first('RelGel1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGelA', 'Average:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGelA', $lam->RelGelA, ['class' => 'form-control', 'placeholder'=>'RelGelA Average','id'=> 'RelGelA','readonly'])}}
                                </div>
                        </div><br>  
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site2', 'Site2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('LXM2',$lam->LXM2, ['class' => 'form-control', 'placeholder'=>'LXM2', 'id' => 'LXM2' , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel2', $lam->RelGel2, ['class' => 'form-control', 'placeholder'=>'RelGel2','readonly','id' =>'RelGel2'])}}
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
                                    {{Form::text('LXM3',$lam->LXM3, ['class' => 'form-control', 'placeholder'=>'LXM3', 'id' => 'LXM3'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel3', $lam->RelGel3, ['class' => 'form-control', 'placeholder'=>'RelGel3','readonly', 'id' => 'RelGel3'])}}
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
                                    {{Form::text('LXM4', $lam->LXM4, ['class' => 'form-control', 'placeholder'=>'LXM4' , 'id' => 'LXM4'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel4', $lam->RelGel4, ['class' => 'form-control', 'placeholder'=>'RelGel4','readonly', 'id' => 'RelGel4'])}}
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
                                    {{Form::text('LXM5', $lam->LXM5, ['class' => 'form-control', 'placeholder'=>'LXM5' , 'id' => 'LXM5'  , 'onkeyup' => 'calc()'])}}
                                    <small class="form-text text-danger">{{ $errors->first('LXM5') }}</small>
                                </div>
                                <div class="col-md-1">
                                </div>    
                                <div class="col-md-2">
                                    
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('RelGel5', 'RelGel5:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('RelGel5', $lam->RelGel5, ['class' => 'form-control', 'placeholder'=>'RelGel5','readonly', 'id' => 'RelGel5'])}}
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
                                    {{Form::text('LXM6', $lam->LXM6, ['class' => 'form-control', 'placeholder'=>'LXM6' , 'id' => 'LXM6'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel6', $lam->RelGel6, ['class' => 'form-control', 'placeholder'=>'RelGel6','readonly', 'id' => 'RelGel6'])}}
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
                                    {{Form::text('LXM7', $lam->LXM7, ['class' => 'form-control', 'placeholder'=>'LXM7', 'id' => 'LXM7'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel7', $lam->RelGel7, ['class' => 'form-control', 'placeholder'=>'RelGel7','readonly', 'id' => 'RelGel7'])}}
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
                                    {{Form::text('LXM8', $lam->LXM8, ['class' => 'form-control', 'placeholder'=>'LXM8' , 'id' => 'LXM8'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel8', $lam->RelGel8, ['class' => 'form-control', 'placeholder'=>'RelGel8','readonly', 'id' => 'RelGel8'])}}
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
                                    {{Form::text('LXM9', $lam->LXM9, ['class' => 'form-control', 'placeholder'=>'LXM9' , 'id' => 'LXM9'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel9', $lam->RelGel9, ['class' => 'form-control', 'placeholder'=>'RelGel9','readonly', 'id' => 'RelGel9'])}}
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
                                    {{Form::text('LXM10', $lam->LXM10, ['class' => 'form-control', 'placeholder'=>'LXM10' , 'id' => 'LXM10'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel10', $lam->RelGel10, ['class' => 'form-control', 'placeholder'=>'RelGel10','readonly', 'id' => 'RelGel10'])}}
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
                                    {{Form::text('LXM11', $lam->LXM11, ['class' => 'form-control', 'placeholder'=>'LXM11' , 'id' => 'LXM11'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel11', $lam->RelGel11, ['class' => 'form-control', 'placeholder'=>'RelGel11','readonly', 'id' => 'RelGel11'])}}
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
                                    {{Form::text('LXM12', $lam->LXM12, ['class' => 'form-control', 'placeholder'=>'LXM12' , 'id' => 'LXM12'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel12', $lam->RelGel12, ['class' => 'form-control', 'placeholder'=>'RelGel12','readonly', 'id' => 'RelGel12'])}}
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
                                    {{Form::text('LXM13', $lam->LXM13, ['class' => 'form-control', 'placeholder'=>'LXM13' , 'id' => 'LXM13'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel13', $lam->RelGel13, ['class' => 'form-control', 'placeholder'=>'RelGel13','readonly', 'id' => 'RelGel13'])}}
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
                                    {{Form::text('LXM14', $lam->LXM14, ['class' => 'form-control', 'placeholder'=>'LXM14' , 'id' => 'LXM14','onkeyup'=>'calc()'])}}
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
                                    {{Form::text('RelGel14', $lam->RelGel14, ['class' => 'form-control', 'placeholder'=>'RelGel14','readonly', 'id' => 'RelGel14'])}}
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
                                    {{Form::text('LXM15', $lam->LXM15, ['class' => 'form-control', 'placeholder'=>'LXM15', 'id' => 'LXM15'  , 'onkeyup' => 'calc()'])}}
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
                                    {{Form::text('RelGel15', $lam->RelGel15, ['class' => 'form-control', 'placeholder'=>'RelGel15','readonly', 'id' => 'RelGel15'])}}
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
                                    {{Form::text('LXM16', $lam->LXM16, ['class' => 'form-control', 'placeholder'=>'LXM16','id'=>'LXM16', 'onkeyup'=>'calc()'])}}
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
                                    {{Form::text('RelGel16', $lam->RelGel16, ['class' => 'form-control', 'placeholder'=>'RelGel16','readonly', 'id' => 'RelGel16'])}}
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
    <script>
        function calc(){
            document.getElementById('LXMA').value = ((
            parseFloat(document.getElementById('LXM1').value) + 
            parseFloat(document.getElementById('LXM2').value) + 
            parseFloat(document.getElementById('LXM3').value) + 
            parseFloat(document.getElementById('LXM4').value) + 
            parseFloat(document.getElementById('LXM5').value) + 
            parseFloat(document.getElementById('LXM6').value) + 
            parseFloat(document.getElementById('LXM7').value) + 
            parseFloat(document.getElementById('LXM8').value) + 
            parseFloat(document.getElementById('LXM9').value) + 
            parseFloat(document.getElementById('LXM10').value) + 
            parseFloat(document.getElementById('LXM11').value) + 
            parseFloat(document.getElementById('LXM12').value) + 
            parseFloat(document.getElementById('LXM13').value) + 
            parseFloat(document.getElementById('LXM14').value) + 
            parseFloat(document.getElementById('LXM15').value) + 
            parseFloat(document.getElementById('LXM16').value)) / 16);

            ave();

            document.getElementById('RelGel1').value = getRelGel(document.getElementById('LXM1').value);
            document.getElementById('RelGel2').value = getRelGel(document.getElementById('LXM2').value);
            document.getElementById('RelGel3').value = getRelGel(document.getElementById('LXM3').value);
            document.getElementById('RelGel4').value = getRelGel(document.getElementById('LXM4').value);
            document.getElementById('RelGel5').value = getRelGel(document.getElementById('LXM5').value);
            document.getElementById('RelGel6').value = getRelGel(document.getElementById('LXM6').value);
            document.getElementById('RelGel7').value = getRelGel(document.getElementById('LXM7').value);
            document.getElementById('RelGel8').value = getRelGel(document.getElementById('LXM8').value);
            document.getElementById('RelGel9').value = getRelGel(document.getElementById('LXM9').value);
            document.getElementById('RelGel10').value = getRelGel(document.getElementById('LXM10').value);
            document.getElementById('RelGel11').value = getRelGel(document.getElementById('LXM11').value);
            document.getElementById('RelGel12').value = getRelGel(document.getElementById('LXM12').value);
            document.getElementById('RelGel13').value = getRelGel(document.getElementById('LXM13').value);
            document.getElementById('RelGel14').value = getRelGel(document.getElementById('LXM14').value);
            document.getElementById('RelGel15').value = getRelGel(document.getElementById('LXM15').value);
            document.getElementById('RelGel16').value = getRelGel(document.getElementById('LXM16').value);
        }

        function ave(){
        
            document.getElementById('RelGelA').value = ((
            parseFloat(document.getElementById('RelGel1').value) + 
            parseFloat(document.getElementById('RelGel2').value) + 
            parseFloat(document.getElementById('RelGel3').value) + 
            parseFloat(document.getElementById('RelGel4').value) + 
            parseFloat(document.getElementById('RelGel5').value) + 
            parseFloat(document.getElementById('RelGel6').value) + 
            parseFloat(document.getElementById('RelGel7').value) + 
            parseFloat(document.getElementById('RelGel8').value) + 
            parseFloat(document.getElementById('RelGel9').value) + 
            parseFloat(document.getElementById('RelGel10').value) + 
            parseFloat(document.getElementById('RelGel11').value) + 
            parseFloat(document.getElementById('RelGel12').value) + 
            parseFloat(document.getElementById('RelGel13').value) + 
            parseFloat(document.getElementById('RelGel14').value) + 
            parseFloat(document.getElementById('RelGel15').value) + 
            parseFloat(document.getElementById('RelGel16').value)) / 16);
        }

        function getRelGel(lxm){
            var relgel = 0;
            if(lxm == 0.3){
                relgel = 20;
            }else if(lxm == 0.35){
                relgel = 32;
            }else if(lxm == 0.41){
                relgel = 38;
            }else if(lxm == 0.45){
                relgel = 77;
            }else if(lxm == 0.54){
                relgel = 80.5;
            }else if(lxm == 0.65){
                relgel = 84.6;
            }else if(lxm == 0.7){
                relgel = 88.3;
            }else if(lxm == 0.73){
                relgel = 87.2;
            }else if(lxm == 0.81){
                relgel = 89.1;
            }else if(lxm == 0.82){
                relgel = 89.3;
            }else if(lxm == 0.88){
                relgel = 89.8;
            }else if(lxm == 0.95){
                relgel = 89.6;
            }else if(lxm == 1.01){
                relgel = 92.3;
            }else if(lxm == 1.05){
                relgel = 92;
            }else if(lxm == 1.07){
                relgel = 93.1;
            }else{
                relgel = 0;
            }

            return relgel;
        }
    </script>                
@endsection