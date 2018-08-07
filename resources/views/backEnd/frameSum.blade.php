@extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">Frame Qual Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/FrameQualRecords" class="btn btn-success">View Records</a>
<a href="/Frame/create" class="btn btn-success">Add Record</a>           

<div class="container">
<br>
<div class="col-md-12">
<div class="row">
{{-- <div class="col-md-12"> --}}
<div class="card">
<div class="card-header">Table of computation for Frame Qual Monitoring </div> 
{{-- <div class="card"> --}}
<div class="card-body">

<table class="table table-hover table table-bordered">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Indicators</th>
<th scope="col">Value</th>

</tr>
</thead>
<tbody>
<tr>
<th scope="row">1</th>
<td><b>Ave (Ind)</b></td>
<td>{{$avefront}}</td>

</tr>
<tr>
<th scope="row">2</th>
<td><b>Stdev (Ind)</b></td>
<td>{{$stdfront}}</td>

<tr>
    <th scope="row">3</th>
    <td><b>N</b></td>
    <td>30</td>
    
    </tr>

</tr>
<tr>
<th scope="row">4</th>
<td><b>Ave (Ave)</b></td>
<td>{{$xbbfront}}</td>

</tr>
<tr>
<th scope="row">5</th>
<td><b>Stdev (Ave)</b></td>
<td>{{$stdavg}}</td>

</tr>
<tr>
<th scope="row">6</th>
<td><b>Median</b></td>
<td>{{$median}}</td>

</tr>
<tr>
<th scope="row">7</th>
<td><b>Percentile (0.00135)</b></td>
<td>{{$percentile}}</td>

</tr>
<tr>
<th scope="row">8</th>
<td><b>Percentile (0.99865)</b></td>
<td>{{$percentile2}}</td>


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
<td>{{$zValue}}</td>

</tr>
<tr>
<th scope="row">13</th>
<td><b>CpU</b></td>
<td>{{$CpU}}</td>

</tr>
<tr>
<th scope="row">14</th>
<td><b>CpL</b></td>
<td>{{$CpL}}</td>

</tr>
<tr>
<th scope="row">15</th>
<td><b>Cpk</b></td>
<td>{{$Cpk}}</td>

</tr>
<tr>
<th scope="row">16</th>
<td><b>UCL</b></td>
<td>{{$UCL}}</td>

</tr>
<tr>
<th scope="row">17</th>
<td><b>LCL</b></td>
<td>{{$LCL}}</td>

</tr>
<tr>
<th scope="row">18</th>
<td><b>CL</b></td>
<td>{{$CL}}</td>

</tr>

<tr>
<th scope="row">19</th>
<td><b>Cpn</b></td>
<td>{{$Cpn}}</td>
</tr>

<tr>
<th scope="row">20</th>
<td><b>CpnL</b></td>
<td>{{$CpnL}}</td>
</tr>

<tr>
<th scope="row">21</th>
<td><b>CpnL</b></td>
<td>{{$CpnU}}</td>
</tr>

</tbody>
</table>

            </div>
            </div>
            </div>
            </div>


 
    </div>      

 @endsection


 