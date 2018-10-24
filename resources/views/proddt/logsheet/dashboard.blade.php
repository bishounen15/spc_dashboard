@extends('layouts.app')
@section('content')
<h3>Downtime Monitoring Dashboard</h3>
{{-- <div class="container"> --}}
<div class="card">
    {{-- <div class="card-header">Dashboard Parameters</div> --}}
    <div class="card-body">
        
            <div class="form-inline">
                <label class="my-1 mr-2" for="date">Date</label>
                <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="date" id="date" value="{{ date('Y-m-d') }}">
    
                <label class="my-1 mr-2" for="shift">Shift</label>
                <select class="form-control form-control-sm my-1 mr-sm-2" name="shift" id="shift">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="-">All Shift</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
    
                <label class="my-1 mr-2" for="shift">Station</label>
                <select class="form-control form-control-sm my-1 mr-sm-2" name="station_id" id="station_id">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="0">All Station</option>
                    @foreach($stations as $station)
                    <option value="{{$station->id}}">{{$station->descr}}</option>
                    @endforeach
                </select>
    
                <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-9">
        <table class="table table-sm table-condensed" id="downtime-list">
            <thead>
                <tr class="table-secondary">
                    <th width="15%">Date</th>
                    <th width="5%">Shift</th>
                    <th width="10%">Station</th>
                    <th width="10%">Time Start</th>
                    <th width="10%">Time End</th>
                    <th width="5%">Duration</th>
                    <th width="10%">Issues</th>
                    <th width="15%">Category</th>
                    <th width="10%">Remarks</th>
                    <th width="10%">Encoded By</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="col-sm-3 summary-card">
        <div class="card">
            <div class="card-header bg-success text-white"><small><strong>TOTAL HRS PRODUCTIVITY</strong></small></div>
            <div class="card-body" id="total_prod">
                <h1 class="text-center">0</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary text-white"><small><strong>EXPECTED OUTPUT</strong></small></div>
            <div class="card-body" id="total_expected">
                <h1 class="text-center">0</h1>
            </div>
        </div>

        @foreach($categories as $category)
        <div class="card">
            <div class="card-header bg-{{$category->color_scheme}} text-white"><small><strong>TOTAL HRS {{strtoupper($category->descr)}}</strong></small></div>
            <div class="card-body" id="total_{{$category->code}}">
                <h1 class="text-center">0</h1>
            </div>
        </div>
        @endforeach
    </div>
</div>
{{-- </div> --}}
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        var shift = "-";
        var station_id = 0;
        var total_duration = 0;
        var total_capacity = 0;
        var shifts = [];
        var stations = [];

        $("#RefreshButton").click(function() {
            shifts = [];
            stations = [];

            total_duration = 0;
            total_capacity = 0;

            $(".summary-card h1").html('0');
            table.ajax.url( '/proddt/dashboard/data/' + $('#date').val() + '/' + shift + '/' + station_id );
            table.ajax.reload( function ( json ) {
                console.log(total_capacity);

                total_prod = Math.round( ((8 * shifts.length) - total_duration) * 100)/100
                $("#total_prod h1").html(total_prod);
                $("#total_expected h1").html(Math.floor(total_prod * total_capacity));
            } );
        });

        $("#shift").change(function() {
            shift = $(this).val();
        });

        $("#station_id").change(function() {
            station_id = $(this).val();
            // console.log(station_id);
        });

        var table = $('#downtime-list').DataTable({
            // "scrollX": true,
            "order": [],
            "searching": false,
            "paging": false,
            ajax: '/proddt/dashboard/data/' + $('#date').val() + '/' + shift + '/' + station_id,
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'Excel',
                    filename: "stations_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'CSV',
                    filename: "stations_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'date' },
                { data: 'shift' },
                { data: 'station' },
                { data: 'start' },
                { data: 'end' },
                { data: 'duration' },
                { data: 'issue' },
                { data: 'category' },
                { data: 'remarks' },
                { data: 'user' },
            ],
            createdRow: function (row, data, index) {
                //
                // if the second column cell is blank apply special formatting
                //
                if(shifts.indexOf(data.shift) === -1) {
                    shifts.push(data.shift);
                }

                if(stations.indexOf(data.machine) === -1) {
                    stations.push(data.machine);
                    total_capacity += parseInt(data.capacity);
                }

                currVal = parseFloat($("#total_" + data.code + " h1").html());
                currVal += parseFloat(data.duration);
                total_duration += parseFloat(data.duration);
                // console.log(currVal);
                $("#total_" + data.code + " h1").html(Math.round(currVal*100)/100);
            },
            "initComplete": function(settings, json) {
                $("#total_prod h1").html(Math.round( ((8 * shifts.length) - total_duration) * 100)/100);
            },
        });
    });
</script>
@endpush