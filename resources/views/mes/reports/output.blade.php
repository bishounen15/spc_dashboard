@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>
        Daily Output Report{{$cdate}}
    </h3>
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Production Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ $date }}">
                    
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Report</button>
            </div>
        </div>
    </div>

    <div class="row">
        @php
            $prodline = 0;
            $shift = "";
            $model = "";
            $rw = 0;
            $tb = false;
        @endphp

        @foreach($output as $op)
            @foreach($op as $pershift)
                @php
                    $ix = 0;
                    $ar = json_decode(json_encode($pershift),true);
                @endphp
                @foreach($pershift as $key => $value)
                    @if($key == "PRODLINE" && $prodline != $value)
                        <tr>
                            <th class="text-center table-dark" colspan="{{count($ar) - 3}}">
                                Line {{$value}}
                            </th>
                        </tr>
                        @php
                            $prodline = $value;
                            $model = "";
                            $rw = 0;
                        @endphp
                    @elseif($key == "SHIFT" && $shift != $value)
                        @if($tb == true)
                            </tbody></table></div>
                            {{-- <br><hr><br> --}}
                            @php
                                $tb = false;
                            @endphp
                        @endif

                        @if($tb == false)
                            <div class="col-sm">
                            <table class="table table-condensed table-striped table-sm" id="mes-list" style="width: 100%;">
                                    <tbody class="tbody-light">
                            @php
                                $tb = true;
                            @endphp
                        @endif

                        <tr>
                            <th class="text-center text-white bg-success" colspan="{{count($ar) - 3}}">
                                Shift: {{$value}}
                            </th>
                        </tr>
                        
                        @php
                            $shift = $value;
                            $model = "";
                            $prodline = 0;
                            $rw = 0;
                        @endphp
                    @elseif($key == "PRODTYPE" && $model != $value)
                        <tr>
                            <th class="text-center table-warning" colspan="{{count($ar) - 3}}">
                                Model: {{$value}}
                            </th>
                        </tr>
                        @php
                            $model = $value;
                            $rw = 0;
                        @endphp
                    @else
                        @if($ix == 3)
                            @if($rw == 0)
                                <tr class="table-info">
                                    <th>Station</th>
                                    <th>Total Output</th>
                                    @php
                                        $i = 0;
                                    @endphp

                                    @foreach($ar as $k => $v)
                                    @if($i >= 5)    
                                        <th>{{$k}}</th>
                                    @endif
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </tr>
                                @php
                                    $rw++;
                                @endphp
                            @endif
                            <tr>
                        @endif

                        @if($ix >= 3)
                        <td>{{$value}}</td>
                        @endif
                    @endif
                        
                    @php
                        $ix++;
                    @endphp

                    @if($ix == count($ar))
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @endforeach
    </div>
    </div>
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        setInterval(function() {
                  window.location.reload();
        }, 300000);
        
        $("#RefreshButton").click(function() {
            window.location = "/mes/output/" + $("#start").val();
        });
    });
</script>
@endpush