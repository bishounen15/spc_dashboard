@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => $controller, 'method' => 'POST']) !!}
    <div class="container" style="width:120%">
            <div class="card">
            <h5 class="card-header">{{$tbl}}</h5>
                <div class="card-body">
                        <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Add Record</button>
                           

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Add {{$tbl}}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>          
                        <div >
                        <br/>
                            @if(count($alldata) > 0)
                            @foreach($alldata as $cols)
                           
                            @if($cols != null )
                   
                            @if($cols == "Critical Node" )
                   
                            <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                    <div class="col-md-4">
                                            <select id="subPro"  name="subPro" class="form-control">
                                                    @foreach ($getSubPro as $s)
                                                            <option selected value="{{ $s->subProcessName }}">{{ $s->subProcessName }}</option> 
                                                    @endforeach
                                                </select>   
                                               
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>

                                @elseif($cols == "BOM Type" )
                   
                                <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                        <div class="col-md-4">
                                                <select id="bom"  name="bom" class="form-control">
                                                        @foreach ($getbom as $s)
                                                                <option selected value="{{ $s->bomType }}">{{ $s->bomType }}</option> 
                                                        @endforeach
                                                    </select>   
                                                   
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    
                                    @elseif($cols == "Sealant Type" )
                   
                                    <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                            <div class="col-md-4">
                                                    <select id="sealantType"  name="sealantType" class="form-control">
                                                        <option selected value="NA">NA</option> 
                                                                    <option selected value="Sausage">Sausage</option> 
                                                                    <option selected value="Pail">Pail</option> 
                                                        </select>   
                                                       
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
        
                                        @elseif($cols == "JBOX Type" )
                   
                                        <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                                <div class="col-md-4">
                                                        <select id="jboxType"  name="jboxType" class="form-control">
                                                                         <option selected value="NA">NA</option> 
                                                                         
                                                                         <option selected value="Sunter">Sunter</option> 
                                                                        <option selected value="PVBar">PVBar</option> 
                                                               
                                                            </select>   
                                                           
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                            
                                        @elseif($cols == "Cell Type" )
                   
                                        <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                                <div class="col-md-4">
                                                        <select id="cellType"  name="cellType" class="form-control">
                                                                         <option selected value="72">72 cell</option> 
                                                                         
                                                                         <option selected value="60">60 cell</option> 
                                                                         <option selected value="all">All</option> 
                                                                        
                                                               
                                                            </select>   
                                                           
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                            @elseif($cols == "BB No" )
                   
                                            <div class="row">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                                    <div class="col-md-4">
                                                            <select id="bbno"  name="bbno" class="form-control">
                                                                             <option selected value="4bb">4bb</option> 
                                                                             
                                                                             <option selected value="5bb">5bb</option> 
                                                                             <option selected value="NA">NA</option> 
                                                                            
                                                                   
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
                                <div class="modal-footer">
                                        {{Form::submit('Save',['class'=>'btn btn-primary'])}}
                                        {!! Form::close() !!}

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                            </div>

                            
                        </div>
                     
                        
                        
                        </div>
                      </div>
                
                   
                </div>
            </div>





            <div class="card">
                <h5 class="card-header">Records</h5>
                    <div class="card-body">
                        <div class="jumbotron text-center">
            <table class="table table-striped" style="font-size:12px;">
                
                        @if(count($getdata) > 0)
                        
                        <tr>
                            <th>SEQ </th>
                        @foreach($alldata as $fieldCol)   
                        @if(   $fieldCol != null  )
                             <th>{{ $fieldCol }}</th>
                        @endif
                            @endforeach 
                            <th colspan="2"><center> Actions</center></th>
                        </tr>   
                        <tr>
                           
                                <?php $i=0 ?>  
                           
                        @foreach($getdata as $data) 
                        <?php $i++ ?>  
                       
                           <td>{{ $i }}</td>
                                @foreach($fields as $fieldCol)     
                                @if( $fieldCol != "id"  &&  $fieldCol != "paramID"  && $fieldCol != "created_at"  && $fieldCol != "updated_at"  ) 
                               <td>{{ $data->$fieldCol }}</td>
                                @endif
                                @endforeach 


                                @foreach($fields as $fieldCol) 
                                @if(  $fieldCol == "id"   )
        
                                
                                <td>                             
                                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModalEdit{{$data->$fieldCol}}">Edit</button> 
        
                               
                                    <div class="modal fade" id="myModalEdit{{$data->$fieldCol}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content" style="font-size:15px;">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Update {{$tbl}}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>          
                                <div >
                                <br/>
                                {!! Form::open(['action' => [ $controllerUp, $data->$fieldCol ], 'method' => 'POST','class'=>'update']) !!}
                              
                               
                                <div class="row">    
                                        <div class="col-md-1">   </div>
                                        <div class="col-md-4">   
        
        
                                                    @if(count($alldata) > 0)
                                                    @foreach($alldata as $cols)   
                                                             @if($cols != null )
                                                            <div class="row">                        
                                                            <div class="col-md-12" style="margin-top:5px;"> {{Form::label($cols, $cols),['class'=>'form-control'] }} <br/></div>                                                            
                                                            </div>  
                                                             @endif
                                                    @endforeach
                                                    @endif
        
                                        </div>
                                        <div class="col-md-6">  
        
                                                @foreach($fields as $fieldCol)                              
                                                @if(  $fieldCol != "id"  && $fieldCol != "paramID"  && $fieldCol != "created_at"  && $fieldCol != "updated_at"  )   
        
                                                @if ( $fieldCol == "subProcessName" )
                                                <div class="row">                             
                                                        <div class="col-md-12">
                                                                <select id="subPro"  name="subPro" class="form-control" >
                                                                        <option selected value="{{$data->subProcessName}}">{{$data->subProcessName}}</option>
                                                                                @foreach ($getSubPro as $s)
                                                                                        <option value="{{ $s->subProcessName }}">{{ $s->subProcessName }}</option> 
                                                                                @endforeach
                                                                </select>   
                                                         </div>  
                                                        </div>  
                                                @elseif ( $fieldCol == "BOMType" )
                                                <div class="row">                             
                                                        <div class="col-md-12">
                                                                <select id="bom"  name="bom" class="form-control" >
                                                                        <option selected value="{{$data->BOMType}}">{{$data->BOMType}}</option>
                                                                                @foreach ($getbom as $s)
                                                                                        <option value="{{ $s->bomType }}">{{ $s->bomType }}</option> 
                                                                                @endforeach
                                                                </select>   
                                                         </div>  
                                                        </div>  
                                                 @elseif ( $fieldCol == "cellType" )
                                                 <div class="row">                             
                                                                <div class="col-md-12">
                                                                        <select id="cellType"  name="cellType" class="form-control" >
                                                                                <option selected value="{{$data->cellType}}">{{$data->cellType}}</option>
                                                                                <option value="All">All</option> 
                                                                                <option value="72">72 cell</option> 
                                                                                <option value="60">60 cell</option> 
                                                                        </select>   
                                                                 </div>  
                                                                </div>  
                                                 @elseif ( $fieldCol == "sealantType" )
                                                <div class="row">                             
                                                                               <div class="col-md-12">
                                                                                       <select id="sealantType"  name="sealantType" class="form-control" >
                                                                                               <option selected value="{{$data->sealantType}}">{{$data->sealantType}}</option>
                                                                                               <option value="NA">NA</option> 
                                                                                               <option value="Sausage">Sausage</option> 
                                                                                               <option value="Pail">Pail</option> 
                                                                                       </select>   
                                                                                </div>  
                                                                               </div>  
                                                 @elseif ( $fieldCol == "JBOXType" )
                                                <div class="row">                             
                                                                               <div class="col-md-12">
                                                                                       <select id="jboxType"  name="jboxType" class="form-control" >
                                                                                               <option selected value="{{$data->JBOXType}}">{{$data->JBOXType}}</option>
                                                                                               <option  value="NA">NA</option> 
                                                                                               <option  value="Sunter">Sunter</option> 
                                                                                               <option  value="PVBar">PVBar</option> 
                                                                                       </select>   
                                                                                </div>  
                                                                               </div>  
                                                 @elseif ( $fieldCol == "BBno" )
                                                <div class="row">                             
                                                                                                              <div class="col-md-12">
                                                                                                                      <select id="bbno"  name="bbno" class="form-control" >
                                                                                                                              <option selected value="{{$data->BBno}}">{{$data->BBno}}</option>
                                                                                                                              <option value="NA">NA</option> 
                                                                                                                              <option value="5bb">5bb</option> 
                                                                                                                              <option value="4bb">4bb</option> 
                                                                                                                      </select>   
                                                                                                               </div>  
                                                                                                              </div>  
                                                 @elseif ( $fieldCol == "frameType" )
                                                <div class="row">                             
                                                                               <div class="col-md-12">
                                                                                       <select id="frameType"  name="frameType" class="form-control" >
                                                                                               <option selected value="{{$data->frameType}}">{{$data->frameType}}</option>
                                                                                               <option  value="CY">CY</option> 
                                                                                               <option  value="Gintech">Gintech</option> 
                                                                                               
                                                                                       </select>   
                                                                                </div>  
                                                                               </div>  
                                                @else
                                                <div class="row">                             
                                                <div class="col-md-12"> {{ Form::text('txt[]',$data->$fieldCol,['class'=>'form-control'] )}} </div>  
                                                </div>   
                                                @endif
                                                @endif
                                                @endforeach 
        
                                         
                                        </div>
                                        <div class="col-md-1">   </div>
                               
                                 </div>  
                                                   <br>
                                                        <div class="modal-footer">
                                                                {{Form::hidden('_method','PUT')}}
                                                        {{Form::submit('Save',['class'=>'btn btn-primary'])}}
                                                        {!! Form::close() !!}
                                
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                            </div>
                                
                                            
                                            </div>
                                         
                                            
                                            
                                            </div>
                                          </div>
                        </td>
                        @endif
                  
                             @endforeach 




                             @foreach($fields as $fieldCol) 
                             @if(  $fieldCol == "id"  )
                             <td>  
                                
                                            {!! Form::open(['action' => [ $controllerDel, $data->$fieldCol ], 'method' => 'POST','class'=>'delete']) !!}
                                            {{Form::hidden('_method','DELETE')}}
                                                  {{Form::submit('Delete',['class'=>'btn btn-danger btn-sm '])}}
                                                  {!! Form::close() !!}
                     </td>
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

                @push('jscript')
                <script>
                        $(".delete").on("submit", function(){
                            return confirm("Are you sure you want to delete?");
                        });
                        $(".update").on("submit", function(){
                            return confirm("Are you sure you want to save changes?");
                        });
                    </script>
                    @endpush
