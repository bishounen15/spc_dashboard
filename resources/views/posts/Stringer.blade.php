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
                            {{Form::select('Stringer', array('Stringer 1A' => 'Stringer 1A', 'Stringer 2B' => 'Stringer 2B',
                            'Stringer 3A' => 'Stringer 3A', 'Stringer 3B' => 'Stringer 3B'), '',['class'=>'form-control','placeholder'=>'Select Stringer'])}}
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
                                {{Form::label('Side', 'Side:')}}
                            </div>    
                            <div class="col-md-3">
                                {{Form::select('Side', array('Front' => 'Front Side', 'Back' => 'Back Side'), '',['class'=>'form-control','placeholder'=>'Select Side'])}}
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
                       
                    </div><br>
            </div>
        </div>
        <div class="card">
                <h5 class="card-header">Stringer Sites Details</h5>
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
                                                {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'PeelTestA'])}}
                                                <small class="form-text text-danger">{{ $errors->first('PeelTestA') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::select('CriteriaA[]', array('A' => 'A', 'B' => 'B',
                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteriaA'])}}
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
                                                {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltestB'])}}
                                                <small class="form-text text-danger">{{ $errors->first('peeltestB') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::select('CriteriaB[]', array('A' => 'A', 'B' => 'B',
                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteriaB'])}}
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
                                                {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=> 'peeltestC'])}}
                                                <small class="form-text text-danger">{{ $errors->first('peeltestC') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::select('CriteriaC[]', array('A' => 'A', 'B' => 'B',
                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteriaC'])}}
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
                                                {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id' => 'peeltestD'])}}
                                                <small class="form-text text-danger">{{ $errors->first('peeltestD') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                                {{Form::select('CriteriaD[]', array('A' => 'A', 'B' => 'B',
                                                        'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteriaD'])}}
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
                                                    {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest2A'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2A') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{Form::select('CriteriaA[]', array('A' => 'A', 'B' => 'B',
                                                        'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria2A'])}}
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
                                                    {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2B'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2B') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{Form::select('CriteriaB[]', array('A' => 'A', 'B' => 'B',
                                                        'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria2B'])}}
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
                                                    {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2C'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2C') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{Form::select('CriteriaC[]', array('A' => 'A', 'B' => 'B',
                                                        'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria2C'])}}
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
                                                    {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=>'peeltest2D'])}}
                                                    <small class="form-text text-danger">{{ $errors->first('peeltest2D') }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                        {{Form::select('CriteriaD[]', array('A' => 'A', 'B' => 'B',
                                                        'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria2D'])}}
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
                                                        {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3A'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3A') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{Form::select('CriteriaA[]', array('A' => 'A', 'B' => 'B',
                                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria3A'])}}
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
                                                        {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3B'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3B') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                        {{Form::select('CriteriaB[]', array('A' => 'A', 'B' => 'B',
                                                        'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria3B'])}}
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
                                                        {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3C'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3C') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{Form::select('CriteriaC[]', array('A' => 'A', 'B' => 'B',
                                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria3C'])}}
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
                                                        {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test', 'id'=>'peeltest3D'])}}
                                                        <small class="form-text text-danger">{{ $errors->first('peeltest3D') }}</small>
                                                </div>
                                                <div class="col-md-3">
                                                                {{Form::select('CriteriaD[]', array('A' => 'A', 'B' => 'B',
                                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria3D'])}}
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
                                                            {{Form::text('PeeltestA[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4A'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4A') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                                {{Form::select('CriteriaA[]', array('A' => 'A', 'B' => 'B',
                                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria4A'])}}
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
                                                            {{Form::text('PeeltestB[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4B'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4B') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                                {{Form::select('CriteriaB[]', array('A' => 'A', 'B' => 'B',
                                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria4B'])}}
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
                                                            {{Form::text('PeeltestC[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4C'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4C') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                                {{Form::select('CriteriaC[]', array('A' => 'A', 'B' => 'B',
                                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria4C'])}}
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
                                                            {{Form::text('PeeltestD[]', '', ['class' => 'form-control', 'placeholder'=>'Peel Test','id'=> 'peeltest4D'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('peeltest4D') }}</small>
                                                    </div>
                                                    <div class="col-md-3">
                                                                {{Form::select('CriteriaD[]', array('A' => 'A', 'B' => 'B',
                                                                'C' => 'C', 'D' => 'D'), '',['class'=>'form-control','placeholder'=>'Select Criteria', 'id'=>'criteria4D'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('criteria4D') }}</small>
                                                    </div>  
                                                    <div class="col-md-3">
                                                            {{Form::text('RemarksD[]', '', ['class' => 'form-control', 'placeholder'=>'Remarks ','id'=> 'remarks4D'])}}
                                                            <small class="form-text text-danger">{{ $errors->first('remarks4D') }}</small>
                                                    </div>                              
                                            </div>
            
                                        </div>
                                    </div>
                        <br> 
                        {{Form::submit('&nbsp;&nbsp;Submit&nbsp;&nbsp;', ['class' => 'btn btn-primary' ])}}  &emsp; <a href="/stringerdata" class="btn btn-danger">Cancel</a>
                        {!! Form::close() !!}
                    </div>
            </div><br>     
                    </div>
            </div>
    </div>

@endsection

