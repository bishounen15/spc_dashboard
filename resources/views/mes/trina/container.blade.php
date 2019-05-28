@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA Container Information</h3>
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
                        <input class="form-check-input" type="checkbox" id="shipped" name="shipped" value="option1">
                        <label class="form-check-label" for="shipped">Exclude Shipped</label>
                    </div>

                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="cont-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <th>Contract no</th>
            <th>Batch No</th>
            <th>Carton No</th>
            <th>Workorder ID</th>
            <th>Module ID</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Purchase Order</th>
            <th>Country Of Original</th>
            <th>Cell Suppliers</th>
            <th>CONTAINER No</th>
            <th>SEAL.</th>
            <th>BOL.</th>
            <th>Ship destination</th>
            <th>Cells Per Panel</th>
            <th>Production Date</th>
            <th>cell No</th>
            <th>MODULE GRADE</th>
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
            table.ajax.url( '/trina/container/' + $('#start').val() + '/' + $('#end').val() + "/" + $("#shipped").is(":checked") ).load();
        });

        var table = $('#cont-list').DataTable({
            "scrollX": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/trina/container/' + $('#start').val() + '/' + $('#end').val() + "/" + $("#shipped").is(":checked"),
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_Container_Info_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_Container_Info_csv"
                },
            ],
            columns: [
                { data: 'Contract no' },
                { data: 'Batch No' },
                { data: 'Carton No' },
                { data: 'Workorder ID' },
                { data: 'Module ID' },
                { data: 'Product ID' },
                { data: 'Product Type' },
                { data: 'Purchase Order' },
                { data: 'Country Of Original' },
                { data: 'Cell Suppliers' },
                { data: 'CONTAINER No' },
                { data: 'SEAL' },
                { data: 'BOL' },
                { data: 'Ship destination' },
                { data: 'Cells Per Panel' },
                { data: 'Production Date' },
                { data: 'cell No' },
                { data: 'MODULE GRADE' },
            ],
        });
    });
</script>
@endpush