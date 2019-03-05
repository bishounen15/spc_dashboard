@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Station Master</h3>
    <a href="/proddt/setup/station/create" role="button" class="btn btn-primary">Create Station</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="station-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th width="15%">Code</th>
            <th width="20%">Description</th>
            <th width="20%">Machine</th>
            <th width="15%">Capacity / Hour</th>
            <th width="10%">Prod. Line</th>
            <th width="20%">Actions</th>
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
        $('#station-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('station_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'Excel',
                    filename: "stations_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
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
                { data: 'machine' },
                { data: 'capacity' },
                { data: 'production_line' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/proddt/setup/station/'+full.id+'/edit" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/proddt/setup/station/destroy/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush