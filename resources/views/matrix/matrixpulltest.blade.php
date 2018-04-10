@extends('layouts.app')

@section('content')
    <h1>Input Data</h1></br>
    
    {!! Form::open(['action' => 'MatrixController@store', 'method' => 'POST']) !!}
    <div class="container">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-md-1">
                    {{Form::label('station', 'Station')}}
                </div>  
                <div class="col-md-5">  
                    {{Form::select('station', array('MA1AT&BPullTest' => 'MA1A T&B PullTest', 'MA1BT&BPullTest' => 'MA1B T&B PullTest', 'MatrixReworkPullTest' => 'Matrix ReworkPullTest','BBtoBBPullTest ' => 'BB to BB Pull Test '),'-',['class' => 'form-control','placeholder' => 'Select Station'])}}
                </div>
                <div class="col-md-1">
                    {{Form::label('location', 'Location')}}
                </div>  
                <div class="col-md-5">  
                    {{Form::select('location', array('1stTop' => '1st Top', '2ndTop' => '2nd Top', '1stBottom' => '1st Bottom', 'MatrixRework' => 'Matrix Rework','BusbarPrep' => 'Busbar Prep'),'',['class' => 'form-control','placeholder' => 'Select Location'])}}
                </div>
            </div><br>
            <div class="row">
                    <div class="col-md-1">
                        {{Form::label('shift', 'Shift')}}
                    </div>  
                    <div class="col-md-5">  
                        {{Form::select('shift', array('ShiftA' => 'Shift A', 'ShiftB' => 'Shift B', 'ShiftC' => 'Shift C', 'RegShift' => 'Regular Shift'),'',['class' => 'form-control','placeholder' => 'Select Shift'])}}
                    </div>
                    <div class="col-md-1">
                            {{Form::label('node', 'Node')}}
                    </div>  
                    <div class="col-md-5">  
                            {{Form::select('node', array('RtoB' => 'RtoB', 'BtoB' => 'BtoB', 'SolderingTemp' => 'Soldering Temp'),'',['class' => 'form-control','placeholder' => 'Select Node'])}}
                    </div>
            </div></br>
            <div class="row">
                    <div class="col-md-1">        
                        {{Form::label('supplier', 'Supplier')}}
                    </div>
                    <div class="col-md-5">  
                        {{Form::text('supplier','', ['class' => 'form-control','placeholder' => 'Supplier'])}}   
                    </div>            
                    <div class="col-md-1"> 
                        {{Form::label('remarks', 'Remarks')}}
                    </div>
                    <div class="col-md-5">
                        {{Form::text('remarks','', ['class' => 'form-control','placeholder' => 'Remarks'])}}
                    </div>
            </div></br>
            <div class="row">     
                    <div class="col-md-1">
                        {{Form::label('date', 'Date')}}
                    </div>
                    <div class="col-md-2">
                        {{ Form::date('fixture_date', \Carbon\Carbon::now()) ,['class'=>'form-control','placeholder' ] }} 
                    </div>
            </div></br>
        </div> 
        
        <h1>Site</h1></br>
        <div class="container">
            <div class="jumbotron text-center">
            <div class="row">
                    <div class="col-md-1">  
                        {{Form::label('site1', 'Site 1:')}}
                    </div>
                    <div class="col-md-3">           
                        {{Form::text('site1','', ['class' => 'form-control','placeholder' => 'Site 1'])}}
                    </div> 
                    <div class="col-md-1">
                        {{Form::label('pulltest1', 'Pull Test 1:')}}
                    </div>
                        <div class="col-md-3">
                        {{Form::text('pulltest1','', ['class' => 'form-control','placeholder' => 'Pull Test'])}}
                    </div> 
                    <div class="col-md-1">
                        {{Form::label('average', 'Average:')}}
                    </div>
                    <div class="col-md-3">
                        {{Form::text('average','', ['class' => 'form-control','placeholder' => 'Average'])}}
                    </div>     
            </div></br> 
             
            <div class="row">
                        <div class="col-md-1">  
                            {{Form::label('site2', 'Site 2:')}}
                        </div>
                        <div class="col-md-3">           
                            {{Form::text('site2','', ['class' => 'form-control','placeholder' => 'Site 2'])}}
                        </div> 
                        <div class="col-md-1">
                            {{Form::label('pulltest2', 'Pull Test 2:')}}
                        </div>
                        <div class="col-md-3">
                            {{Form::text('pulltest2','', ['class' => 'form-control','placeholder' => 'Pull Test'])}}
                        </div>     
            </div></br> 

            <div class="row">
                    <div class="col-md-1">  
                        {{Form::label('site3', 'Site 3:')}}
                    </div>
                    <div class="col-md-3">           
                        {{Form::text('site3','', ['class' => 'form-control','placeholder' => 'Site 3'])}}
                    </div> 
                    <div class="col-md-1">
                        {{Form::label('pulltest3', 'Pull Test 3:')}}
                    </div>
                    <div class="col-md-3">
                        {{Form::text('pulltest3','', ['class' => 'form-control','placeholder' => 'Pull Test'])}}
                    </div>     
            </div></br>
        </div>
    </div>
        
    {{Form::submit('Save',['class'=>'btn btn-primary'])}} 

    {!! Form::close() !!}
@endsection