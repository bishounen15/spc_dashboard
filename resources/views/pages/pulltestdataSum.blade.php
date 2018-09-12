@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            {{-- <div class="col-md-12"> --}}
                <div class="card">
            <div class="card-header">PULLTEST MONITORING</div> 
            {{-- <div class="card"> --}}
        <div class="card-body">        
       
        <div class="card">
                <div class="card-header">PULLTEST </div> 
                {{-- <div class="card"> --}}
                <div class="card-body">
                <a href="/Summary" class="btn btn-secondary">Go Back</a>
              
                <a href="/pulltestdata/create" class="btn btn-primary">Input Data</a>
                <a href="/pulltest_view" class="btn btn-primary">View Data</a>
            
    <div class="card-header">Table of computation for Pulltest EVA-Glass and EVA-Backsheet </div> 
    <br/>
    <div class="row"> 
        <div class="col-md-5">
            <p align="left">30 days Date from </p>
        </div>
        <div class="col-md-7">
         {{ $dateRange }}
        </div>
    </div>
    <div class="row"> 
        <div class="col-md-5">
            <p align="left">Product Built</p>
        </div>
        <div class="col-md-7">
           
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
            <th scope="col" colspan="2"></th>
            <th scope="col" colspan="2">LAMINATOR 1</th>
            <th scope="col" colspan="2">LAMINATOR 2</th>
            <th scope="col" colspan="2">LAMINATOR 3</th>
    </tr>
    <tr>
    <th scope="col">#</th>
    <th scope="col">Indicators</th>
    <th scope="col">EVA-Glass Values</th>
    <th scope="col">EVA-Backsheet Values</th>
    <th scope="col">EVA-Glass Values</th>
    <th scope="col">EVA-Backsheet Values</th>
    <th scope="col">EVA-Glass Values</th>
    <th scope="col">EVA-Backsheet Values</th>

    </tr>
    </thead>
    <tbody>
    <tr>
    <th scope="row">1</th>
    <td><b>Ave (Ind)</b></td>
    <td>{{$aveIndLXM}}</td>
    <td>{{$aveIndRG}}</td>
    <td>{{$L2aveIndLXM}}</td>
    <td>{{$L2aveIndRG}}</td>
    <td>{{$L3aveIndLXM}}</td>
    <td>{{$L3aveIndRG}}</td>
    </tr>
    <tr>
    <th scope="row">2</th>
    <td><b>Stdev (Ind)</b></td>
    <td>{{$stdIndLXM}}</td>
    <td>{{$stdIndRG}}</td>
    <td>{{$L2stdIndLXM}}</td>
    <td>{{$L2stdIndRG}}</td>
    <td>{{$L3stdIndLXM}}</td>
    <td>{{$L3stdIndRG}}</td>
    <tr>
        <th scope="row">3</th>
        <td><b>N</b></td>
        <td>30</td>
        
        </tr>
    
    </tr>
    <tr>
    <th scope="row">4</th>
    <td><b>Ave (Ave)</b></td>
    <td>{{$aveOfAveLXM}}</td>
    <td>{{$aveOfAveRG}}</td>
    <td>{{$L2aveOfAveLXM}}</td>
    <td>{{$L2aveOfAveRG}}</td>
    <td>{{$L3aveOfAveLXM}}</td>
    <td>{{$L3aveOfAveRG}}</td>
    </tr>
    <tr>
    <th scope="row">5</th>
    <td><b>Stdev (Ave)</b></td>
   <td>{{$stdOfStdLXM}}</td>
   <td>{{$stdOfStdRG}}</td>
   <td>{{$L2stdOfStdLXM}}</td>
   <td>{{$L2stdOfStdRG}}</td>
   <td>{{$L3stdOfStdLXM}}</td>
   <td>{{$L3stdOfStdRG}}</td>
    
    
    </tr>
    <tr>
    <th scope="row">6</th>
    <td><b>Median</b></td>
    <td>{{$medianLXM}}</td>
    <td>{{$medianRG}}</td>
    <td>{{$L2medianLXM}}</td>
    <td>{{$L2medianRG}}</td>
    <td>{{$L3medianLXM}}</td>
    <td>{{$L3medianRG}}</td>
    </tr>
    <tr>
    <th scope="row">7</th>
    <td><b>Percentile (0.00135)</b></td>
    <td>{{$perc1LXM}}</td>
    <td>{{$perc1RG}}</td>
    <td>{{$L2perc1LXM}}</td>
    <td>{{$L2perc1RG}}</td>
    <td>{{$L3perc1LXM}}</td>
    <td>{{$L3perc1RG}}</td>
    
    
    </tr>
    <tr>
    <th scope="row">8</th>
    <td><b>Percentile (0.99865)</b></td>
    <td>{{$perc2LXM}}</td>
    <td>{{$perc2RG}}</td>
    <td>{{$L2perc2LXM}}</td>
    <td>{{$L2perc2RG}}</td>
    <td>{{$L3perc2LXM}}</td>
    <td>{{$L3perc2RG}}</td>
    
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
    <td>{{ $zLXM }}</td>
    <td>{{ $zRelGel }}</td>
    <td>{{ $L2zLXM }}</td>
    <td>{{ $L2zRelGel }}</td>
    <td>{{ $L3zLXM }}</td>
    <td>{{ $L3zRelGel }}</td>
</tr>
    <tr>
    <th scope="row">13</th>
    <td><b>CpU</b></td>
    <td>{{ $CpULXM }}</td>
    <td>{{ $CpURG }}</td>
    <td>{{ $L2CpULXM }}</td>
    <td>{{ $L2CpURG }}</td>
    <td>{{ $L3CpULXM }}</td>
    <td>{{ $L3CpURG }}</td>
    </tr>
    <tr>
    <th scope="row">14</th>
    <td><b>CpL</b></td>
    <td>{{ $CpLLXM }}</td>
    <td>{{ $CpLRG }}</td>
    <td>{{ $L2CpLLXM }}</td>
    <td>{{ $L2CpLRG }}</td>
    <td>{{ $L3CpLLXM }}</td>
    <td>{{ $L3CpLRG }}</td>
    </tr>
    <tr>
    <th scope="row">15</th>
    <td><b>Cpk</b></td>
    <td>{{ $CpkLXM }}</td>
    <td>{{ $CpkRG }}</td>
    <td>{{ $L2CpkLXM }}</td>
    <td>{{ $L2CpkRG }}</td>
    <td>{{ $L3CpkLXM }}</td>
    <td>{{ $L3CpkRG }}</td>
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
    <td>{{ $CpnLXM }}</td>
    <td>{{ $CpnRG }}</td>
    <td>{{ $L2CpnLXM }}</td>
    <td>{{ $L2CpnRG }}</td>
    <td>{{ $L3CpnLXM }}</td>
    <td>{{ $L3CpnRG }}</td>
    </tr>
    
    <tr>
    <th scope="row">20</th>
    <td><b>CpnU</b></td>
    <td>{{ $CpnULXM }}</td>
    <td>{{ $CpnURG }}</td>
    <td>{{ $L2CpnULXM }}</td>
    <td>{{ $L2CpnURG }}</td>
    <td>{{ $L3CpnULXM }}</td>
    <td>{{ $L3CpnURG }}</td>
    </tr>
    
    <tr>
    <th scope="row">21</th>
    <td><b>CpnL</b></td>
    <td>{{ $CpnLLXM }}</td>
    <td>{{ $CpnLRG }}</td>
    <td>{{ $L2CpnLLXM }}</td>
    <td>{{ $L2CpnLRG }}</td>
    <td>{{ $L3CpnLLXM }}</td>
    <td>{{ $L3CpnLRG }}</td>
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
