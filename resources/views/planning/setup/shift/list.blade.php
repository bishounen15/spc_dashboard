@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Shift Master</h3>
    <a href="/planning/setup/shift/create" role="button" class="btn btn-primary">Create Shift</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="shift-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Code</th>
            <th>Description</th>
            <th>Start</th>
            <th>End</th>
            <th>Overday</th>
            <th>Actions</th>
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
        $('#shift-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('shift_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'Excel',
                    filename: "product_types_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1 ]
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
                { data: 'code' },
                { data: 'descr' },
                { data: 'start_time' },
                { data: 'end_time' },
                { data: 'overday' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/planning/setup/shift/'+full.id+'/edit" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/planning/setup/shift/destroy/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush