@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA Lot Monitoring</h3>
    {{-- <a href="#" role="button" class="btn btn-primary">Create Log Entry</a> --}}
    {{-- <br><br> --}}
    <div class="card">
        <div class="card-body">
            <div class="form-inline">
                <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="lot-list" style="width: 100%;">
        <thead class="thead-dark">
            <th width="20%">Module</th>
            <th width="20%">Material</th>
            <th width="20%">Lot Number</th>
            <th width="20%">Total</th>
            <th width="20%">Max Quantity</th>
        </thead>
        <tbody class="tbody-light">
            
        </tbody>
    </table>
</div>
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#RefreshButton").click();    
        }, 10000);

        $("#RefreshButton").click(function() {
            table.ajax.url( '/trina/lot' ).load();
        });

        var table = $('#lot-list').DataTable({
            "scrollX": true,
            "stateSave": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/trina/lot',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_lot_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_lot_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'Module' },
                { data: 'Material' },
                { data: 'LotNumber' },
                { data: 'total' },
                { data: 'max_total' },
            ],
            createdRow: function (row, data, index) {
                if (parseInt(data.total) >= data.max_total) {
                    $(row).addClass('table-danger');
                } else if (parseInt(data.total) >= (data.max_total - 5)) {
                    $(row).addClass('table-warning');
                } else {
                    $(row).addClass('table-success');
                }
            },
        });
    });
</script>
@endpush