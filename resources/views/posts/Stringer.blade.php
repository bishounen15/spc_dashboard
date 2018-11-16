@extends('layouts.app')

@section('content')
    <div class="container" style="width:120%">
                {!! Form::open(['action' => 'StringerController@store', 'method' => 'POST']) !!}
      
        <div class="card">
                <h5 class="card-header">Stringer Data Inputs</h5>
            <div class="card-body">
              
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
                            {{Form::select('Stringer', array('Stringer 1A' => 'Stringer 1A','Stringer 1B' => 'Stringer 1B', 'Stringer 2A' => 'Stringer 2A', 'Stringer 2B' => 'Stringer 2B',
                            'Stringer 3A' => 'Stringer 3A', 'Stringer 3B' => 'Stringer 3B','Rework' => 'Rework'), '',['class'=>'form-control stringerval','placeholder'=>'Select Stringer'])}}
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
                        <div class="col-md-1 sidediv">
                                {{Form::label('Side', 'Side:')}}
                            </div>    
                            <div class="col-md-3 sidediv">
                                {{Form::select('Side', array('Front' => 'Front Side', 'Back' => 'Back Side'), '',['class'=>'form-control sidesel','placeholder'=>'Select Side','id'=>'side'])}}
                                <small class="form-text text-danger">{{ $errors->first('Side') }}</small>
                            </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-1">
                            {{Form::label('Cell No.', 'Cell No.:')}}
                        </div>    
                        <div class="col-md-3">
                            {{Form::text('CellNo', '', ['class' => 'form-control', 'placeholder'=>'Cell No.'])}}
                            <small class="form-text text-danger">{{ $errors->first('CellNo') }}</small>
                        </div>
                        <div class="col-md-1">
                                {{Form::label('Busbar', 'Busbar:')}}
                            </div>    
                            <div class="col-md-3">
                                {{Form::select('bb', array('5bb' => '5bb', '4bb' => '4bb'), '4bb',['class'=>'form-control bb','placeholder'=>'Select bb'])}}
                                <small class="form-text text-danger">{{ $errors->first('bb') }}</small>
                            </div>
                            <div class="col-md-1"> {{Form::label('ProdBuilt', 'Product Built:')}}</div>  
                            <div class="col-md-3">
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
                       
                    </div><br>
            </div>
        </div>


        <div class="4bb">
        <div class="row">
        <div class="col-md-6 frontdiv">
                                
        
        <div class="card">
                <h5 class="card-header">Stringer Sites Details <bold>(FRONT)</bold></h5>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header"> Site 1</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        {{Form::label('Location', 'Location:')}}
                                    </div>
                                    <div class="col-md-3">
                                            {{Form::label('Peel Test', 'Peel Test:')}}
                                    </div>
                                    <div class="col-md-3">
                                            {{Form::label('Criteria', 'Criteria:')}}
                                    </div>  
                                    <div class="col-md-3">
                                            {{Form::label('Remarks', 'Remarks:')}}
                                    </div>                                 
                                </div>
                                <div class="row">
                                        <div class="col-md-3">
                                                {{Form::text('LocA[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'required' => 'true'])}}
                                                <small class="form-text text-danger">{{ $errors->first('peeltestA') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                        {{ Form::radio('CriteriaA1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaA1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                <small class="form-text text-danger">{{ $errors->first('criteriaA') }}</small>
                                        </div>  
                                        <div class="col-md-3">
                                                {{Form::text('RemarksA[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarksA'])}}
                                                <small class="form-text text-danger">{{ $errors->first('remarksA') }}</small>
                                        </div>                            
                                </div><br>
                                <div class="row">
                                        <div class="col-md-3">
                                                
                                                {{Form::text('LocB[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'required' => 'true'])}}
                                                <small class="form-text text-danger">{{ $errors->first('peeltestB') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                        {{ Form::radio('CriteriaB1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaB1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                <small class="form-text text-danger">{{ $errors->first('criteriaB') }}</small>
                                        </div>  
                                        <div class="col-md-3">
                                                {{Form::text('RemarksB[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarksB'])}}
                                                <small class="form-text text-danger">{{ $errors->first('remarksB') }}</small>
                                        </div>                           
                                </div><br>
                                <div class="row">
                                        <div class="col-md-3">
                                                {{Form::text('LocC[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=> 'peeltestC', 'required' => 'true'])}}
                                                <small class="form-text text-danger">{{ $errors->first('peeltestC') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                        {{ Form::radio('CriteriaC1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaC1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                <small class="form-text text-danger">{{ $errors->first('criteriaC') }}</small>
                                        </div>  
                                        <div class="col-md-3">
                                                {{Form::text('RemarksC[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id' => 'remarksC'])}}
                                                <small class="form-text text-danger">{{ $errors->first('remarksC') }}</small>
                                        </div>                         
                                </div><br>
                                <div class="row">
                                        <div class="col-md-3">
                                                {{Form::text('LocD[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id' => 'peeltestD', 'required' => 'true'])}}
                                                <small class="form-text text-danger">{{ $errors->first('peeltestD') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                        {{ Form::radio('CriteriaD1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaD1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                <small class="form-text text-danger">{{ $errors->first('criteriaD') }}</small>
                                        </div>  
                                        <div class="col-md-3">
                                                {{Form::text('RemarksD[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=> 'remarksD'])}}
                                                <small class="form-text text-danger">{{ $errors->first('remarksD') }}</small>
                                        </div>                              
                                </div>

                            </div>
                        </div>
                        <div class="card">
                                <div class="card-header"> Site 2</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{Form::label('Location', 'Location:')}}
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::label('Peel Test', 'Peel Test:')}}
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::label('Criteria', 'Criteria:')}}
                                        </div>  
                                        <div class="col-md-3">
                                                {{Form::label('Remarks', 'Remarks:')}}
                                        </div>                                 
                                    </div>
                                    <div class="row">
                                            <div class="col-md-3">
                                                    {{Form::text('LocA[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest2A', 'required' => 'true'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2A') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{ Form::radio('CriteriaA2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaA2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                    <small class="form-text text-danger">{{ $errors->first('criteria2A') }}</small>
                                            </div>  
                                            <div class="col-md-3">
                                                    {{Form::text('RemarksA[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks2A'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('remarks2A') }}</small>
                                            </div>                            
                                    </div><br>
                                    <div class="row">
                                            <div class="col-md-3">
                                                    {{Form::text('LocB[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2B', 'required' => 'true'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2B') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{ Form::radio('CriteriaB2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaB2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                    <small class="form-text text-danger">{{ $errors->first('criteria2B') }}</small>
                                            </div>  
                                            <div class="col-md-3">
                                                    {{Form::text('RemarksB[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=>'remarks2B'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('remarks2B') }}</small>
                                            </div>                           
                                    </div><br>
                                    <div class="row">
                                            <div class="col-md-3">
                                                    {{Form::text('LocC[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2C', 'required' => 'true'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2C') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{ Form::radio('CriteriaC2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaC2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                    <small class="form-text text-danger">{{ $errors->first('criteria2C') }}</small>
                                            </div>  
                                            <div class="col-md-3">
                                                    {{Form::text('RemarksC[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=>'remarks2C'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('remarks2C') }}</small>
                                            </div>                         
                                    </div><br>
                                    <div class="row">
                                            <div class="col-md-3">
                                                    {{Form::text('LocD[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2D', 'required' => 'true'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2D') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{ Form::radio('CriteriaD2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaD2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                    <small class="form-text text-danger">{{ $errors->first('criteria2D') }}</small>
                                            </div>  
                                            <div class="col-md-3">
                                                    {{Form::text('RemarksD[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=>'remarks2D'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('remarks2D') }}</small>
                                            </div>                              
                                    </div>
    
                                </div>
                            </div>
                            <div class="card">
                                    <div class="card-header"> Site 3</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{Form::label('Location', 'Location:')}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::label('Peel Test', 'Peel Test:')}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::label('Criteria', 'Criteria:')}}
                                            </div>  
                                            <div class="col-md-3">
                                                    {{Form::label('Remarks', 'Remarks:')}}
                                            </div>                                 
                                        </div>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocA[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3A', 'required' => 'true'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3A') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaA3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaA3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria3A') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksA[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3A'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks3A') }}</small>
                                                </div>                            
                                        </div><br>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocB[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3B', 'required' => 'true'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3B') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaB3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaB3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria3B') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksB[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3B'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks3B') }}</small>
                                                </div>                           
                                        </div><br>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocC[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3C', 'required' => 'true'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3C') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaC3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaC3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria3C') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksC[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3C'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks3C') }}</small>
                                                </div>                         
                                        </div><br>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocD[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3D', 'required' => 'true'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3D') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaD3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaD3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria3D') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksD[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3D'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks3D') }}</small>
                                                </div>                              
                                        </div>
        
                                    </div>
                                </div>
                                <div class="card">
                                        <div class="card-header"> Site 4</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    {{Form::label('Location', 'Location:')}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::label('Peel Test', 'Peel Test:')}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::label('Criteria', 'Criteria:')}}
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::label('Remarks', 'Remarks:')}}
                                                </div>                                 
                                            </div>
                                            <div class="row">
                                                    <div class="col-md-3">
                                                            {{Form::text('LocA[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                    </div>
                                                    <div class="col-md-3">
                                                            {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4A', 'required' => 'true'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4A') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ Form::radio('CriteriaA4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                        {{ Form::radio('CriteriaA4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                            <small class="form-text text-danger">{{ $errors->first('criteria4A') }}</small>
                                                    </div>  
                                                    <div class="col-md-3">
                                                            {{Form::text('RemarksA[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4A'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('remarks4A') }}</small>
                                                    </div>                            
                                            </div><br>
                                            <div class="row">
                                                    <div class="col-md-3">
                                                            {{Form::text('LocB[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                    </div>
                                                    <div class="col-md-3">
                                                            {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4B', 'required' => 'true'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4B') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                                {{ Form::radio('CriteriaB4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaB4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                            <small class="form-text text-danger">{{ $errors->first('criteria4B') }}</small>
                                                    </div>  
                                                    <div class="col-md-3">
                                                            {{Form::text('RemarksB[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4B'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('remarks4B') }}</small>
                                                    </div>                           
                                            </div><br>
                                            <div class="row">
                                                    <div class="col-md-3">
                                                            {{Form::text('LocC[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                    </div>
                                                    <div class="col-md-3">
                                                            {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4C', 'required' => 'true'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4C') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                                {{ Form::radio('CriteriaC4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaC4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                            <small class="form-text text-danger">{{ $errors->first('criteria4C') }}</small>
                                                    </div>  
                                                    <div class="col-md-3">
                                                            {{Form::text('RemarksC[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4C'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('remarks4C') }}</small>
                                                    </div>                         
                                            </div><br>
                                            <div class="row">
                                                    <div class="col-md-3">
                                                            {{Form::text('LocD[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                    </div>
                                                    <div class="col-md-3">
                                                            {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4D', 'required' => 'true'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4D') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                                {{ Form::radio('CriteriaD4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaD4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                            <small class="form-text text-danger">{{ $errors->first('criteria4D') }}</small>
                                                    </div>  
                                                    <div class="col-md-3">
                                                            {{Form::text('RemarksD[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4D'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('remarks4D') }}</small>
                                                    </div>                              
                                            </div>
            
                                        </div>
                                    </div>
                                </div>
                           </div>
                
                </div>

                <div class="col-md-6 backdiv">          
                         
          
                                <div class="card">
                                                <h5 class="card-header">Stringer Sites Details <bold>(BACK)</bold></h5>
                                                    <div class="card-body">
                                                        <div class="card">
                                                            <div class="card-header"> Site 1</div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        {{Form::label('Location', 'Location:')}}
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                            {{Form::label('Peel Test', 'Peel Test:')}}
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                            {{Form::label('Criteria', 'Criteria:')}}
                                                                    </div>  
                                                                    <div class="col-md-3">
                                                                            {{Form::label('Remarks', 'Remarks:')}}
                                                                    </div>                                 
                                                                </div>
                                                                <div class="row">
                                                                        <div class="col-md-3">
                                                                                {{Form::text('LocAback[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                {{Form::text('PeeltestAback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'required' => 'true'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('peeltestA') }}</small>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaAback1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaAback1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                <small class="form-text text-danger">{{ $errors->first('criteriaA') }}</small>
                                                                        </div>  
                                                                        <div class="col-md-3">
                                                                                {{Form::text('RemarksAback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarksA'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('remarksA') }}</small>
                                                                        </div>                            
                                                                </div><br>
                                                                <div class="row">
                                                                        <div class="col-md-3">
                                                                                {{Form::text('LocBback[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                {{Form::text('PeeltestBback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'required' => 'true'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('peeltestB') }}</small>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaBback1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaBback1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                <small class="form-text text-danger">{{ $errors->first('criteriaB') }}</small>
                                                                        </div>  
                                                                        <div class="col-md-3">
                                                                                {{Form::text('RemarksBback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarksB'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('remarksB') }}</small>
                                                                        </div>                           
                                                                </div><br>
                                                                <div class="row">
                                                                        <div class="col-md-3">
                                                                                {{Form::text('LocCback[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                {{Form::text('PeeltestCback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=> 'peeltestC', 'required' => 'true'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('peeltestC') }}</small>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaCback1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaCback1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                <small class="form-text text-danger">{{ $errors->first('criteriaC') }}</small>
                                                                        </div>  
                                                                        <div class="col-md-3">
                                                                                {{Form::text('RemarksCback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id' => 'remarksC'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('remarksC') }}</small>
                                                                        </div>                         
                                                                </div><br>
                                                                <div class="row">
                                                                        <div class="col-md-3">
                                                                                {{Form::text('LocDback[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                {{Form::text('PeeltestDback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id' => 'peeltestD', 'required' => 'true'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('peeltestD') }}</small>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaDback1', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaDback1', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                <small class="form-text text-danger">{{ $errors->first('criteriaD') }}</small>
                                                                        </div>  
                                                                        <div class="col-md-3">
                                                                                {{Form::text('RemarksDback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=> 'remarksD'])}}
                                                                                <small class="form-text text-danger">{{ $errors->first('remarksD') }}</small>
                                                                        </div>                              
                                                                </div>
                                
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                                <div class="card-header"> Site 2</div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            {{Form::label('Location', 'Location:')}}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                {{Form::label('Peel Test', 'Peel Test:')}}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                {{Form::label('Criteria', 'Criteria:')}}
                                                                        </div>  
                                                                        <div class="col-md-3">
                                                                                {{Form::label('Remarks', 'Remarks:')}}
                                                                        </div>                                 
                                                                    </div>
                                                                    <div class="row">
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('LocAback[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('PeeltestAback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest2A', 'required' => 'true'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2A') }}</small>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaAback2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaAback2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                    <small class="form-text text-danger">{{ $errors->first('criteria2A') }}</small>
                                                                            </div>  
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('RemarksAback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks2A'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('remarks2A') }}</small>
                                                                            </div>                            
                                                                    </div><br>
                                                                    <div class="row">
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('LocBback[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('PeeltestBback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2B', 'required' => 'true'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2B') }}</small>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaBback2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaBback2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                    <small class="form-text text-danger">{{ $errors->first('criteria2B') }}</small>
                                                                            </div>  
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('RemarksBback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=>'remarks2B'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('remarks2B') }}</small>
                                                                            </div>                           
                                                                    </div><br>
                                                                    <div class="row">
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('LocCback[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('PeeltestCback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2C', 'required' => 'true'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2C') }}</small>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaCback2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaCback2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                    <small class="form-text text-danger">{{ $errors->first('criteria2C') }}</small>
                                                                            </div>  
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('RemarksCback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=>'remarks2C'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('remarks2C') }}</small>
                                                                            </div>                         
                                                                    </div><br>
                                                                    <div class="row">
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('LocDback[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('PeeltestDback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2D', 'required' => 'true'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2D') }}</small>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                        {{ Form::radio('CriteriaDback2', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                        {{ Form::radio('CriteriaDback2', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                    <small class="form-text text-danger">{{ $errors->first('criteria2D') }}</small>
                                                                            </div>  
                                                                            <div class="col-md-3">
                                                                                    {{Form::text('RemarksDback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=>'remarks2D'])}}
                                                                                    <small class="form-text text-danger">{{ $errors->first('remarks2D') }}</small>
                                                                            </div>                              
                                                                    </div>
                                    
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                    <div class="card-header"> Site 3</div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                {{Form::label('Location', 'Location:')}}
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                    {{Form::label('Peel Test', 'Peel Test:')}}
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                    {{Form::label('Criteria', 'Criteria:')}}
                                                                            </div>  
                                                                            <div class="col-md-3">
                                                                                    {{Form::label('Remarks', 'Remarks:')}}
                                                                            </div>                                 
                                                                        </div>
                                                                        <div class="row">
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('LocAback[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('PeeltestAback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3A', 'required' => 'true'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3A') }}</small>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaAback3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaAback3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                        <small class="form-text text-danger">{{ $errors->first('criteria3A') }}</small>
                                                                                </div>  
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('RemarksAback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3A'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('remarks3A') }}</small>
                                                                                </div>                            
                                                                        </div><br>
                                                                        <div class="row">
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('LocBback[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('PeeltestBback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3B', 'required' => 'true'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3B') }}</small>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaBback3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaBback3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                        <small class="form-text text-danger">{{ $errors->first('criteria3B') }}</small>
                                                                                </div>  
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('RemarksBback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3B'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('remarks3B') }}</small>
                                                                                </div>                           
                                                                        </div><br>
                                                                        <div class="row">
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('LocCback[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('PeeltestCback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3C', 'required' => 'true'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3C') }}</small>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaCback3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaCback3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                        <small class="form-text text-danger">{{ $errors->first('criteria3C') }}</small>
                                                                                </div>  
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('RemarksCback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3C'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('remarks3C') }}</small>
                                                                                </div>                         
                                                                        </div><br>
                                                                        <div class="row">
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('LocDback[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('PeeltestDback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3D', 'required' => 'true'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3D') }}</small>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaDback3', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaDback3', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                        <small class="form-text text-danger">{{ $errors->first('criteria3D') }}</small>
                                                                                </div>  
                                                                                <div class="col-md-3">
                                                                                        {{Form::text('RemarksDback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ', 'id'=>'remarks3D'])}}
                                                                                        <small class="form-text text-danger">{{ $errors->first('remarks3D') }}</small>
                                                                                </div>                              
                                                                        </div>
                                        
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                        <div class="card-header"> Site 4</div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    {{Form::label('Location', 'Location:')}}
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                        {{Form::label('Peel Test', 'Peel Test:')}}
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                        {{Form::label('Criteria', 'Criteria:')}}
                                                                                </div>  
                                                                                <div class="col-md-3">
                                                                                        {{Form::label('Remarks', 'Remarks:')}}
                                                                                </div>                                 
                                                                            </div>
                                                                            <div class="row">
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('LocAback[]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('PeeltestAback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4A', 'required' => 'true'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4A') }}</small>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaAback4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaAback4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                            <small class="form-text text-danger">{{ $errors->first('criteria4A') }}</small>
                                                                                    </div>  
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('RemarksAback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4A'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('remarks4A') }}</small>
                                                                                    </div>                            
                                                                            </div><br>
                                                                            <div class="row">
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('LocBback[]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('PeeltestBback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4B', 'required' => 'true'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4B') }}</small>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaBback4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaBback4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                            <small class="form-text text-danger">{{ $errors->first('criteria4B') }}</small>
                                                                                    </div>  
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('RemarksBback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4B'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('remarks4B') }}</small>
                                                                                    </div>                           
                                                                            </div><br>
                                                                            <div class="row">
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('LocCback[]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('PeeltestCback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4C', 'required' => 'true'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4C') }}</small>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaCback4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaCback4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                            <small class="form-text text-danger">{{ $errors->first('criteria4C') }}</small>
                                                                                    </div>  
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('RemarksCback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4C'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('remarks4C') }}</small>
                                                                                    </div>                         
                                                                            </div><br>
                                                                            <div class="row">
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('LocDback[]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('PeeltestDback[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4D', 'required' => 'true'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4D') }}</small>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                                {{ Form::radio('CriteriaDback4', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                                {{ Form::radio('CriteriaDback4', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                                            <small class="form-text text-danger">{{ $errors->first('criteria4D') }}</small>
                                                                                    </div>  
                                                                                    <div class="col-md-3">
                                                                                            {{Form::text('RemarksDback[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4D'])}}
                                                                                            <small class="form-text text-danger">{{ $errors->first('remarks4D') }}</small>
                                                                                    </div>                              
                                                                            </div>
                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                           </div>

                </div>
                
                </div>
   
                



               
                                <div class="row">
                                <div class="col-md-6 5bbFront">
                        <div class="card">
                                    <div class="card-header"> Site 5</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{Form::label('Location', 'Location:')}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::label('Peel Test', 'Peel Test:')}}
                                            </div>
                                            <div class="col-md-3">
                                                    {{Form::label('Criteria', 'Criteria:')}}
                                            </div>  
                                            <div class="col-md-3">
                                                    {{Form::label('Remarks', 'Remarks:')}}
                                            </div>                                 
                                        </div>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocA[ ]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestA[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4A'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest4A') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaA5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaA5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria5A') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksA[ ]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4A'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks5A') }}</small>
                                                </div>                            
                                        </div><br>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocB[ ]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestB[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4B'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest5B') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaB5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaB5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria5B') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksB[ ]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4B'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks5B') }}</small>
                                                </div>                           
                                        </div><br>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocC[ ]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestC[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4C'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest5C') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaC5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaC5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria5C') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksC[ ]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4C'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks5C') }}</small>
                                                </div>                         
                                        </div><br>
                                        <div class="row">
                                                <div class="col-md-3">
                                                        {{Form::text('LocD[ ]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::text('PeeltestD[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4D'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest5D') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{ Form::radio('CriteriaD5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                {{ Form::radio('CriteriaD5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                        <small class="form-text text-danger">{{ $errors->first('criteria5D') }}</small>
                                                </div>  
                                                <div class="col-md-3">
                                                        {{Form::text('RemarksD[ ]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4D'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('remarks5D') }}</small>
                                                </div>                              
                                        </div>
        
                                    </div>
                                </div>


                        </div>
                      
                        <div class="col-md-6 5bbBack">
                                        <div class="card">
                                                        <div class="card-header"> Site 5 Back</div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    {{Form::label('Location', 'Location:')}}
                                                                </div>
                                                                <div class="col-md-3">
                                                                        {{Form::label('Peel Test', 'Peel Test:')}}
                                                                </div>
                                                                <div class="col-md-3">
                                                                        {{Form::label('Criteria', 'Criteria:')}}
                                                                </div>  
                                                                <div class="col-md-3">
                                                                        {{Form::label('Remarks', 'Remarks:')}}
                                                                </div>                                 
                                                            </div>
                                                            <div class="row">
                                                                    <div class="col-md-3">
                                                                            {{Form::text('LocA[ ]', 'A', ['class' => 'form-control', 'readonly'])}}
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                            {{Form::text('PeeltestA[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4A'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4A') }}</small>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                                    {{ Form::radio('CriteriaAback5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                    {{ Form::radio('CriteriaAback5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                            <small class="form-text text-danger">{{ $errors->first('criteria5A') }}</small>
                                                                    </div>  
                                                                    <div class="col-md-3">
                                                                            {{Form::text('RemarksA[ ]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4A'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('remarks5A') }}</small>
                                                                    </div>                            
                                                            </div><br>
                                                            <div class="row">
                                                                    <div class="col-md-3">
                                                                            {{Form::text('LocB[ ]', 'B', ['class' => 'form-control', 'readonly'])}}
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                            {{Form::text('PeeltestB[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4B'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest5B') }}</small>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                                    {{ Form::radio('CriteriaBback5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                    {{ Form::radio('CriteriaBback5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                            <small class="form-text text-danger">{{ $errors->first('criteria5B') }}</small>
                                                                    </div>  
                                                                    <div class="col-md-3">
                                                                            {{Form::text('RemarksB[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4B'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('remarks5B') }}</small>
                                                                    </div>                           
                                                            </div><br>
                                                            <div class="row">
                                                                    <div class="col-md-3">
                                                                            {{Form::text('LocC[ ]', 'C', ['class' => 'form-control', 'readonly'])}}
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                            {{Form::text('PeeltestC[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4C'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest5C') }}</small>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                                    {{ Form::radio('CriteriaCback5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                    {{ Form::radio('CriteriaCback5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                            <small class="form-text text-danger">{{ $errors->first('criteria5C') }}</small>
                                                                    </div>  
                                                                    <div class="col-md-3">
                                                                            {{Form::text('RemarksC[ ]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4C'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('remarks5C') }}</small>
                                                                    </div>                         
                                                            </div><br>
                                                            <div class="row">
                                                                    <div class="col-md-3">
                                                                            {{Form::text('LocD[ ]', 'D', ['class' => 'form-control', 'readonly'])}}
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                            {{Form::text('PeeltestD[ ]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4D'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('peeltest5D') }}</small>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                                    {{ Form::radio('CriteriaDback5', 'A' , true) }} &nbsp; {{Form::label('A', 'A')}}&nbsp;
                                                                                    {{ Form::radio('CriteriaDback5', 'B' , false) }} &nbsp;{{Form::label('B', 'B')}}&nbsp;
                                                                            <small class="form-text text-danger">{{ $errors->first('criteria5D') }}</small>
                                                                    </div>  
                                                                    <div class="col-md-3">
                                                                            {{Form::text('RemarksD[ ]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4D'])}}
                                                                            <small class="form-text text-danger">{{ $errors->first('remarks5D') }}</small>
                                                                    </div>                              
                                                            </div>
                            
                                                        </div>
                                                    </div>
                          


                        </div>
                </div>
            <br> 
            
    
    {{Form::submit('&nbsp;&nbsp;Submit&nbsp;&nbsp;', ['class' => 'btn btn-primary' ])}}  &emsp; <a href="/stringerdata" class="btn btn-danger">Cancel</a>
    {!! Form::close() !!}  
               <div> 
           
               </div> 
                    </div>
              
                    </div>



                    
            </div>
            
            <br>      
                    </div>
                   
            </div>
          
    </div>

@endsection
@push('jscript')

<script>
        $(document).ready(function () {
                 $('.5bbFront').hide();
                 $('.5bbBack').hide();
                 $('.sidediv').hide();
                 $('.sidediv').val('');
                });
        
              $('.bb').on('change', function (e) {
           var optionSelected = $("option:selected", this);
           var valueSelected = this.value;    
        
         if(valueSelected == '4bb' )
         {
                
                 $('.5bbFront').hide();
                 $('.5bbBack').hide();
                 $('.frontdiv').show();    
                 $('.backdiv').show(); 
                
  
         }else if(valueSelected == '5bb' ){
              
                
                 $('.5bbFront').show();
                 $('.5bbBack').show();
                 $('.frontdiv').show();    
                 $('.backdiv').show();                
                 
         }else{


                 $('.frontdiv').show();    
                 $('.backdiv').show(); 
                 $('.5bbFront').show();
                 $('.5bbBack').show();
                
                 //$('.4bb').show();
               
         }
         
           });

      /*  $('.stringerval').on('change', function (e) {
              //  $('select option').prop('disabled', true);
           var optionSelected1 = $("option:selected", this);
           var valueSelected1 = this.value;    
      
        
         if(valueSelected1 == 'Rework' )
         {       $('.sidediv').show(); 
                 $('.5bbFront').hide();
                 $('.5bbBack').hide();
                 $('.4bb').hide();    
                 //$('.bb').val(''); 
         }else{
                $('.sidediv').val('');
                $('.sidediv').hide(); 
                 $('.5bbFront').hide();
                 $('.5bbBack').hide();
                 $('.frontdiv').show();    
                 $('.backdiv').show(); 
                // $('.bb').val('');   
                // $('.sidesel').val('');   
         }
           }); */
        
         

           
          
          



           </script>

   @endpush

