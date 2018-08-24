@extends('layouts.app')
@section('content')
<title>{{config('app.name', 'SOLARPH')}}</title>
<div class="container">
    <br>
    <div class="col-md-12">
            <div class="row">
            {{-- <div class="col-md-12"> --}}
            <div class="card">
            <div class="card-header">STRINGER MONITORING</div> 
            {{-- <div class="card"> --}}
            <div class="card-body">
            <a href="/stringer/create" class="btn btn-primary">ADD STRINGER DATA</a>
            <br><br>
            <table class="table table-hover table table-bordered">
                    <thead>
                      <tr>
                        <th colspan="2"></th>
                        <th colspan="2" bgcolor="#ccffcc">STRINGER 1A</th>
                        <th colspan="2" bgcolor="#ccffcc">STRINGER 1B</th>
                        <th colspan="2" bgcolor="#ffffcc">STRINGER 2A</th>
                        <th colspan="2" bgcolor="#ffffcc">STRINGER 2B</th>
                        <th colspan="2" bgcolor="#ffe6e6">STRINGER 3A</th>
                        <th colspan="2"bgcolor="#ffe6e6">STRINGER 3B</th>
                      </tr>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">VALUE</th>
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
                        <td bgcolor="#ccffcc">{{$avefront}}</td>
                        <td bgcolor="#ccffcc">{{$aveback}}</td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td><b>Stdev (Ind)</b></td>
                        <td bgcolor="#ccffcc">{{$stdfront}}</td>
                        <td bgcolor="#ccffcc">{{$stdback}}</td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                      </tr>
                      <tr>
                      <th scope="row">3</th>
                        <td><b>XBB (Ave of Ave)</b></td>
                        <td bgcolor="#ccffcc">{{$xbbfront}}</td>
                        <td bgcolor="#ccffcc">{{$xbbback}}</td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td><b>Stdev (Ave)</b></td>
                        <td bgcolor="#ccffcc">{{$stdavg}}</td>
                        <td bgcolor="#ccffcc">{{$stdavgback}}</td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td><b>Median</b></td>
                        <td bgcolor="#ccffcc">{{$medianfront}}</td>
                        <td bgcolor="#ccffcc">{{$medianback}}</td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td><b>Percentile (0.00135)</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td><b>Percentile (0.99865)</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">8</th>
                        <td><b>USL</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">9</th>
                        <td><b>LSL</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">10</th>
                        <td><b>Target</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">11</th>
                        <td><b>Z</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">12</th>
                        <td><b>CpU</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">13</th>
                        <td><b>CpL</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">14</th>
                        <td><b>Cpk</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">15</th>
                        <td><b>CpN U</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">16</th>
                        <td><b>CpN L</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">17</th>
                        <td><b>CpN</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">18</th>
                        <td><b>UCL</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">19</th>
                        <td><b>LCL</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    <tr>
                        <th scope="row">20</th>
                        <td><b>N</b></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ccffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffffcc"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                        <td bgcolor="#ffe6e6"></td>
                    </tr>
                    </tbody>
                  </table>
            </div>
            {{-- </div> --}}
            </div>
            {{-- </div> --}}
            </div>
            </div>
            </div> 
@endsection