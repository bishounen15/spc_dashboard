@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => 'MatrixPullTestsController@store', 'method' => 'POST']) !!}
    <div class="container" style="width:120%">    
        <div class="card">
            <h5 class="card-header">Ribbon-to-Busbar Pull Test Data Inputs</h5>
                <div class="card-body">
                        <div class="jumbotron text-center">
                            <div class="row">
                                <div class="col-md-1">
                                    {{Form::label('employeeid', 'Employee ID:')}}
                                </div>  
                                <div class="col-md-5">  
                                        {{ Form::text('employeeid', '',['class'=>'form-control'] )}}
                                    <small class="form-text text-danger">{{ $errors->first('employeeid') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('location', 'Location:')}}
                                </div>  
                                <div class="col-md-5">  
                                        {{ Form::text('location', 'Busbar Prep',['class'=>'form-control'] )}}
                                    <small class="form-text text-danger">{{ $errors->first('location') }}</small>
                                </div>
                            </div><br>
                            <div class="row">
                                    <div class="col-md-1">
                                        {{Form::label('shift', 'Shift:')}}
                                    </div>  
                                    <div class="col-md-5">  
                                        {{Form::select('shift', array('ShiftA' => 'Shift A', 'ShiftB' => 'Shift B', 'ShiftC' => 'Shift C'),'',['class' => 'form-control','placeholder' => 'Select Shift'])}}
                                        <small class="form-text text-danger">{{ $errors->first('shift') }}</small>
                                    </div>
                                    <div class="col-md-1">
                                            {{Form::label('node', 'Node:')}}
                                    </div>  
                                    <div class="col-md-5">  
                                        {{ Form::text('node', 'Ribbon to Busbar',['class'=>'form-control'] )}} 
                                        <small class="form-text text-danger">{{ $errors->first('node') }}</small>
                                    </div>
                            </div></br>
                            <div class="row">
                                    <div class="col-md-1">        
                                        {{Form::label('supplier', 'Supplier:')}}
                                    </div>
                                    <div class="col-md-5">  
                                        {{Form::text('supplier','', ['class' => 'form-control','placeholder' => 'Supplier'])}}   
                                        <small class="form-text text-danger">{{ $errors->first('supplier') }}</small>
                                    </div>            
                                    <div class="col-md-1"> 
                                        {{Form::label('remarks', 'Remarks:')}}
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
                                            {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}}  </div>                                
                                        </div>
                            </div></br>
                        </div> 
                        
                        <div class="card">
                        <h5 class="card-header">Ribbon-to-Busbar Pull Test Data Details</h5>
                            <div class="card-body">
                            <div class="jumbotron text-center">
                            <div class="row">
                                    <div class="col-md-1">  
                                        {{Form::label('site1', 'Site 1:')}}
                                    </div>
                                    <div class="col-md-3">           
                                        {{ Form::text('site1', '1',['class'=>'form-control'] )}} 
                                        <small class="form-text text-danger">{{ $errors->first('site1') }}</small>
                                    </div> 
                                    <div class="col-md-1">
                                        {{Form::label('pulltest1', 'Pull Test 1:')}}
                                    </div>
                                        <div class="col-md-3">
                                        {{Form::text('pulltest1','', ['class' => 'form-control','placeholder' => 'Pull Test', 'id' => 'pulltest1', 'onkeyup' => 'calc()'])}}
                                        <small class="form-text text-danger">{{ $errors->first('pulltest1') }}</small>
                                    </div> 
                                    <div class="col-md-1">  
                                        {{Form::label('average', 'Average:')}}
                                    </div>
                                    <div class="col-md-3">
                                        {{Form::text('average','', ['class' => 'form-control','placeholder' => 'Average', 'id' => 'average', 'onkeyup' => 'calc()'])}}
                                        <small class="form-text text-danger">{{ $errors->first('average') }}</small>
                                    </div>     
                            </div></br> 
                            
                            <div class="row">
                                        <div class="col-md-1">  
                                            {{Form::label('site2', 'Site 2:')}}
                                        </div>
                                        <div class="col-md-3">           
                                            {{ Form::text('site2', '2',['class'=>'form-control'] )}}                                       
                                            <small class="form-text text-danger">{{ $errors->first('site2') }}</small>
                                        </div> 
                                        <div class="col-md-1">
                                            {{Form::label('pulltest2', 'Pull Test 2:')}}
                                        </div>
                                        <div class="col-md-3">
                                            {{Form::text('pulltest2','', ['class' => 'form-control','placeholder' => 'Pull Test', 'id' => 'pulltest2', 'onkeyup' => 'calc()'])}}
                                            <small class="form-text text-danger">{{ $errors->first('pulltest2') }}</small>
                                        </div>     
                            </div></br> 

                            <div class="row">
                                    <div class="col-md-1">  
                                        {{Form::label('site3', 'Site 3:')}}
                                    </div>
                                    <div class="col-md-3">           
                                        {{ Form::text('site3', '3',['class'=>'form-control'] )}}
                                        <small class="form-text text-danger">{{ $errors->first('site3') }}</small>                                    
                                    </div> 
                                    <div class="col-md-1">
                                        {{Form::label('pulltest3', 'Pull Test 3:')}}
                                    </div>
                                    <div class="col-md-3">
                                        {{Form::text('pulltest3','', ['class' => 'form-control','placeholder' => 'Pull Test', 'id' => 'pulltest3', 'onkeyup' => 'calc()'])}}
                                        <small class="form-text text-danger">{{ $errors->first('pulltest3') }}</small>
                                    </div>     
                            </div></br>
                            </div>
                    {{-- </div> --}}
                        
                    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                @endsection

                @push('jscript')
                <script>
                    function calc(){
                    document.getElementById('average').value = ((
                    parseFloat(document.getElementById('pulltest1').value) + 
                    parseFloat(document.getElementById('pulltest2').value) + 
                    parseFloat(document.getElementById('pulltest3').value)) / 3);
                    }
                </script>
                @endpush