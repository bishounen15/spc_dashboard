@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Downtime Monitoring Log Sheet</h3>
    <a href="/proddt/logsheet/create" role="button" class="btn btn-primary">Create Log Entry</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="logsheet-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th width="8%">Date</th>
            <th width="5%">Shift</th>
            <th width="7%">Station</th>
            <th width="8%">Time Start</th>
            <th width="8%">Time End</th>
            <th width="5%">Duration</th>
            <th width="14%">Issues</th>
            <th width="10%">Category</th>
            <th width="10%">Remarks</th>
            <th width="10%">Encoded by</th>
            <th width="15%">Actions</th>
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
        $('#logsheet-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('logsheet_data') !!}',
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
                { data: 'date' },
                { data: 'shift' },
                { data: 'station' },
                { data: 'start' },
                { data: 'end' },
                { data: 'duration' },
                { data: 'issue' },
                { data: 'category' },
                { data: 'remarks' },
                { data: 'user' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/proddt/logsheet/'+full.id+'/edit" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/proddt/logsheet/destroy/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush