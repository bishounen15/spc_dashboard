@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>Packaging Transactions</h3>
    <a href="/mes/packaging/create" role="button" class="btn btn-primary">Create Packing List</a>
    <br><br>
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Start Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                    
                    <label class="my-1 mr-2" for="end">End Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="end" id="end" value="{{ date('Y-m-d') }}">        
                    
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="pack-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th width="15%">Pallet No.</th>
            <th width="10%">Registration</th>
            <th width="10%">Customer</th>
            <th width="15%">Product No.</th>
            <th width="15%">Model Name</th>
            <th width="10%">Total Modules</th>
            <th width="25%">Actions</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>

    <div class="modal fade" id="serial-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Serial List</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="trx-id">
                <table class="table table-sm" style="font-size: 0.9em;">
                    <tr>
                        <th>Pallet No.</th><td id="PALLETNO"></td><th>Customer</th><td id="CUSTOMER"></td>
                    </tr>
                    <tr>
                        <th>Product No.</th><td id="PRODUCTNO"></td><th>Model Name</th><td id="MODELNAME"></td>
                    </tr>
                </table>

                <table class="table table-condensed table-striped table-sm" style="width: 100%;">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        <th width="40%">Serial No.</th>
                        <th width="40%">Model Name</th>
                        <th width="20%">Bin</th>
                    </thead>
                    <tbody id="serial-details" class="tbody-light" style="font-size: 0.75em;">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="btnClose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="width: 100px;">Close</button>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.modal')
@push('jscript')
<script>
    $(document).on("click",".view-details", function() {
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('transaction_id', $(this).attr("id"));

        $.ajax({
            url: "{{route('packing_trx_info')}}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (trx) {
                $('table .stock').show();

                $("#PALLETNO").html(trx[0].PALLETNO);
                $("#CUSTOMER").html(trx[0].CUSTOMER);
                $("#PRODUCTNO").html(trx[0].PRODUCTNO);
                $("#MODELNAME").html(trx[0].MODELNAME);
                myRows = "";

                $.each(trx, function(i, v) {
                    if (trx[0].MODELNAME != v.MODEL) {
                        rowClass = ' class="table-danger"';
                    } else {
                        rowClass = '';
                    }
                    myRows += '<tr'+rowClass+'><td>'+v.SERIALNO+'</td><td>'+v.MODEL+'</td><td>'+v.BIN+'</td></tr>';
                });

                $("#serial-details").html(myRows);
                
                $("#serial-modal").modal("toggle");
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    });

    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/mes/packaging/data/' + $('#start').val() + '/' + $('#end').val() ).load();
        });

        var table = $('#pack-list').DataTable({
            // "scrollX": true,
            "order": [],
            processing: true,
            ajax: '/mes/packaging/data/' + $('#start').val() + '/' + $('#end').val(),
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    },
                    text:       'Excel',
                    filename: "packaging_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    },
                    text:       'CSV',
                    filename: "packaging_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                // { data: 'PALLETNO' },
                { sortable: true, "render": function ( data, type, full, meta ) {
                    return '<a href="#" id="'+full.ROWID+'" class="view-details">'+full.PALLETNO+'</a>';
                }},
                { data: 'REGISTRATION' },
                { data: 'CUSTOMER' },
                { data: 'PRODUCTNO' },
                { data: 'MODELNAME' },
                { data: 'TOTALMODS' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/mes/packaging/export/'+full.ROWID+'" role="button" class="btn btn-sm btn-success" style="width: 100%;">Download</a></div><div class="col-sm-6"><a href="#" data-href="/mes/packaging/'+full.ROWID+'" role="button" class="btn btn-sm btn-danger{{ Auth::user()->sysadmin != 1 ? " disabled" : "" }}" data-toggle="modal" data-target="#confirm-delete" id="'+full.PALLETNO+'" style="width: 100%;">Release</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush