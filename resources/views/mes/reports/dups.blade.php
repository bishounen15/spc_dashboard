@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>MES Duplicate Transactions</h3>
    <div class="card mb-3">
        <div class="card-body">
            <div class="form-inline">
                <label class="my-1 mr-2" for="start">Start Date</label>
                <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                
                <label class="my-1 mr-2" for="end">End Date</label>
                <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="end" id="end" value="{{ date('Y-m-d') }}">        
                
                <label class="my-1 mr-2" for="LOCNCODE">Location</label>
                <select class="form-control form-control-sm my-1 mr-sm-2" name="LOCNCODE" id="LOCNCODE">
                    @foreach ($locs as $loc)
                        <option value="{{$loc->STNCODE}}">{{$loc->STNCODE}}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
                <button type="submit" class="btn btn-danger ml-3" id="RemoveDups">Remove Duplicates</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-sm" id="dup-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <th>#</th>
            <th>Serial Number</th>
            <th>Location</th>
            <th>Line</th>
            <th>Date</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Next Location</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>    
</div>    
@endsection

@push('jscript')
<script>
    selectedTrxn = [];

    function checkLoc(cLoc, myLoc) {
        if (myLoc != null) {
            loc = myLoc.split(":");

            if (cLoc == loc[0]) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function selectTrxn(tid) {
        if (selectedTrxn.includes(tid)) {
            selectedTrxn.pop(tid);
        } else {
            selectedTrxn.push(tid);
        }

        console.log(selectedTrxn);
    }

    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/mes/duplicates/' + $('#start').val() + '/' + $('#end').val() + '/' + $('#LOCNCODE').val() ).load();
        });

        var table = $('#dup-list').DataTable({
            // "scrollX": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/mes/duplicates/' + $('#start').val() + '/' + $('#end').val() + '/' + $('#LOCNCODE').val(),
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    text:       'Excel',
                    filename: "MES_Duplicates_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    text:       'CSV',
                    filename: "MES_Duplicates_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'ROWID' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    isDisabled = (!checkLoc(full.LOCNCODE,full.NEXT_LOC) ? " disabled" : "");
                    return '<div class="form-check"><input class="form-check-input" type="checkbox" value="'+full.ROWID+'" name="selected_records[]" id="'+full.ROWID+'"'+isDisabled+'></div>';
                }},
                { data: 'SERIALNO' },
                { data: 'LOCNCODE' },
                { data: 'PRODLINE' },
                { data: 'TRXDATE' },
                { data: 'TRXUID' },
                { data: 'USERNAME' },
                { data: 'NEXT_LOC' },
            ],
            createdRow: function (row, data, index) {
                if (checkLoc(data.LOCNCODE, data.NEXT_LOC)) {
                    $(row).addClass('table-danger');
                } 
            },
        });
    });
</script>
@endpush