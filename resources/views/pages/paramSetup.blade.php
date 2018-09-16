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
        {{-- style="width: 16rem;" --}}
            <div class="card">
              <div class="card-header">
                LAMINATOR Set-up
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href ="/lamdata">LXM Data Input</a></li>
                <li class="list-group-item"><a href ="/pulltestdata">Pull Test Data Input</a></li>
              </ul>
            </div>

            {{-- <div class="col-3"> --}}
              <br>
              {{-- style="width: 16rem;" --}}
                <div class="card"> 
                        <div class="card-header">
                        STRINGER Set-up
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><a href ="/stringer">Stringer Data Input</a></li>
                        </ul>
                </div>
              <br>
              {{-- style="width: 16rem;" --}}
                <div class="card">
                    <div class="card-header">
                      FLASH TEST DATA Set-up
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><a href ="/ftd">Flash Test Data Input</a></li>
                    </ul>
                </div>
            {{-- </div> --}}
    </div>
      <div class="col-4"> 
          {{-- style="width: 16rem;" --}}
          <div class="card">
                  <div class="card-header">
                    MATRIX ASSY Set-up
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href ="/matrixpulltest">Ribbon-to-Busbar Pull Test</a></li>
                    <li class="list-group-item"><a href ="/matsolder">Matrix Soldering Temp</a></li>
                  </ul>
                </div>
  
              {{-- <div class="col-3"> --}}
              <br>
              {{-- style="width: 16rem;" --}}
                <div class="card"> 
                        <div class="card-header">
                        OFFLINE/MATERIAL PREP Set-up
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><a href ="/offlinebtob">Busbar-to-Busbar Pull Test</a></li>
                          <li class="list-group-item"><a href ="/offlinematsolder">Busbar-to-Busbar Soldering Temp</a></li>
                        </ul>
                </div>
              <br>
              
              <br>
              {{-- style="width: 16rem;" --}}
            
              <br>
      </div> 
     <div class="col-4">
    {{-- style="width:26rem;" --}}
    <div class="card">
        <div class="card-header">Back End Set-up</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a  href="/Frame">Framming Qual</a></li>
          <li class="list-group-item"><a  href="/Framming">Framming Squareness and Bowing</a></li>
       
          <li class="list-group-item"><a href="/SolderTemp">J-Box Solder Temp</a></li>
          <li class="list-group-item"><a href="/JBox">J-Box Dispense Weight</a></li>
          <li class="list-group-item"><a href="/MixRatio">Pottant Mixing Ratio</a></li>
          <li class="list-group-item"><a href="/Potting">Potting</a></li>
   
        </ul>
    </div>
      

    <div class="card">
        <div class="card-header">General Set-up</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a  href="/process/create">Process</a></li>
          
        </ul>
    </div>

</div>
{{-- @endguest --}}
</div>
@endsection