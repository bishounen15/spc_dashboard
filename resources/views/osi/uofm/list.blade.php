@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>U of M Master</h3>
    <a href="{{route('create_uofm')}}" role="button" class="btn btn-primary">Create U of M</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="uofm-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>U of M Code</th>
            <th>Description</th>
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
        $('#uofm-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('uofm_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'Excel',
                    filename: "os_categories_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'CSV',
                    filename: "os_categories_csv"
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
                { data: 'description' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/os/uofm/'+full.id+'" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/os/uofm/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush