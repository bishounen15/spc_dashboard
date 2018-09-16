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
                   
                            <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4"> {{Form::label($cols, $cols)}} </div>  
                                    <div class="col-md-4"> {{ Form::text('txt[]','',['class'=>'form-control'] )}} </div>
                                    <div class="col-md-2"></div>
                                </div>
                             @endif
                              
                            @endforeach
                          @endif
                                <br>
                                {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                                {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <table class="table table-striped" style="font-size:10px;">
                    <tr>
                        <th>Seq</th>
                        <th>Shift</th>
                        <th>Qual Time</th>
                       
                    </tr>
        
                     
                        @if(count($getdata) > 0)
                   
                        <tr>
                         
                                @foreach($getall as $field)
                             
                               
                            @if( $field != "id" && $field != "created_at"  && $field != "updated_at"  )
                          
                            <td>{{$field}}</td>
                              
                            @endif
                           
                           
                           
                       
                    @endforeach  
                </tr>
                @else
                <p>No Records Found</p>
                @endif
                    </table>
    </div>

                   
                @endsection

            