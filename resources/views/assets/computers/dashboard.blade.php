@extends('layouts.app')
@section('content')
    <h3>Computing Devices Dashboard</h3>
    <br>
    <div class="row">
        @foreach($charts as $chart)
        <div class="{{count($chart->labels) > 8 ? "col-sm-12" : "col-sm-4"}}">
            <div class="card">
                <div class="card-body">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script src=//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js charset=utf-8></script>
    {{--  <script src=//cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js charset=utf-8></script>  --}}
    @foreach($charts as $chart)
    {!! $chart->script() !!}
    @endforeach
@endsection

@push('jscript')
<script>
    
</script>
@endpush