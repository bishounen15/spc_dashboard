@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>Product Types</h3>
    @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
    {{-- <a href="/planning/schedule/create" role="button" class="btn btn-primary">Create Schedule</a> --}}
    {{-- <br><br> --}}
    @endif
    <table class="table table-condensed table-striped table-sm" id="types-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Product Type</th>
            <th>Customer</th>
            <th>Cell Count</th>
            <th>Cell Type</th>
            <th>Class</th>
            <th>Serial Format</th>
            <th>Model Format</th>
            <th>Actions</th>
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
        $('#types-list').DataTable({
            // "scrollX": true,
            "stateSave": true,
            "order": [],
            ajax: '{!! route('prodtypes_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    text:       'Excel',
                    filename: "product_types_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    text:       'CSV',
                    filename: "product_types_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'PRODTYPE' },
                { data: 'CUSTOMER' },
                { data: 'CELLCOUNT' },
                { data: 'CELLCOLOR' },
                { data: 'CTYPE' },
                { data: 'SERIALFORMAT' },
                { data: 'PRODCODE' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<a href="/planning/products/'+full.ROWID+'/edit" role="button" class="btn btn-sm btn-success" style="width: 100%;">BOM Info</a>';
                }},
            ],
        });
    });
</script>
@endpush