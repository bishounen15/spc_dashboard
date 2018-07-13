@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Office Supplies Inventory</h3>
    <a href="{{route('create_trx',['Incoming'])}}" role="button" class="btn btn-success" style="width: 200px;">Incoming Transaction</a>
    <a href="{{route('create_trx',['Request'])}}" role="button" class="btn btn-info" style="width: 200px;">Request Office Supplies</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="trx-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Control No.</th>
            <th>Type</th>
            <th>Department</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total Cost</th>
            <th>-</th>
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
        $('#trx-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('trx_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'Excel',
                    filename: "os_transactions_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'CSV',
                    filename: "os_transactions_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'control_no' },
                { data: 'type' },
                { data: 'department' },
                { data: 'date' },
                { data: 'status' },
                { data: 'total_cost' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-12"><a href="/os/transaction/'+full.id+'" role="button" class="btn btn-sm btn-success" style="width: 100%;">View Details</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush