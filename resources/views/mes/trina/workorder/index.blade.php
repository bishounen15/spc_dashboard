@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA Work Order</h3>
    <table class="table table-condensed table-striped table-sm" id="wo-list" style="width: 100%;">
        <thead class="thead-dark">
            <th>Work Order ID</th>
            <th>Work Order Version</th>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Cell Supplier</th>
            <th>Module Color</th>
            <th>Is Bonded</th>
            <th>State</th>
        </thead>
        <tbody class="tbody-light">
            
        </tbody>
    </table>
</div>
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        var table = $('#wo-list').DataTable({
            "scrollX": true,
            "stateSave": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/trina/wo/load',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_wo_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_wo_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<a href="/trina/workorder/'+full.WorkOrder_ID+'/'+full.WorkOrder_vertion+'">'+full.WorkOrder_ID+'</a>';
                }},
                { data: 'WorkOrder_vertion' },
                { data: 'OrderID' },
                { data: 'Product_ID' },
                { data: 'Product_Type' },
                { data: 'Cell_Suppliers' },
                { data: 'Module_Colour' },
                { data: 'IsBonded' },
                { data: 'State' },
            ],
            createdRow: function (row, data, index) {
                if (data.State == "Open") {
                    $(row).addClass('table-success');
                } else {
                    $(row).addClass('table-danger');
                }
            },
        });
    });
</script>
@endpush