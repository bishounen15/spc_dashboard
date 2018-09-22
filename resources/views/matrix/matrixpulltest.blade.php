@extends('layouts.app')
  
@section('content')
<div class="container">
    <br>
    <div class="col-md-12">
    <div class="row">
   
    <div class="card">
    <div class="card-header">Ribbon to Busbar Monitoring</div> 
   
    <div class="card-body">
       
    <a href="/Summary" class="btn btn-secondary">Go Back</a>
    <a href="/matrixpulltest/create" class="btn btn-primary">Input Data</a>
    <a href="/rtobpulltest" class="btn btn-primary">View Data</a>
    <br><br>

    <div class="card-header">Table of computation for Ribbon to Busbar Monitoring </div> 
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
                <?php  $getLastProd = DB::select("SELECT * FROM prodselect JOIN producttype ON prodselect.productName = producttype.prodName WHERE ProcessName ='Matrix Assembly' ORDER BY prodselect.created_at DESC LIMIT 1"); 
                      
                ?>
                  @if(count($getLastProd) > 0)
                  @foreach($getLastProd as $field)   
               
                           {{Form::text('prodBuilt', $field->productName."   (".$field->bomType.")" , ['class' => 'form-control','readonly' => 'true'])}}
                           @endforeach
                           @else
                           Not Set.
                           @endif
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
            <div class="row"> 
                <div class="col-md-7">
            <?php  $getLastProd = DB::select("SELECT * FROM producttype ");   ?>
              @if(count($getLastProd) > 0)

              <select id="prodSel"  name="prodSel" class="form-control">
                @foreach($getLastProd as $s)  
                        <option selected value="{{ $s->prodName }}">{{ $s->prodName }}</option> 
                @endforeach
            </select>   
             
                       @else
                       No Record.
                       @endif
        </div>
        <div class="col-md-5">
            &emsp; {{Form::submit('Submit',['class'=> 'btn btn-primary'])}}&emsp;
        </div> 
            </div>
    {!! Form::close() !!}
        </div>
            </div>


</div>
 
    <table class="table table-hover table table-bordered">
        <thead>
        <tr>
         <th colspan="2"></th>   
         <th colspan="3" ><center>Bussing 1 Values</center></th>   
         <th colspan="3" ><center>Bussing 2 Values</center></th>   
         <th colspan="2" ><center>Rework Values</center></th>  
        </tr>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Indicators</th>
        <th scope="col">Top 1</th>
        <th scope="col">Top 2</th>
        <th scope="col">Bottom</th>
        <th scope="col">Top 1</th>
        <th scope="col">Top 2</th>
        <th scope="col">Bottom</th>
        <th scope="col">Top </th>
        <th scope="col">Bottom</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <th scope="row">1</th>
        <td><b>Ave (Ind)</b></td>
        <td>{{$aveIndB1T1}}</td>
        <td>{{$aveIndB1T2}}</td>
        <td>{{$aveIndB1B}}</td>
        <td>{{$aveIndB2T1}}</td>
        <td>{{$aveIndB2T2}}</td>
        <td>{{$aveIndB2B}}</td>
        <td>{{$aveIndRT}}</td>
        <td>{{$aveIndRB}}</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td><b>Stdev (Ind)</b></td>
        <td>{{$stdIndB1T1}}</td>
        <td>{{$stdIndB1T2}}</td>
        <td>{{$stdIndB1B}}</td>
        <td>{{$stdIndB2T1}}</td>
        <td>{{$stdIndB2T2}}</td>
        <td>{{$stdIndB2B}}</td>
        <td>{{$stdIndRT}}</td>
        <td>{{$stdIndRB}}</td>
        
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
        <td>{{$aveOfAveB1T2}}</td>
        <td>{{$aveOfAveB1B}}</td>
        <td>{{$aveOfAveB2T1}}</td>
        <td>{{$aveOfAveB2T2}}</td>
        <td>{{$aveOfAveB2B}}</td>
        <td>{{$aveOfAveRT}}</td>
        <td>{{$aveOfAveRB}}</td>
        
        </tr>
        <tr>
        <th scope="row">5</th>
        <td><b>Stdev (Ave)</b></td>
       <td>{{$stdOfStdB1T1}}</td>
       <td>{{$stdOfStdB1T2}}</td>
       <td>{{$stdOfStdB1B}}</td>
       <td>{{$stdOfStdB2T1}}</td>
       <td>{{$stdOfStdB2T2}}</td>
       <td>{{$stdOfStdB2B}}</td>
       <td>{{$stdOfStdRT}}</td>
       <td>{{$stdOfStdRB}}</td>
        
        </tr>
        <tr>
        <th scope="row">6</th>
        <td><b>Median</b></td>
        <td>{{$medianB1T1}}</td>
        <td>{{$medianB1T2}}</td>
        <td>{{$medianB1B}}</td>
        <td>{{$medianB2T1}}</td>
        <td>{{$medianB2T2}}</td>
        <td>{{$medianB2B}}</td>
        <td>{{$medianRT}}</td>
        <td>{{$medianRB}}</td>
        
        </tr>
        <tr>
        <th scope="row">7</th>
        <td><b>Percentile (0.00135)</b></td>
        <td>{{$perc1B1T1}}</td>
        <td>{{$perc1B1T2}}</td>
        <td>{{$perc1B1B}}</td>
        <td>{{$perc1B2T1}}</td>
        <td>{{$perc1B2T2}}</td>
        <td>{{$perc1B2B}}</td>
        <td>{{$perc1RT}}</td>
        <td>{{$perc1RB}}</td>
        
        
        </tr>
        <tr>
        <th scope="row">8</th>
        <td><b>Percentile (0.99865)</b></td>
        <td>{{$perc2B1T1}}</td>
        <td>{{$perc2B1T2}}</td>
        <td>{{$perc2B1B}}</td>
        <td>{{$perc2B2T1}}</td>
        <td>{{$perc2B2T2}}</td>
        <td>{{$perc2B2B}}</td>
        <td>{{$perc2RT}}</td>
        <td>{{$perc2RB}}</td>
        
        
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
        <td>{{ $zBus1Top2 }}</td>
        <td>{{ $zBus1Bot }}</td>
        <td>{{ $zBus2Top1 }}</td>
        <td>{{ $zBus2Top2 }}</td>
        <td>{{ $zBus2Bot }}</td>
        <td>{{ $zRB}}</td>
        <td>{{ $zRT}}</td>
    </tr>
        <tr>
        <th scope="row">13</th>
        <td><b>CpU</b></td>
        <td>{{ $CpUB1T1 }}</td>
        <td>{{ $CpUB1T2 }}</td>
        <td>{{ $CpUB1B }}</td>
        <td>{{ $CpUB2T1 }}</td>
        <td>{{ $CpUB2T2 }}</td>
        <td>{{ $CpUB2B }}</td>
        <td>{{ $CpURT }}</td>
        <td>{{ $CpURB }}</td>
        </tr>
        <tr>
        <th scope="row">14</th>
        <td><b>CpL</b></td>
        <td>{{ $CpLB1T1 }}</td>
        <td>{{ $CpLB1T2 }}</td>
        <td>{{ $CpLB1B }}</td>
        <td>{{ $CpLB2T1 }}</td>
        <td>{{ $CpLB2T2 }}</td>
        <td>{{ $CpLB2B }}</td>
        <td>{{ $CpLRT }}</td>
        <td>{{ $CpLRB }}</td>
        
        </tr>
        <tr>
        <th scope="row">15</th>
        <td><b>Cpk</b></td>
        <td>{{ $CpkB1T1 }}</td>
        <td>{{ $CpkB1T2 }}</td>
        <td>{{ $CpkB1B }}</td>
        <td>{{ $CpkB2T1 }}</td>
        <td>{{ $CpkB2T2 }}</td>
        <td>{{ $CpkB2B }}</td>
        <td>{{ $CpkRT }}</td>
        <td>{{ $CpkRB }}</td>
        
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
        <td>{{ $CpnB1T2 }}</td>
        <td>{{ $CpnB1B }}</td>
        <td>{{ $CpnB2T1 }}</td>
        <td>{{ $CpnB2T2 }}</td>
        <td>{{ $CpnB2B }}</td>
        <td>{{ $CpnRT }}</td>
        <td>{{ $CpnRB }}</td>
        
        </tr>
        
        <tr>
        <th scope="row">20</th>
        <td><b>CpnU</b></td>
        <td>{{ $CpnUB1T1 }}</td>
        <td>{{ $CpnUB1T2 }}</td>
        <td>{{ $CpnUB1B }}</td>
        <td>{{ $CpnUB2T1 }}</td>
        <td>{{ $CpnUB2T2 }}</td>
        <td>{{ $CpnUB2B }}</td>
        <td>{{ $CpnURT }}</td>
        <td>{{ $CpnURB }}</td>
        </tr>
        
        <tr>
        <th scope="row">21</th>
        <td><b>CpnL</b></td>
        <td>{{ $CpnLB1T1 }}</td>
        <td>{{ $CpnLB1T2 }}</td>
        <td>{{ $CpnLB1B }}</td>
        <td>{{ $CpnLB2T1 }}</td>
        <td>{{ $CpnLB2T2 }}</td>
        <td>{{ $CpnLB2B }}</td>
        <td>{{ $CpnLRT }}</td>
        <td>{{ $CpnLRB }}</td>
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
