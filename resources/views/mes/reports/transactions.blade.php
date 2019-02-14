@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>MFG Daily Transactions</h3>
    {{-- <a href="#" role="button" class="btn btn-primary">Create Log Entry</a> --}}
    {{-- <br><br> --}}
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
    <table class="table table-condensed table-striped table-sm" id="mes-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th width="10%">Serial Number</th>
            <th width="10%">Model</th>
            <th width="5%">Line</th>
            <th width="5%">Class</th>
            <th width="5%">Location</th>
            <th width="5%">Customer</th>
            <th width="10%">Trx. Date</th>
            <th width="10%">Scan Date</th>
            <th width="5%">Shift</th>
            <th width="5%">Status</th>
            <th width="20%">Remarks</th>
            <th width="10%">User</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>
{{-- </div> --}}
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/mes/data/' + $('#start').val() + '/' + $('#end').val() ).load();
        });

        var table = $('#mes-list').DataTable({
            // "scrollX": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/mes/data/' + $('#start').val() + '/' + $('#end').val(),
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                    },
                    text:       'Excel',
                    filename: "MES_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                    },
                    text:       'CSV',
                    filename: "MES_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'SERIALNO' },
                { data: 'MODEL' },
                { data: 'PRODLINE' },
                { data: 'MODCLASS' },
                { data: 'LOCNCODE' },
                { data: 'CUSTOMER' },
                { data: 'DATE' },
                { data: 'TRXDATE' },
                { data: 'SHIFT' },
                { data: 'STATUS' },
                { data: 'REMARKS' },
                { data: 'USER' },
            ],
        });
    });
</script>
@endpush