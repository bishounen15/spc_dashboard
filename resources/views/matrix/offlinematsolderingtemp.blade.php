@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            {{-- <div class="col-md-12"> --}}
                <div class="card">
            <div class="card-header">BtoB Soldering Temp Monitoring</div> 
            {{-- <div class="card"> --}}
        <div class="card-body">        
       
        <div class="card">
                <div class="card-header">BtoB Soldering Temp</div> 
                {{-- <div class="card"> --}}
                <div class="card-body">
                <a href="/Summary" class="btn btn-secondary">Go Back</a>
              
                <a href="/offlinematsolder/create" class="btn btn-primary">Input Data</a>
                <a href="/offmatsoldering" class="btn btn-primary">View Data</a>
            
    <div class="card-header">Table of computation for Busbar to Busbar Soldering Temp Monitoring </div> 
    <br/>
    <div class="row"> 
        <div class="col-md-5">
            <p align="left">30 days Date from </p>
        </div>
        <div class="col-md-7">
          <bold>  {{ $dateRange }} </bold>
        </div>
    </div>
    <div class="row"> 
        <div class="col-md-5">
            <p align="left">Product Built</p>
        </div>
        <div class="col-md-7">
            {{ $productBuilt }}
        </div>
    </div>
    <div class="row"> 
        <div class="col-md-5">
<input type="checkbox" id="checkProd" class="form-control"   onclick="toggle1('.checkProd', this)" >
        </div>
        <div class="col-md-7">
                {{Form::label('prod','Other Product Built for 30 days'),['class'=>'form-control']}} 
        </div>
</div>
    <div id="prodBuiltForm"> 
            {!! Form::open(['action' => 'FrameController@store','method' => 'POST']) !!}
            <div class="row"> 
        <div class="col-md-5">
         
        </div>
        <div class="col-md-7">
            {{Form::select('prodBuilt', array('Gintech' => 'Gintech', 'Own-BOM' => 'Own-BOM'),'Gintech',['class' => 'form-control process'])}} <small class="form-text text-danger">{{ $errors->first('location') }}</small>   
            &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; 
    {!! Form::close() !!}
        </div>
            </div>


</div>
    <div class="row"> 
            <div class="col-md-5">
    <input type="checkbox" id="checkDate" class="form-control"   onclick="toggle('.checkDate', this)" >
            </div>
            <div class="col-md-7">
                    {{Form::label('dateRange','Date Range'),['class'=>'form-control']}} 
            </div>

        </div>

<div id="dateRangeForm">
        {!! Form::open(['action' => 'FrameController@store','method' => 'POST']) !!}
<div class="row"> 
    <div class="col-md-5">
            {{Form::label('','From'),['class'=>'form-control']}}
              </div> 
    <div class="col-md-7">
  {{ Form::date('fromDate', '00-00-00 00:00:00',['class'=>'form-control form-control-sm','id'=>'fromDate']) }}
    </div>
</div>
<div class="row"> 
    <div class="col-md-5">
            {{Form::label('','To'),['class'=>'form-control']}}
              </div> 
    <div class="col-md-7">
  {{ Form::date('toDate', '00-00-00 00:00:00',['class'=>'form-control form-control-sm','id'=>'toDate']) }}
    </div>
</div>
&emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp; 
                {!! Form::close() !!}
</div>
<table class="table table-hover table table-bordered">
    <thead>
   
    <tr>
    <th scope="col">#</th>
    <th scope="col">Indicators</th>
    <th scope="col">Values</th>
    
    </tr>
    </thead>
    <tbody>
    <tr>
    <th scope="row">1</th>
    <td><b>Ave (Ind)</b></td>
    <td>{{$aveIndB1T1}}</td>
    
    </tr>
    <tr>
    <th scope="row">2</th>
    <td><b>Stdev (Ind)</b></td>
    <td>{{$stdIndB1T1}}</td>
  
    
    <tr>
        <th scope="row">3</th>
        <td><b>N</b></td>
        <td>30</td>
        
        </tr>
    
    </tr>
    <tr>
    <th scope="row">4</th>
    <td><b>Ave (Ave)</b></td>
    <td>{{$aveOfAveB1T1}}</td>
    
    </tr>
    <tr>
    <th scope="row">5</th>
    <td><b>Stdev (Ave)</b></td>
   <td>{{$stdOfStdB1T1}}</td>
  
    
    </tr>
    <tr>
    <th scope="row">6</th>
    <td><b>Median</b></td>
    <td>{{$medianB1T1}}</td>
   
    </tr>
    <tr>
    <th scope="row">7</th>
    <td><b>Percentile (0.00135)</b></td>
    <td>{{$perc1B1T1}}</td>
  
    
    
    </tr>
    <tr>
    <th scope="row">8</th>
    <td><b>Percentile (0.99865)</b></td>
    <td>{{$perc2B1T1}}</td>
   
    
    </tr>
    <tr>
    <th scope="row">9</th>
    <td><b>USL</b></td>
    <td>{{$USL}}</td>
    
    </tr>
    <tr>
    <th scope="row">10</th>
    <td><b>LSL</b></td>
    <td>{{$LSL}}</td>
    
    </tr>
    <tr>
    <th scope="row">11</th>
    <td><b>Target</b></td>
    <td>{{$target}}</td>
    
    </tr>
    <tr>
    <th scope="row">12</th>
    <td><b>Z</b></td>
    <td>{{ $zBus1Top1 }}</td>
   
</tr>
    <tr>
    <th scope="row">13</th>
    <td><b>CpU</b></td>
    <td>{{ $CpUB1T1 }}</td>
   
    </tr>
    <tr>
    <th scope="row">14</th>
    <td><b>CpL</b></td>
    <td>{{ $CpLB1T1 }}</td>
 
    
    </tr>
    <tr>
    <th scope="row">15</th>
    <td><b>Cpk</b></td>
    <td>{{ $CpkB1T1 }}</td>
    
    </tr>
    <tr>
    <th scope="row">16</th>
    <td><b>UCL</b></td>
    <td>{{ $UCL }}</td>
    
    </tr>
    <tr>
    <th scope="row">17</th>
    <td><b>LCL</b></td>
    <td>{{ $LCL }}</td>
    
    </tr>
    <tr>
    <th scope="row">18</th>
    <td><b>CL</b></td>
    <td>{{ $CL }}</td>
    
    </tr>
    
    <tr>
    <th scope="row">19</th>
    <td><b>Cpn</b></td>
    <td>{{ $CpnB1T1 }}</td>
   
    </tr>
    
    <tr>
    <th scope="row">20</th>
    <td><b>CpnU</b></td>
    <td>{{ $CpnUB1T1 }}</td>
  
    </tr>
    
    <tr>
    <th scope="row">21</th>
    <td><b>CpnL</b></td>
    <td>{{ $CpnLB1T1 }}</td>
   
    </tr>
    
    </tbody>
    </table>

    </div>
</div>
</div>
<div>
</div>
@endsection
@push('jscript')
<script>
     $(document).ready(function () {
       $('#dateRangeForm').hide();
       $('#prodBuiltForm').hide();
     });
    
     function toggle(className, obj) {
   if ( obj.checked ) $('#dateRangeForm').show();
   else $('#dateRangeForm').hide();
}
    function toggle1(className, obj) {
   if ( obj.checked ) $('#prodBuiltForm').show();
   else $('#prodBuiltForm').hide();
}
  
   

     
   

    </script>
@endpush
