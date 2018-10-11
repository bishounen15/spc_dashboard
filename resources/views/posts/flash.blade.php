@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
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
                                <div class="col-md-1">
                                    {{Form::label('InspTime','Ins. Time')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('InspTime', '', ['class' => 'form-control', 'placeholder'=>'Inspection Time'])}}
                                    <small class="form-text text-danger">{{ $errors->first('InspTime') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('ISC','ISC:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('ISC', '', ['class' => 'form-control', 'placeholder'=>'ISC'])}}
                                    <small class="form-text text-danger">{{ $errors->first('ISC') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('UOC', 'VOC:')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('UOC', '', ['class' => 'form-control', 'placeholder'=>'Voc'])}}
                                        <small class="form-text text-danger">{{ $errors->first('UOC') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('IMPP', 'IMPP')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('IMPP', '', ['class' => 'form-control', 'placeholder'=>'IMPP'])}}
                                    <small class="form-text text-danger">{{ $errors->first('IMPP') }}</small>
                                </div>
                        </div><br>  
                        <div class="row">
                                
                                <div class="col-md-1">
                                    {{Form::label('UMPP', 'VMPP:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('UMPP', '', ['class' => 'form-control', 'placeholder'=>'VMPP'])}}
                                    <small class="form-text text-danger">{{ $errors->first('UMPP') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('PMPP', 'PMPP')}}
                                </div>    
                                <div class="col-md-2">
                                        {{Form::text('PMPP', '', ['class' => 'form-control', 'placeholder'=>'PMPP'])}}
                                        <small class="form-text text-danger">{{ $errors->first('PMPP') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('ShuntResist', 'Shs Rst:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('ShuntResist', '', ['class' => 'form-control', 'placeholder'=>'Shunt Resistance'])}}
                                    <small class="form-text text-danger">{{ $errors->first('ShuntResist') }}</small>
                                </div>
                                <div class="col-md-1">
                                    {{Form::label('FF', 'FF:')}}
                                </div>    
                                <div class="col-md-2">
                                    {{Form::text('FF', '', ['class' => 'form-control', 'placeholder'=>'FF'])}}
                                    <small class="form-text text-danger">{{ $errors->first('FF') }}</small>
                                </div>
                        </div><br>

                        <div class="row">
                                
                            <div class="col-md-2">
                                {{Form::label('Product Type', 'Product Type:')}}
                            </div>    
                            <div class="col-md-4">
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
                          
                        
                            <div class="col-md-1">
                                {{Form::label('Target', 'Target:')}}
                            </div>    
                            <div class="col-md-2">
                                <?php  $getLastProd = DB::select("SELECT * FROM prodselect WHERE ProcessName ='FLASH TEST DATA' ORDER BY created_at DESC LIMIT 1 "); 
                              
                                       $lastSet = "";
                                       $last = ""
                               ?>
                                 @if(count($getLastProd) > 0)
                                 @foreach($getLastProd as $field)   
                                        
                                <?php $lastSet = $field->productName;  
                                  $getProd = DB::select("SELECT * FROM flashsetup WHERE ProductType = '".$lastSet."' "); 
                                  
                                ?>
                                   @if(count( $getProd) > 0)
                                   @foreach( $getProd as $field)   
                                  <?php $last = $field->Pmpp; ?>
                                   @endforeach
                                   @endif
                                          @endforeach
                                          @else
                                          <?php $last = "Not Set.";  ?>
                                          @endif  
                         
                                {{Form::text('Target', $last, ['class' => 'form-control'])}}
                                <small class="form-text text-danger">{{ $errors->first('target') }}</small>
                            </div>
                            <div class="col-md-1">
                                {{Form::label('FF', 'FF:')}}
                            </div>    
                            <div class="col-md-2">
                                {{Form::text('FF', '', ['class' => 'form-control', 'placeholder'=>'FF'])}}
                                <small class="form-text text-danger">{{ $errors->first('FF') }}</small>
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