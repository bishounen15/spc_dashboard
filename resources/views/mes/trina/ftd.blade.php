@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA FTD Report</h3>
    {{-- <a href="#" role="button" class="btn btn-primary">Create Log Entry</a> --}}
    {{-- <br><br> --}}
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Start Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                    
                    <label class="my-1 mr-2" for="end">End Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="end" id="end" value="{{ date('Y-m-d') }}">        
                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="pack" name="pack" value="option1">
                        <label class="form-check-label" for="pack">Packed Only</label>
                    </div>

                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="ftd-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <th>Work Order ID</th>
            <th>Module ID</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Carton No.</th>
            <th>Container No.</th>
            <th>Test Date/Time</th>
            <th>Title</th>
            <th>Grade</th>
            <th>PMAX</th>
            <th>FF</th>
            <th>VOC</th>
            <th>ISC</th>
            <th>VPM</th>
            <th>IPM</th>
            <th>RS</th>
            <th>RSH</th>
            <th>Env Temp</th>
            <th>Surf Temp</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>
</div>
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/trina/ftd/' + $('#start').val() + '/' + $('#end').val() + "/" + $("#pack").is(":checked") ).load();
        });

        var table = $('#ftd-list').DataTable({
            "scrollX": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/trina/ftd/' + $('#start').val() + '/' + $('#end').val() + "/" + $("#pack").is(":checked"),
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_ftd_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_ftd_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'WorkOrder_ID' },
                // { data: 'Module_ID' },
                { "render": function ( data, type, full, meta ) {
                    if (full.FILEPATH != "") {
                        return '<a href="'+full.FILEPATH+'" target="_blank" type="vnd.sealedmedia.softseal.jpg">'+full.Module_ID+'</a>';
                    } else {
                        return full.Module_ID;
                    }
                }},
                { data: 'Product_ID' },
                { data: 'Product_Type' },
                { data: 'Carton_no' },
                { data: 'Container_No' },
                { data: 'TEST_DATETIME' },
                { data: 'TITLE' },
                { data: 'Grade' },
                { data: 'PMAX' },
                { data: 'FF' },
                { data: 'VOC' },
                { data: 'ISC' },
                { data: 'VPM' },
                { data: 'IPM' },
                { data: 'RS' },
                { data: 'RSH' },
                { data: 'EnvTemp' },
                { data: 'SurfTemp' },
            ],
        });
    });
</script>
@endpush