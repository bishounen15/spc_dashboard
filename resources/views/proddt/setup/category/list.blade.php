@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Category Master</h3>
    <a href="/proddt/setup/category/create" role="button" class="btn btn-primary">Create Category</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="category-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Code</th>
            <th>Description</th>
            <th>Color Scheme</th>
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
        $('#category-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('dtcategory_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'Excel',
                    filename: "categories_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'CSV',
                    filename: "categories_csv"
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
                { data: 'color_scheme' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/proddt/setup/category/'+full.id+'/edit" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/proddt/setup/category/destroy/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
            createdRow: function (row, data, index) {
                //
                // if the second column cell is blank apply special formatting
                //
                $(row).addClass('table-' + data.color_scheme);
            },
        });
    });
</script>
@endpush