@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => $controller, 'method' => 'POST']) !!}
    <div class="container" style="width:120%">
            <div class="card">
            <h5 class="card-header">{{$tbl}}</h5>
                <div class="card-body">
                    <div class="jumbotron text-center">
                           
                            @if(count($alldata) > 0)
                            @foreach($alldata as $cols)
                           
                            @if($cols != null )
                   
                            @if($cols == $selectVal )
                   
                            <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                    <div class="col-md-4">
                                            <select id="bom"  name="bom" class="form-control">
                                                    @foreach ($getbom as $s)
                                                            <option selected value="{{ $s->$selectVal2 }}">{{ $s->$selectVal2 }}</option> 
                                                    @endforeach
                                                </select>   
                                               
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>

                                @else

                                <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                        <div class="col-md-4"> {{ Form::text('txt[]','',['class'=>'form-control'] )}} </div>
                                        <div class="col-md-2"></div>
                                    </div>
                            

                             @endif

                             @endif
                              
                            @endforeach
                          @endif
                                <br>
                                {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                                {!! Form::close() !!}
                    </div>
                </div>
            </div>


            <div class="card">
                <h5 class="card-header">Records</h5>
                    <div class="card-body">
                        <div class="jumbotron text-center">
            <table class="table table-striped" style="font-size:10px;">
                
                        @if(count($getdata) > 0)
                        
                        <tr>
                            <th>SEQ </th>
                        @foreach($alldata as $fieldCol)   
                        @if(   $fieldCol != null  )
                             <th>{{ $fieldCol }}</th>
                        @endif
                            @endforeach 
                        </tr>   
                        <tr>
                           
                                <?php $i=0 ?>  
                           
                        @foreach($getdata as $data) 
                        <?php $i++ ?>  
                       
                           <td>{{ $i }}</td>
                                @foreach($fields as $fieldCol) 
                               
                                @if(  $fieldCol != "id"  && $fieldCol != "created_at"  && $fieldCol != "updated_at"  )
                                
                               <td>{{ $data->$fieldCol }}</td>
                                @endif
                                    @endforeach 

                        </tr> 
                        @endforeach
                         
                              
                @else
                <p>No Records Found</p>
                @endif
                    </table>
                        </div>
                    </div></div>
    </div>

                   
                @endsection

            