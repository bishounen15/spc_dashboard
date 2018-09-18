@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Machine Master</h3>
    <a href="/proddt/setup/machine/create" role="button" class="btn btn-primary">Create Machine</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="machine-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th width="20%">Code</th>
            <th width="30%">Description</th>
            <th width="20%">Capacity / Hour</th>
            <th width="30%">Actions</th>
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
        $('#machine-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('machine_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'Excel',
                    filename: "stations_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'CSV',
                    filename: "stations_csv"
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
                { data: 'capacity' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-4"><a href="/proddt/setup/machine/'+full.id+'/edit" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-4"><a href="/proddt/setup/machine/'+full.id+'/downtime" role="button" class="btn btn-sm btn-primary" style="width: 100%;">Add DT Types</a></div>' +
                           '<div class="col-sm-4"><a href="#" data-href="/proddt/setup/machine/destroy/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush