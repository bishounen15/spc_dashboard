@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-4">
            <div class="card">
              <div class="card-header">
                LAMINATOR
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href ="/lamdata">LXM Data Input</a></li>
                <li class="list-group-item"><a href ="/pulltestdata">Pull Test Data Input</a></li>
              </ul>
            </div>

              <br>
                <div class="card"> 
                        <div class="card-header">
                        STRINGER
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><a href ="/stringerdata">Stringer Data Input</a></li>
                        </ul>
                </div>
              <br>
                <div class="card">
                    <div class="card-header">
                      FLASH TEST DATA
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><a href ="/ftd">Flash Test Data Input</a></li>
                    </ul>
                </div>
    </div>
      <div class="col-4"> 
          <div class="card">
                  <div class="card-header">
                    MATRIX ASSY
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href ="/matrixpulltest">Ribbon-to-Busbar Pull Test</a></li>
                    <li class="list-group-item"><a href ="/matsolder">Matrix Soldering Temp</a></li>
                  </ul>
                </div>
              <br>
                <div class="card"> 
                        <div class="card-header">
                        OFFLINE/MATERIAL PREP
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><a href ="/offlinebtob">Busbar-to-Busbar Pull Test</a></li>
                          <li class="list-group-item"><a href ="/offlinematsolder">Offline Matrix Soldering Temp</a></li>
                        </ul>
                </div>
              <br>
              
              <br>          
              <br>
      </div> 
     <div class="col-4">
    <div class="card">
        <div class="card-header">Back End</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a  href="/SPC/Frame">Framming Qual</a></li>
          <li class="list-group-item"><a  href="/SPC/Framming">Framming Squareness and Bowing</a></li>
          <li class="list-group-item"><a href="/SPC/ELTest">EL Test Monitoring</a></li>
          <li class="list-group-item"><a href="/SPC/SolderTemp">J-Box Solder Temp</a></li>
          <li class="list-group-item"><a href="/SPC/JBox">J-Box Dispense Weight</a></li>
          <li class="list-group-item"><a href="/SPC/MixRatio">Pottant Mixing Ratio</a></li>
          <li class="list-group-item"><a href="/SPC/Potting">Potting</a></li>
          <li class="list-group-item"><a href="/SPC/Curing">Curing</a></li>
        </ul>
    </div>
</div>
@endsection