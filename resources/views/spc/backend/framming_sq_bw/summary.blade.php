@extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">Frame Squareness and Bowing Qual Monitoring</div> 
            <div class="card-body">
                
<a href="/SPC/entry" class="btn btn-secondary">Go Back</a>
<a href="/SPC/SqBw/records" class="btn btn-success">View Records</a>
<a href="/SPC/Framming/create" class="btn btn-success">Add Record</a>           

<div class="container">
<br>
<div class="col-md-12">
<div class="row">
{{-- <div class="col-md-12"> --}}
<div class="card">
<div class="card-header">Table of computation for Frame Squareness and Bowing Qual Monitoring </div> 
{{-- <div class="card"> --}}
<div class="card-body">

    <table class="table table-hover table table-bordered">
        <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Indicators</th>
        <th scope="col">Long Side Value</th>
        <th scope="col">Short Side Value</th>
        <th scope="col">Squareness Value</th>

        </tr>
        </thead>
        <tbody>
        <tr>
        <th scope="row">1</th>
        <td><b>Ave (Ind)</b></td>
        <td> {{$aveLF}}</td>
        <td> {{$aveSF}}</td>
        <td> {{ $aveSq}}</td>
        
        </tr>
        <tr>
        <th scope="row">2</th>
        <td><b>Stdev (Ind)</b></td>
        <td> {{$sqLF}}</td>
        <td> {{$sqSF}}</td>
        <td> {{ $sqSq}}</td>
        
        <tr>
            <th scope="row">3</th>
            <td><b>N</b></td>
            <td>30</td>
            <td>30</td>
            <td>30</td>
            </tr>
        
        </tr>
        <tr>
        <th scope="row">4</th>
        <td><b>Ave (Ave)</b></td>
        <td> {{ $LFAveOfAve }}</td>
        <td> {{ $SFAveOfAve }}</td>
        <td> {{ $DFAveOfAve }}</td>
        
        </tr>
        <tr>
        <th scope="row">5</th>
        <td><b>Stdev (Ave)</b></td>
        <td> {{ $LFStdOfStd }}</td>
        <td> {{ $SFStdOfStd }}</td>
        <td> {{ $DFStdOfStd }}</td>
        
        </tr>
        <tr>
        <th scope="row">6</th>
        <td><b>Median</b></td>
        <td> {{$medianLDiff}} </td>
        <td> {{$medianSDiff}}</td>
        <td> {{$medianDDiff}}</td>
        </tr>
        <tr>
        <th scope="row">7</th>
        <td><b>Percentile (0.00135)</b></td>
        <td> {{ $listLF1 }} </td>
        <td> {{ $listSF1 }} </td>
        <td> {{ $listDF1 }}  </td>
        
        </tr>
        <tr>
        <th scope="row">8</th>
        <td><b>Percentile (0.99865)</b></td>
        <td> {{ $listLF2 }} </td>
        <td> {{ $listSF2 }} </td>
        <td> {{ $listDF2 }}  </td>
        
        </tr>
        <tr>
        <th scope="row">9</th>
        <td><b>USL</b></td>
        <td>{{ $USL_L }}</td>
        <td>{{ $USL_S }}</td>
        <td>{{ $USL_D }}</td>
        
        </tr>
        <tr>
        <th scope="row">10</th>
        <td><b>LSL</b></td>
        <td>{{ $LSL_L }}</td>
        <td>{{ $LSL_S }}</td>
        <td>{{ $LSL_D }}</td>
        
        
        </tr>
        <tr>
        <th scope="row">11</th>
        <td><b>Target</b></td>
        <td>{{ $target_L }}</td>
        <td>{{ $target_S }}</td>
        <td>{{ $target_D }}</td>
        
        
        </tr>
        <tr>
        <th scope="row">12</th>
        <td><b>Z</b></td>
        <td>{{ $Z_L }}</td>
        <td>{{ $Z_S }}</td>
        <td>{{ $Z_D }}</td>
        
        </tr>
        <tr>
        <th scope="row">13</th>
        <td><b>CpU</b></td>
        <td>{{ $CpU_L }}</td>
        <td>{{ $CpU_S }}</td>
        <td>{{ $CpU_D }}</td>
        </tr>
        <tr>
        <th scope="row">14</th>
        <td><b>CpL</b></td>
        <td>{{ $CpL_L }}</td>
        <td>{{ $CpL_S }}</td>
        <td>{{ $CpL_D }}</td>
        
        </tr>
        <tr>
        <th scope="row">15</th>
        <td><b>Cpk</b></td>
        <td>{{ $Cpk_L }}</td>
        <td>{{ $Cpk_S }}</td>
        <td>{{ $Cpk_D }}</td>
        
        </tr>
        <tr>
        <th scope="row">16</th>
        <td><b>UCL</b></td>
        <td>{{$UCL_L}}</td>
        <td>{{$UCL_S}}</td>
        <td>{{$UCL_D}}</td>
        </tr>
        <tr>
        <th scope="row">17</th>
        <td><b>LCL</b></td>
        <td>{{$LCL_L}}</td>
        <td>{{$LCL_S}}</td>
        <td>{{$LCL_D}}</td>
        
        </tr>
        <tr>
        <th scope="row">18</th>
        <td><b>CL</b></td>
        <td>{{$CL_L}}</td>
        <td>{{$CL_S}}</td>
        <td>{{$CL_D}}</td>
        
        </tr>
        
        <tr>
        <th scope="row">19</th>
        <td><b>Cpn</b></td>
        <td>{{$Cpn_L}}</td>
        <td>{{$Cpn_S}}</td>
        <td>{{$Cpn_D}}</td>
        
        </tr>
        
        <tr>
        <th scope="row">20</th>
        <td><b>CpnU</b></td>
        <td>{{$CpnU_L}}</td>
        <td>{{$CpnU_S}}</td>
        <td>{{$CpnU_D}}</td>
        </tr>
        
        <tr>
        <th scope="row">21</th>
        <td><b>CpnL</b></td>
        <td>{{$CpnL_L}}</td>
        <td>{{$CpnL_S}}</td>
        <td>{{$CpnL_D}}</td>
        </tr>
        
        </tbody>
        </table>

            </div>
            </div>
            </div>
            </div>


 
    </div>      

 @endsection


 