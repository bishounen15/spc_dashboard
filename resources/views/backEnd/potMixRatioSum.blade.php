@extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">Potting Mixing Ratio Qual Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/mixRatio" class="btn btn-success">View Records</a>
<a href="/MixRatio/create" class="btn btn-success">Add Record</a>           

<div class="container">
<br>
<div class="row">
<div class="col-md-6">
<div class="row">

<div class="card">
<div class="card-header">Table of computation for Potting Mixing Ratio Qual Monitoring </div> 

<div class="card-body">

    <table class="table table-hover table table-bordered">
        <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Indicators</th>
        <th scope="col">Value for 30 days</th>
        <th scope="col">Value for 7 days</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <th scope="row">1</th>
        <td><b>Ave (Ind)</b></td>
        <td>{{$wtAve30}} </td>
        <td>{{$wtAve7}} </td>
       
        </tr>
        <tr>
        <th scope="row">2</th>
        <td><b>Stdev (Ind)</b></td>
        <td>{{$wtStd30}} </td>
        <td>{{$wtStd7}} </td>
        
        <tr>
            <th scope="row">3</th>
            <td><b>N</b></td>
            <td>30</td>
            <td>7</td>
            
            </tr>
        
        </tr>
        <tr>
        <th scope="row">4</th>
        <td><b>Ave (Ave)</b></td>
        <td>{{ $wtAveOfAve }} </td>
        <td>{{ "n/a" }} </td>
        </tr>
        <tr>
        <th scope="row">5</th>
        <td><b>Stdev (Ave)</b></td>
        <td>{{ $wtStdOfStd }} </td>
        <td>{{ "n/a" }} </td>
        
        </tr>
        <tr>
        <th scope="row">6</th>
        <td><b>Median</b></td>
        <td> {{ $medianAve30}} </td>
        <td> {{ $medianAve7}}</td>
        </tr>
        <tr>
        <th scope="row">7</th>
        <td><b>Percentile (0.00135)</b></td>
        <td> {{ $percentile30}}</td>
        <td> {{ $percentile7}}</td>
        
        </tr>
        <tr>
        <th scope="row">8</th>
        <td><b>Percentile (0.99865)</b></td>
        <td> {{ $percentile30_1}}</td>
        <td> {{ $percentile7_1}}</td>
        
        
        </tr>
        <tr>
        <th scope="row">9</th>
        <td><b>USL</b></td>
        <td>{{$USL}}</td>
        <td>{{$USL}}</td>
        </tr>
        <tr>
        <th scope="row">10</th>
        <td><b>LSL</b></td>
        <td>{{$LSL}}</td>
        <td>{{$LSL}}</td>
        </tr>
        <tr>
        <th scope="row">11</th>
        <td><b>Target</b></td>
        <td>{{$target}}</td>
        <td>{{$target}}</td>
        
        </tr>
        <tr>
        <th scope="row">12</th>
        <td><b>Z</b></td>
        <td> {{ $zValue_30}}</td>
        <td> {{ $zValue_7 }}</td>
        </tr>
        <tr>
        <th scope="row">13</th>
        <td><b>CpU</b></td>
        <td>{{ $CpU_30}}</td>
        <td>{{ $CpU_7}}</td>
        </tr>
        <tr>
        <th scope="row">14</th>
        <td><b>CpL</b></td>
        <td>{{ $CpL_30}}</td>
        <td>{{ $CpL_7 }}</td>
        </tr>
        <tr>
        <th scope="row">15</th>
        <td><b>Cpk</b></td>
        <td>{{ $Cpk_30}}</td>
        <td>{{ $Cpk_7 }}</td>
        
        </tr>
        <tr>
        <th scope="row">16</th>
        <td><b>UCL</b></td>
        <td>{{ $UCL }}</td>
        <td>{{ $UCL }}</td>
        </tr>
        <tr>
        <th scope="row">17</th>
        <td><b>LCL</b></td>
        <td>{{ $LCL }}</td>
        <td>{{ $LCL }}</td>
        </tr>
        <tr>
        <th scope="row">18</th>
        <td><b>CL</b></td>
        <td>{{ $CL }}</td>
        <td>{{ $CL }}</td>
        </tr>
        
        <tr>
        <th scope="row">19</th>
        <td><b>Cpn</b></td>
        <td>{{ $Cpn_30 }}</td>
        <td>{{ $Cpn_7 }}</td>
        </tr>
        
        <tr>
        <th scope="row">20</th>
        <td><b>CpnU</b></td>
        <td>{{ $CpnU_30 }}</td>
        <td>{{ $CpnU_7 }}</td>
        </tr>
        
        <tr>
        <th scope="row">21</th>
        <td><b>CpnL</b></td>
        <td>{{ $CpnL_30 }}</td>
        <td>{{ $CpnL_7 }}</td>
        </tr>
        
        </tbody>
        </table>

            </div>
            </div>
            </div>

            </div>


</div>
    </div>      

 @endsection


 