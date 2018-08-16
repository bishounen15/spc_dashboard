@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Department Master</h3>
    <a href="{{route('create_dept')}}" role="button" class="btn btn-primary">Create Department</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="department-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Department</th>
            <th>Abbreviation</th>
            <th>Cost Center</th>
            <th>Dept. Head</th>
            <th>Email</th>
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
        $('#department-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('dept_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'Excel',
                    filename: "os_categories_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
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
                { data: 'description' },
                { data: 'abbrv' },
                { data: 'cost_center' },
                { data: 'head' },
                { data: 'head_email' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/dept/'+full.id+'" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/dept/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush