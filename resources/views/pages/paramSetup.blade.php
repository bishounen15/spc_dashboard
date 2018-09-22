@extends('layouts.app')
@section('content')
<title>{{config('app.name', 'SOLARPH')}}</title>
<div class="container">
{{-- @guest
<div class="row">
  <div class="alert alert-danger col text-center">
    <strong>You are not logged in.</strong>
  </div>
</div>
@else --}}
<div class="row">
    <div class="col-4">

      <div class="card">
        <div class="card-header">General Set-up</div>
        <ul class="list-group list-group-flush">
          
          <li class="list-group-item"><a  href="/process/create">Process</a></li>
          <li class="list-group-item"><a  href="/bom/create">BOM Type</a></li>
          <li class="list-group-item"><a  href="/product/create">Product Type</a></li>
          <li class="list-group-item"><a  href="/subprocess/create">Critical Nodes</a></li>
          <li class="list-group-item"><a  href="/parameter/create">SPC Chart Indicators Specs</a></li>
        </ul>
    </div>
  </div>

    <div class="col-8">

        <div class="card">
            {!! Form::open(['action' => 'prodSelectionController@store', 'method' => 'POST']) !!}
          <div class="card-header">Current Product Build per Process</div>
         <br/>

         <div class="row"> 
            <div class="col-12">
            <p style="font-size:14px;"> &emsp; Choose Current Product Type per Process  &emsp;
         {!! Form::open(['action' => 'prodSelectionController@store', 'method' => 'POST']) !!} 

         <?php  $alldata = DB::select("SELECT * FROM producttype"); 
         $alldata2 = DB::select("SELECT * FROM process"); 
             
         ?>
               <select id="bom2"  name="bom2" class="form-control-sm">
                  @if(count($alldata2) > 0)
                  @foreach($alldata2 as $s)
         <option selected value="{{ $s->ProcessName }}">{{ $s->ProcessName  }}</option> 
         
                  @endforeach
                @endif
                    </select>  
         
           <select id="bom"  name="bom" class="form-control-sm">
         @if(count($alldata) > 0)
         @foreach($alldata as $s)
<option selected value="{{ $s->prodName }}">{{ $s->prodName  }}</option> 

         @endforeach
       @endif
           </select>  

         {{Form::submit('CHANGE',['class'=>'btn btn-primary btn-sm'])}}
         {!! Form::close() !!}
        </p>
        </div></div>
        <br/>
          <div class="row">
                <div class="col-12">
             <?php  $posts = DB::select("SELECT * FROM process "); 
                    $i=0;
             ?>
            
             <table class="table table-striped">
                @if(count($posts) > 0)
                
           
                    <th>SEQ </th>
                    <th>Process </th>
                    <th>Selected <br/>Product Type &emsp;&emsp;&emsp; Date Changed</th>
                 
                @foreach($posts as $fieldCol)   
            <?php $i++; ?>
                @if(   $fieldCol->ProcessName != null  )
                <tr>
                    <td>{{$i}}</td>
                    <td> {{$fieldCol->ProcessName}} <input type="hidden" name="proname" value="{{$fieldCol->ProcessName}}" /> </td>
                    <td>  <?php  $getLastProd = DB::select("SELECT * FROM prodselect WHERE ProcessName ='".$fieldCol->ProcessName."' ORDER BY created_at DESC LIMIT 1 "); 
                      
                 ?>
                   @if(count($getLastProd) > 0)
                   @foreach($getLastProd as $field)   
                            {{ $field->productName}} &emsp;&emsp;
                            {{ $field->created_at}}
                            @endforeach
                            @else
                            Not Set.
                            @endif


                 </td>
               
                </tr>

                @endif
                   
               
               
                @endforeach
           
                      
        @else
        <p>No Records Found</p>
        @endif
            </table>

        </div>
          </div>
       
          {!! Form::close() !!}
      </div>
     
    </div>
       
     
    

</div>
{{-- @endguest --}}
</div>




@endsection
