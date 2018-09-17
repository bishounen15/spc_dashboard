@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Computing Devices Master List</h3>
    <br>
    <table class="table table-condensed table-striped table-sm" id="asset-list" style="width: 100%;">
        <thead class="thead-dark text-center" style="font-size: 0.7em;">
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Serial No.</th>
                <th rowspan="2">Type</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Brand</th>
                <th rowspan="2">Model</th>
                <th rowspan="2">Host Name</th>
                <th rowspan="2">OS</th>
                <th rowspan="2">Processor</th>
                <th rowspan="2">RAM</th>
                <th rowspan="2">HDD</th>
                <th colspan="2">LAN</th>
                <th colspan="2">WIFI</th>
                <th rowspan="2">ID Number</th>
                <th rowspan="2">Name</th>
                <th rowspan="2">Dept.</th>
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
{{-- </div> --}}
@endsection

@include('layouts.modal')
@push('jscript')
<script>
    $(document).ready(function() {
        $('#asset-list').DataTable({
            "scrollX": true,
            "order": [],
            ajax: '{!! route('asset_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17 ]
                    },
                    text:       'Excel',
                    filename: "assets_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17 ]
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
                { data: 'id' },
                { data: 'serial' },
                { data: 'type' },
                { data: 'status' },
                { data: 'brand' },
                { data: 'model' },
                { data: 'host_name' },
                { data: 'os' },
                { data: 'proc' },
                { data: 'ram' },
                { data: 'hdd' },
                { data: 'lan_ip' },
                { data: 'lan_mac' },
                { data: 'wifi_ip' },
                { data: 'wifi_mac' },
                { data: 'id_number' },
                { data: 'name' },
                { data: 'dept' },
            ],
        });
    });
</script>
@endpush