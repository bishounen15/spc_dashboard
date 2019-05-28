@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA Module Information</h3>
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Start Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                    
                    <label class="my-1 mr-2" for="end">End Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="end" id="end" value="{{ date('Y-m-d') }}">        
                    
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="mod-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <th>Module ID</th>
            <th>Order ID</th>
            <th>Work Order ID</th>
            <th>Version</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Module Grade</th>
            <th>EL Grade</th>
            <th>Status</th>
            <th>Carton No.</th>
            <th>Test Line</th>
            <th>Test Date</th>
            <th>Packing Date</th>
            <th>Packing State</th>
            <th>Container No.</th>
            <th>Container Date</th>
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
            table.ajax.url( '/trina/modinfo/' + $('#start').val() + '/' + $('#end').val() ).load();
        });
        
        var table = $('#mod-list').DataTable({
            "scrollX": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/trina/modinfo/' + $('#start').val() + '/' + $('#end').val() ,
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_module_info_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_module_info_csv"
                },
            ],
            columns: [
                { data: 'Module_ID' },
                { data: 'OrderID' },
                { data: 'WorkOrder_ID' },
                { data: 'WorkOrder_vertion' },
                { data: 'Product_ID' },
                { data: 'Product_Type' },
                { data: 'Module_Grade' },
                { data: 'EL_Grade' },
                { data: 'Status' },
                { data: 'Carton_No' },
                { data: 'Title' },
                { data: 'TEST_DATETIME' },
                { data: 'Packing_Date' },
                { data: 'PackingState' },
                { data: 'Container_no' },
                { data: 'ContainerDate' },
            ],
        });
    });
</script>
@endpush