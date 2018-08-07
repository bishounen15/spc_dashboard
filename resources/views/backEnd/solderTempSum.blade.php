@extends('layouts.app')
  
@section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">J-Box Solder Temperature Monitoring</div> 
            <div class="card-body">
                
<a href="/Summary" class="btn btn-secondary">Go Back</a>
<a href="/solderTemp" class="btn btn-success">View Records</a>
<a href="/SolderTemp/create" class="btn btn-success">Add Record</a>           

<div class="container">
<br>
<div class="col-md-12">
<div class="row">
{{-- <div class="col-md-12"> --}}
<div class="card">
<div class="card-header">Table of computation for J-Box Solder Temperature Monitoring </div> 
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
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">2</th>
        <td><b>Stdev (Ind)</b></td>
        <td></td>
        
        <tr>
            <th scope="row">3</th>
            <td><b>N</b></td>
            <td>30</td>
            
            </tr>
        
        </tr>
        <tr>
        <th scope="row">4</th>
        <td><b>Ave (Ave)</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">5</th>
        <td><b>Stdev (Ave)</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">6</th>
        <td><b>Median</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">7</th>
        <td><b>Percentile (0.00135)</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">8</th>
        <td><b>Percentile (0.99865)</b></td>
        <td></td>
        
        
        </tr>
        <tr>
        <th scope="row">9</th>
        <td><b>USL</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">10</th>
        <td><b>LSL</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">11</th>
        <td><b>Target</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">12</th>
        <td><b>Z</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">13</th>
        <td><b>CpU</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">14</th>
        <td><b>CpL</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">15</th>
        <td><b>Cpk</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">16</th>
        <td><b>UCL</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">17</th>
        <td><b>LCL</b></td>
        <td></td>
        
        </tr>
        <tr>
        <th scope="row">18</th>
        <td><b>CL</b></td>
        <td></td>
        
        </tr>
        
        <tr>
        <th scope="row">19</th>
        <td><b>Cpn</b></td>
        <td></td>
        </tr>
        
        <tr>
        <th scope="row">20</th>
        <td><b>CpnL</b></td>
        <td></td>
        </tr>
        
        <tr>
        <th scope="row">21</th>
        <td><b>CpnL</b></td>
        <td></td>
        </tr>
        
        </tbody>
        </table>

            </div>
            </div>
            </div>
            </div>


 
    </div>      

 @endsection


 