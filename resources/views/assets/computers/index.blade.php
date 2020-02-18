@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm">
            <h3><i class="fas fa-laptop"></i> Computing Devices Master List</h3>
        </div>

        @if(Auth::user()->assets_role == "MNGE" || Auth::user()->sysadmin == 1)
        <div class="col-sm text-right">
            <a href="/assets/create" role="button" class="btn btn-success"><i class="fas fa-plus"></i> Add Record</a>
        </div>
        @endif
    </div>
    
    <table class="table table-condensed table-striped table-sm" id="asset-list" style="width: 100%;">
        <thead class="thead-dark text-center" style="font-size: 0.7em;">
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Serial No.</th>
                <th rowspan="2">Device Type</th>
                <th rowspan="2">Property Type</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Brand</th>
                <th rowspan="2">Model</th>
                <th rowspan="2">Host Name</th>
                <th rowspan="2">OS</th>
                <th rowspan="2">Processor</th>
                <th rowspan="2">RAM</th>
                <th rowspan="2">HDD</th>
                <th rowspan="2">Graphics Card</th>
                <th colspan="2">LAN</th>
                <th colspan="2">WIFI</th>
                <th rowspan="2">Site</th>
                <th rowspan="2">ID Number</th>
                <th rowspan="2">Name</th>
                <th rowspan="2">Dept.</th>
                <th rowspan="2">Remarks</th>
                <th rowspan="2">Last Update</th>
            </tr>
            <tr>
                <th>IP</th>
                <th>MAC</th>
                <th>IP</th>
                <th>MAC</th>
            </tr>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>
</div>
@endsection

@include('layouts.modal')
@push('jscript')
<script>
    $(document).ready(function() {
        var t = $('#asset-list').DataTable({
            "columnDefs": [ {
                "targets": 0
            } ],
            "scrollX": true,
            "stateSave": true,
            "order": [],
            ajax: '{!! route('asset_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22 ]
                    },
                    text:       'Excel',
                    filename: "assets_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22 ]
                    },
                    text:       'CSV',
                    filename: "assets_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                { data: null, defaultContent: '0' },
                // { data: 'serial' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<a href="/assets/general/'+full.id+'">'+full.serial+'</a>';
                }},
                { data: 'type' },
                { data: 'status' },
                { data: 'device_status' },
                { data: 'brand' },
                { data: 'model' },
                { data: 'host_name' },
                { data: 'os' },
                { data: 'proc' },
                { data: 'ram' },
                { data: 'hdd' },
                { data: 'gfx_card' },
                { data: 'lan_ip' },
                { data: 'lan_mac' },
                { data: 'wifi_ip' },
                { data: 'wifi_mac' },
                { data: 'site' },
                { data: 'id_number' },
                { data: 'name' },
                { data: 'dept' },
                { data: 'remarks' },
                { data: 'updated_at' },
            ],
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endpush