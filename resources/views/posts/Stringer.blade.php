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
                            {{Form::select('Stringer', array('Stringer 1A' => 'Stringer 1B', 'Stringer 2B' => 'Stringer 2B',
                            'Stringer 3A' => 'Stringer 3A', 'Stringer 3B' => 'Stringer 3B',
                            'StrinG Rework' => 'String Rework', 'Solder Temp' => 'Solder Temp'), '',['class'=>'form-control','placeholder'=>'Select Stringer'])}}
                            <small class="form-text text-danger">{{ $errors->first('Stringer') }}</small>
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
                            {{Form::select('Side', array('Front' => 'Front Side', 'Back' => 'Back Side'), '',['class'=>'form-control','placeholder'=>'Select Side'])}}
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
                                {{Form::label('Location', 'Location:')}}
                            </div>    
                        <div class="col-md-3">
                            {{Form::text('Location', '', ['class' => 'form-control', 'placeholder'=>'Location'])}}
                            <small class="form-text text-danger">{{ $errors->first('Location') }}</small>
                            </div>
                    </div><br>
                    <div class="row">
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
                        <div class="col-md-1">
                            {{Form::label('Remarks', 'Remarks:')}}
                            </div>    
                        <div class="col-md-3">
                            {{Form::text('Remarks', '', ['class' => 'form-control', 'placeholder'=>'Remarks'])}}
                            <small class="form-text text-danger">{{ $errors->first('Remarks') }}</small>
                        </div>
                    </div><br>
            </div>
        </div><br>
        <div class="card">
                <h5 class="card-header">Stringer Sites Details</h5>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site1', 'Site1:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('Site1', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 1'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Site1') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site2', 'Site2:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('Site2', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 2'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Site2') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site3', 'Site3:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site3', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 3'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site3') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site4', 'Site4:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site4', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 4'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site4') }}</small>
                                </div>
                        </div><br>  
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site5', 'Site5:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site5', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 5'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site5') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site6', 'Site6:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site6', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 6'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site6') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site7', 'Site7:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site7', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 7'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site7') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site8', 'Site8:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site8', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 8'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site8') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('Site9', 'Site9:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site9', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 9'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site9') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site10', 'Site10:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site10', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 10'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site10') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site11', 'Site11:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site11', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 11'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site11') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('Site12', 'Site12:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('Site12', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 12'])}}
                                        <small class="form-text text-danger">{{ $errors->first('Site12') }}</small>
                                </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-1">
                                {{Form::label('Site13', 'Site13:')}}
                            </div>    
                            <div class="col-md-2">
                                    {{Form::text('Site13', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 13'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Site13') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('Site14', 'Site14:')}}
                            </div>    
                            <div class="col-md-2">
                                    {{Form::text('Site14', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 14'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Site14') }}</small>
                                </div>
                            <div class="col-md-1">
                                {{Form::label('Site15', 'Site15:')}}
                            </div>    
                            <div class="col-md-2">
                                    {{Form::text('Site15', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 15'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Site15') }}</small>
                                </div>
                            <div class="col-md-1">
                                {{Form::label('Site16', 'Site16:')}}
                            </div>    
                            <div class="col-md-2">
                                    {{Form::text('Site16', '', ['class' => 'form-control', 'placeholder'=>'Stringer Site 16'])}}
                                    <small class="form-text text-danger">{{ $errors->first('Site16') }}</small>
                            </div>
                        </div><br>
                        {{Form::submit('&nbsp;&nbsp;Submit&nbsp;&nbsp;', ['class' => 'btn btn-primary' ])}}  &emsp; <a href="/stringerdata" class="btn btn-danger">Cancel</a>
                        {!! Form::close() !!}
                    </div>
            </div><br>     
                    </div>
            </div>
    </div>

@endsection

