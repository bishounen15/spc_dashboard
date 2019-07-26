@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Production Schedule Master</h3>
    @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
    <a href="/planning/schedule/create" role="button" class="btn btn-primary">Create Schedule</a>
    <br><br>
    @endif
    <table class="table table-condensed table-striped table-sm" id="sched-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Date</th>
            <th>WW</th>
            <th></th>
            <th>Qty</th>
            @foreach($lines as $line)
            <th>{{$line->LINDESC}}</th>
            @endforeach
            <th>Activity</th>
            <th>Cell</th>
            <th>Backsheet</th>
            <th>Shifts</th>
            @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
            <th>Actions</th>
            @endif
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
        $('#sched-list').DataTable({
            // "scrollX": true,
            "stateSave": true,
            "order": [],
            ajax: '{!! route('sched_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                    },
                    text:       'Excel',
                    filename: "production_schedule_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                    },
                    text:       'CSV',
                    filename: "production_schedule_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'production_date' },
                { data: 'work_week' },
                { data: 'weekday' },
                { data: 'qty' },
                @foreach($lines as $line)
                { data: 'line_{!! $line->LINCODE !!}' },
                @endforeach
                { data: 'activity' },
                { data: 'cell' },
                { data: 'backsheet' },
                { data: 'shifts' },
                @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
                { sortable: false, "render": function ( data, type, full, meta ) {
                    var d = "{{date('Y-m-d')}}";
                    
                    if (d > full.production_date) {
                        
                        editable = " disabled";
                    } else {
                        editable = "";
                    }

                    return '<a href="/planning/schedule/'+full.id+'/edit" role="button" class="btn btn-sm btn-success'+editable+'" style="width: 100%;">Edit</a>';
                }},
                @endif
            ],
        });
    });
</script>
@endpush