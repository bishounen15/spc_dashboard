@extends('layouts.app')
@section('content')
<title>{{config('app.name', 'SOLARPH')}}</title>
<div class="container">
@guest
<div class="row">
  <div class="alert alert-danger col text-center">
    <strong>You are not logged in.</strong>
  </div>
</div>
@else
<div class="row">
    <div class="col-4">
        {{-- style="width: 16rem;" --}}
            <div class="card">
              <div class="card-header">
                LAMINATOR
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href ="/lam/create">LXM Data Input</a></li>
                <li class="list-group-item"><a href ="/laytec/create">Laytec Data Input</a></li>
                <li class="list-group-item"><a href ="/pulltest/create">Pull Test Data Input</a></li>
                <li class="list-group-item"><a href ="/pulltestEG/create">EVA - Glass / EVA- Backsheet</a></li>
              </ul>
            </div>

            {{-- <div class="col-3"> --}}
              <br>
              {{-- style="width: 16rem;" --}}
                <div class="card"> 
                        <div class="card-header">
                        STRINGER
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><a href ="/stringer/create">Stringer Data Input</a></li>
                        </ul>
                </div>
              <br>
              {{-- style="width: 16rem;" --}}
                <div class="card">
                    <div class="card-header">
                      FLASH TEST DATA
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><a href ="/flash/create">Flash Test Data Input</a></li>
                    </ul>
                </div>
            {{-- </div> --}}
    </div>
    <div class="col-4">
        {{-- style="width: 16rem;" --}}
        <div class="card">
                <div class="card-header">
                  MATRIX
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><a href ="/matrixpulltest/create">Pull Test</a></li>
                  <li class="list-group-item"><a href ="/matsolder/create">Soldering</a></li>
                </ul>
              </div>
    </div>

    <div class="col-4">
    {{-- style="width:26rem;" --}}
    <div class="card">
        <div class="card-header">Back End</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a  href="/Frame">Framming Qual</a></li>
          <li class="list-group-item"><a  href="/Framming">Framming Squareness and Bowing</a></li>
          <li class="list-group-item"><a href="/SolderTemp">J-Box Solder Temp</a></li>
          <li class="list-group-item"><a href="/JBox">J-Box Dispense Weight</a></li>
          <li class="list-group-item"><a href="/MixRatio">Pottant Mixing Ratio</a></li>
          <li class="list-group-item"><a href="/Potting">Potting</a></li>
          <li class="list-group-item"><a href="/Curing">Curing</a></li>
        </ul>
    </div>
    </div>
        {{-- <div class="col-9">
                <table class="table">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">Lamination</th>
                            <th scope="col">Critical Node</th>
                            <th scope="col">Unit</th>
                            <th scope="col">OBJ Specs</th>
                            <th scope="col">SHR Specs</th>
                            <th scope="col">AVE</th>
                            <th scope="col">STDEV</th>
                            <th scope="col">CPK</th>
                            <th scope="col">Dist</th>
                            <th scope="col">Remarks</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Lam1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Lam2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          
                        </tbody>
                      </table>
        </div> --}}
</div>
@endguest
</div>
@endsection