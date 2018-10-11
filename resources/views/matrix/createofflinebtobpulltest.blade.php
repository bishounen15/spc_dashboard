@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => 'OfflineBtoBPullTestController@store', 'method' => 'POST']) !!}
    <div class="container" style="width:120%">
            <div class="card">
                <h5 class="card-header">Busbar-to-Busbar Pull Test Data Inputs</h5>
                <div class="card-body">
                    <div class="jumbotron text-center">
                            <div class="row">
                                    <div class="col-md-1"> {{Form::label('employeeid', 'Employee ID:')}} </div>  
                                    <div class="col-md-5"> {{ Form::text('employeeid', '',['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('employeeid') }}</small> </div>
                                    <div class="col-md-1"> {{Form::label('process', 'Process:')}}</div>  
                                    <div class="col-md-5"> {{ Form::text('process', 'Busbar Prep',['class'=>'form-control'] )}} </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-1"> {{Form::label('shift', 'Shift:')}} </div>  
                                    <div class="col-md-5"> {{Form::select('shift', array('A' => 'Shift A', 'B' => 'Shift B', 'C' => 'Shift C'),'',['class' => 'form-control','placeholder' => 'Select Shift'])}} <small class="form-text text-danger">{{ $errors->first('shift') }}</small> </div>
                                    <div class="col-md-1"> {{Form::label('node', 'Node:')}} </div>  
                                    <div class="col-md-5"> {{ Form::text('node', 'Busbar to Busbar',['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('node') }}</small> </div>
                                </div></br>
                                <div class="row">
                                        <div class="col-md-1"> {{Form::label('Date', 'Date:')}} </div>    
                                        <div class="col-md-5"> {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}} </div>
                                    <div class="col-md-1"> {{Form::label('supplier', 'Supplier:')}} </div>
                                    <div class="col-md-5"> {{Form::select('supplier', array('Gigastorage' => 'Gigastorage', 'YourBest' => 'YourBest'),'',['class' => 'form-control process','placeholder' => 'Select Supplier'])}} <small class="form-text text-danger">{{ $errors->first('supplier') }}</small> </div>      
                                </div></br>
                                <div class="row">    
                                        <div class="col-md-1"> {{Form::label('remarks', 'Remarks:')}} </div>
                                        <div class="col-md-5"> {{Form::text('remarks','', ['class' => 'form-control','placeholder' => 'Remarks'])}} <small class="form-text text-danger">{{ $errors->first('remarks') }}</small> </div>
                    
                                    <div class="col-md-1"> {{Form::label('ProdBuilt', 'Product Built:')}}</div>  
                                    <div class="col-md-5">
                                            <?php  $getLastProd = DB::select("SELECT * FROM prodselect WHERE ProcessName ='Material Preparation' ORDER BY created_at DESC LIMIT 1 "); 
                                            $getProd = DB::select("SELECT * FROM producttype "); 
                                                   $lastSet = "";
                                           ?>
                                             @if(count($getLastProd) > 0)
                                             @foreach($getLastProd as $field)   
                                                    
                                            <?php $lastSet = $field->productName;  ?>
                                                      @endforeach
                                                      @else
                                                      <?php $lastSet = "Not Set.";  ?>
                                                      @endif  
                                     

                                       <select id="prodBuilt"  name="prodBuilt" class="form-control" >
                                               <option selected value="{{$lastSet}}">{{$lastSet}}</option>
                                                       @foreach ($getProd as $s)
                                                               <option value="{{ $s->prodName }}">{{ $s->prodName }}</option> 
                                                       @endforeach
                                       </select> 
                                       <small class="form-text text-danger">{{ $errors->first('prodBuilt') }}</small>  
                                    </div>
                                </div></br>
                            </div> 

                <div class="card">
                    <h5 class="card-header">Busbar-to-Busbar Pull Test Data Details</h5>
                        <div class="card-body">
                        <div class="jumbotron text-center">
                        <div class="row">
                            <div class="col-md-1"> {{Form::label('site1', 'Site 1:')}} </div>
                            <div class="col-md-3"> {{Form::text('site1','', ['class' => 'form-control','placeholder' => 'Pull Test1', 'id' => 'site1', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('site1') }}</small> </div> 
                            <div class="col-md-1"> {{Form::label('average', 'Average:')}} </div>
                            <div class="col-md-3"> {{Form::text('average','', ['class' => ' average form-control','placeholder' => 'Average', 'id' => 'average', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('average') }}</small> </div>     
                        </div></br> 
                        
                        <div class="row">
                            <div class="col-md-1"> {{Form::label('site2', 'Site 2:')}} </div>
                            <div class="col-md-3"> {{Form::text('site2','', ['class' => 'form-control','placeholder' => 'Pull Test2', 'id' => 'site2', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('site2') }}</small> </div>     
                        </div></br> 

                        <div class="row">
                            <div class="col-md-1"> {{Form::label('site3', 'Site 3:')}} </div>
                            <div class="col-md-3"> {{Form::text('site3','', ['class' => 'form-control','placeholder' => 'Pull Test3', 'id' => 'site3', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('site3') }}</small> </div>     
                        </div></br>
                    </div>
                        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}
                @endsection

                @push('jscript')
                    <script>
                        function calc(){
                            document.getElementById('average').value = ((
                            parseFloat(document.getElementById('site1').value) + 
                            parseFloat(document.getElementById('site2').value) + 
                            parseFloat(document.getElementById('site3').value)) / 3).toFixed(6);
                        }
                    </script>

                @endpush