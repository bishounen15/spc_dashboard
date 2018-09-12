@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>User Master</h3>
    <table class="table table-condensed table-striped table-sm" id="user-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <tr class="text-center">
                <th rowspan="2" width="10%">ID Number</th>
                <th rowspan="2" width="15%">Name</th>
                <th rowspan="2" width="15%">Department</th>
                <th rowspan="2" width="15%">Email</th>
                <th colspan="3">User Role</th>
                <th rowspan="2" width="25%">Actions</th>
            </tr>
            <tr class="text-center">
                <th width="10%">Office Supplies</th>
                <th width="10%">Yield Dashboard</th>
                <th width="10%">IT Management</th>
            </tr>
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
        $('#user-list').DataTable({
            "scrollX": true,
            "order": [],
            ajax: '{!! route('user_data') !!}',
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
                { data: 'user_id' },
                { data: 'name' },
                { data: 'description' },
                { data: 'email' },
                { sortable: false, data: 'osi_access' },
                { sortable: false, data: 'yield_access' },
                { sortable: false, data: 'assets_access' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/user/'+full.id+'" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/user/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush