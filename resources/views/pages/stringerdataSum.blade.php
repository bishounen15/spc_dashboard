@extends('layouts.app')
  
@section('content')
    <div class="container">
    <div class="col-md-12">
 
        <div class="row">
            {{-- <div class="col-md-12"> --}}
                <div class="card">
            <div class="card-header">STRINGER DATA MONITORING</div> 
            {{-- <div class="card"> --}}
        <div class="card-body">        
       
        <div class="card">
                <div class="card-header">STRINGER </div> 
                {{-- <div class="card"> --}}
                <div class="card-body">
                <a href="/Summary" class="btn btn-secondary">Go Back</a>
              
                <a href="/stringer/create" class="btn btn-primary">Input Data</a>
                <a href="/stringer_view" class="btn btn-primary">View Data</a>
            
    <div class="card-header">Table of computation for Stringer Front and Back </div> 
    <br/>
    <div class="row"> 
        <div class="col-md-5">
            <p align="left">30 days Date from </p>
        </div>
        <div class="col-md-7">
        
        </div>
    </div>
    <div class="row"> 
        <div class="col-md-5">
            <p align="left">Product Built</p>
        </div>
        <div class="col-md-7">
            {{ $dateRange }}
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
<table class="table table-hover table table-bordered" style="font-size:10px;">
    <thead>
        <tr>
            <th scope="col" colspan="2"></th>
            <th colspan="2" bgcolor="#ccffcc">STRINGER 1A</th>
            <th colspan="2" bgcolor="#ccffcc">STRINGER 1B</th>
            <th colspan="2" bgcolor="#ffffcc">STRINGER 2A</th>
            <th colspan="2" bgcolor="#ffffcc">STRINGER 2B</th>
            <th colspan="2" bgcolor="#ffe6e6">STRINGER 3A</th>
            <th colspan="2"bgcolor="#ffe6e6">STRINGER 3B</th>
    </tr>
    <tr>
 
    <th scope="col">#</th>
    <th scope="col">Indicators</th>
    <th scope="col" bgcolor="#ccffcc">FRONT</th>
    <th scope="col" bgcolor="#ccffcc">BACK</th>
    <th scope="col" bgcolor="#ccffcc">FRONT</th>
    <th scope="col" bgcolor="#ccffcc">BACK</th>
    <th scope="col" bgcolor="#ffffcc">FRONT</th>
    <th scope="col" bgcolor="#ffffcc">BACK</th>
    <th scope="col" bgcolor="#ffffcc">FRONT</th>
    <th scope="col" bgcolor="#ffffcc">BACK</th>
    <th scope="col" bgcolor="#ffe6e6">FRONT</th>
    <th scope="col" bgcolor="#ffe6e6">BACK</th>
    <th scope="col" bgcolor="#ffe6e6">FRONT</th>
    <th scope="col" bgcolor="#ffe6e6">BACK</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th scope="row">1</th>
    <td><b>Ave (Ind)</b></td>
    <td>{{$aveIndS1AF}}</td>
    <td>{{$aveIndS1AB}}</td>
    <td>{{$aveIndS1BF}}</td>
    <td>{{$aveIndS1BB}}</td>
    <td>{{$aveIndS2AF}}</td>
    <td>{{$aveIndS2AB}}</td>
    <td>{{$aveIndS2BF}}</td>
    <td>{{$aveIndS2BB}}</td>
    <td>{{$aveIndS3AF}}</td>
    <td>{{$aveIndS3AB}}</td>
    <td>{{$aveIndS3BF}}</td>
    <td>{{$aveIndS3BB}}</td>
    </tr>
    <tr>
    <th scope="row">2</th>
    <td><b>Stdev (Ind)</b></td>
    <td>{{$stdIndS1AF}}</td>
    <td>{{$stdIndS1AB}}</td>
    <td>{{$stdIndS1BF}}</td>
    <td>{{$stdIndS1BB}}</td>
    <td>{{$stdIndS2AF}}</td>
    <td>{{$stdIndS2AB}}</td>
    <td>{{$stdIndS2BF}}</td>
    <td>{{$stdIndS2BB}}</td>
    <td>{{$stdIndS3AF}}</td>
    <td>{{$stdIndS3AB}}</td>
    <td>{{$stdIndS3BF}}</td>
    <td>{{$stdIndS3BB}}</td>
    <tr>
        <th scope="row">3</th>
        <td><b>N</b></td>
        <td>30</td>
        
        </tr>
    
    </tr>
    <tr>
    <th scope="row">4</th>
    <td><b>Ave (Ave)</b></td>
    <td>{{$aveOfAveS1AF}}</td>
    <td>{{$aveOfAveS1AB}}</td>
    <td>{{$aveOfAveS1BF}}</td>
    <td>{{$aveOfAveS1BB}}</td>
    <td>{{$aveOfAveS2AF}}</td>
    <td>{{$aveOfAveS2AB}}</td>
    <td>{{$aveOfAveS2BF}}</td>
    <td>{{$aveOfAveS2BB}}</td>
    <td>{{$aveOfAveS3AF}}</td>
    <td>{{$aveOfAveS3AB}}</td>
    <td>{{$aveOfAveS3BF}}</td>
    <td>{{$aveOfAveS3BB}}</td>
    </tr>
    <tr>
    <th scope="row">5</th>
    <td><b>Stdev (Ave)</b></td>
    <td>{{$stdOfStdS1AF}}</td>
    <td>{{$stdOfStdS1AB}}</td>
    <td>{{$stdOfStdS1BF}}</td>
    <td>{{$stdOfStdS1BB}}</td>
    <td>{{$stdOfStdS2AF}}</td>
    <td>{{$stdOfStdS2AB}}</td>
    <td>{{$stdOfStdS2BF}}</td>
    <td>{{$stdOfStdS2BB}}</td>
    <td>{{$stdOfStdS3AF}}</td>
    <td>{{$stdOfStdS3AB}}</td>
    <td>{{$stdOfStdS3BF}}</td>
    <td>{{$stdOfStdS3BB}}</td>
    
    </tr>
    <tr>
    <th scope="row">6</th>
    <td><b>Median</b></td>
    <td>{{$medianS1AF}}</td>
    <td>{{$medianS1AB}}</td>
    <td>{{$medianS1BF}}</td>
    <td>{{$medianS1BB}}</td>
    <td>{{$medianS2AF}}</td>
    <td>{{$medianS2AB}}</td>
    <td>{{$medianS2BF}}</td>
    <td>{{$medianS2BB}}</td>
    <td>{{$medianS3AF}}</td>
    <td>{{$medianS3AB}}</td>
    <td>{{$medianS3BF}}</td>
    <td>{{$medianS3BB}}</td>
    </tr>
    <tr>
    <th scope="row">7</th>
    <td><b>Percentile (0.00135)</b></td>
    <td>{{$perc1S1AF}}</td>
    <td>{{$perc1S1AB}}</td>
    <td>{{$perc1S1BF}}</td>
    <td>{{$perc1S1BB}}</td>
    <td>{{$perc1S2AF}}</td>
    <td>{{$perc1S2AB}}</td>
    <td>{{$perc1S2BF}}</td>
    <td>{{$perc1S2BB}}</td>
    <td>{{$perc1S3AF}}</td>
    <td>{{$perc1S3AB}}</td>
    <td>{{$perc1S3BF}}</td>
    <td>{{$perc1S3BB}}</td>
    
    </tr>
    <tr>
    <th scope="row">8</th>
    <td><b>Percentile (0.99865)</b></td>
    <td>{{$perc2S1AF}}</td>
    <td>{{$perc2S1AB}}</td>
    <td>{{$perc2S1BF}}</td>
    <td>{{$perc2S1BB}}</td>
    <td>{{$perc2S2AF}}</td>
    <td>{{$perc2S2AB}}</td>
    <td>{{$perc2S2BF}}</td>
    <td>{{$perc2S2BB}}</td>
    <td>{{$perc2S3AF}}</td>
    <td>{{$perc2S3AB}}</td>
    <td>{{$perc2S3BF}}</td>
    <td>{{$perc2S3BB}}</td>
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
    <td>{{ $zS1AF }}</td>
    <td>{{ $zS1AB }}</td>
    <td>{{ $zS1BF }}</td>
    <td>{{ $zS1BB }}</td>
    <td>{{ $zS2AF }}</td>
    <td>{{ $zS2AB }}</td>
    <td>{{ $zS2BF }}</td>
    <td>{{ $zS2BB }}</td>
    <td>{{ $zS3AF }}</td>
    <td>{{ $zS3AB }}</td>
    <td>{{ $zS3BF }}</td>
    <td>{{ $zS3BB }}</td>
</tr>
    <tr>
    <th scope="row">13</th>

    </tr>
    <tr>
    <th scope="row">14</th>
    <td><b>CpL</b></td>
    <td>{{ $CpLS1AF }}</td>
    <td>{{ $CpLS1AB }}</td>
    <td>{{ $CpLS1BF }}</td>
    <td>{{ $CpLS1BB }}</td>
    <td>{{ $CpLS2AF }}</td>
    <td>{{ $CpLS2AB }}</td>
    <td>{{ $CpLS2BF }}</td>
    <td>{{ $CpLS2BB }}</td>
    <td>{{ $CpLS3AF }}</td>
    <td>{{ $CpLS3AB }}</td>
    <td>{{ $CpLS3BF }}</td>
    <td>{{ $CpLS3BB }}</td>
    </tr>
    <tr>
    <th scope="row">15</th>
    <td><b>Cpk</b></td>
    <td>{{ $CpkS1AF }}</td>
    <td>{{ $CpkS1AB }}</td>
    <td>{{ $CpkS1BF }}</td>
    <td>{{ $CpkS1BB }}</td>
    <td>{{ $CpkS2AF }}</td>
    <td>{{ $CpkS2AB }}</td>
    <td>{{ $CpkS2BF }}</td>
    <td>{{ $CpkS2BB }}</td>
    <td>{{ $CpkS3AF }}</td>
    <td>{{ $CpkS3AB }}</td>
    <td>{{ $CpkS3BF }}</td>
    <td>{{ $CpkS3BB }}</td>
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
    <td>{{ $CpnS1AF }}</td>
    <td>{{ $CpnS1AB }}</td>
    <td>{{ $CpnS1BF }}</td>
    <td>{{ $CpnS1BB }}</td>
    <td>{{ $CpnS2AF }}</td>
    <td>{{ $CpnS2AB }}</td>
    <td>{{ $CpnS2BF }}</td>
    <td>{{ $CpnS2BB }}</td>
    <td>{{ $CpnS3AF }}</td>
    <td>{{ $CpnS3AB }}</td>
    <td>{{ $CpnS3BF }}</td>
    <td>{{ $CpnS3BB }}</td>
    </tr>
    
    <tr>
    <th scope="row">20</th>
    <td><b>CpnU</b></td>
    <td>{{ $CpnUS1AF }}</td>
    <td>{{ $CpnUS1AB }}</td>
    <td>{{ $CpnUS1BF }}</td>
    <td>{{ $CpnUS1BB }}</td>
    <td>{{ $CpnUS2AF }}</td>
    <td>{{ $CpnUS2AB }}</td>
    <td>{{ $CpnUS2BF }}</td>
    <td>{{ $CpnUS2BB }}</td>
    <td>{{ $CpnUS3AF }}</td>
    <td>{{ $CpnUS3AB }}</td>
    <td>{{ $CpnUS3BF }}</td>
    <td>{{ $CpnUS3BB }}</td>

    </tr>
    
    <tr>
    <th scope="row">21</th>
    <td><b>CpnL</b></td>
 <td>{{ $CpnLS1AF }}</td>
 <td>{{ $CpnLS1AB }}</td>
 <td>{{ $CpnLS1BF }}</td>
 <td>{{ $CpnLS1BB }}</td>
 <td>{{ $CpnLS2AF }}</td>
 <td>{{ $CpnLS2AB }}</td>
 <td>{{ $CpnLS2BF }}</td>
 <td>{{ $CpnLS2BB }}</td>
 <td>{{ $CpnLS3AF }}</td>
 <td>{{ $CpnLS3AB }}</td>
 <td>{{ $CpnLS3BF }}</td>
 <td>{{ $CpnLS3BB }}</td>
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
