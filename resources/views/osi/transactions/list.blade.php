@extends('layouts.app')
@section('content')
<div class="container">
    @csrf
    <h3>Office Supplies Inventory</h3>
    <a href="{{route('create_trx',['Incoming'])}}" role="button" class="btn btn-success" style="width: 200px;">Incoming Transaction</a>
    <a href="{{route('create_trx',['Request'])}}" role="button" class="btn btn-info" style="width: 200px;">Request Office Supplies</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="trx-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Control No.</th>
            <th>Type</th>
            <th>Department</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total Cost</th>
            <th>-</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>

    <div class="modal fade" id="TrxDetails" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Transaction Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="trx-id">
                <table class="table table-sm" style="font-size: 0.9em;">
                    <tr>
                        <th>Control No.</th><td id="cno"></td><th>Date</th><td id="date"></td>
                    </tr>
                    <tr>
                        <th>Type</th><td id="type"></td><th>Status</th><td id="stat"></td>
                    </tr>
                </table>

                <table class="table table-condensed table-striped table-sm" style="width: 100%;">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        <th width="15%">Category</th>
                        <th width="40%">Item</th>
                        <th width="15%">Qty</th>
                        <th width="15%">Unit Cost</th>
                        <th width="15%">Total Cost</th>
                    </thead>
                    <tbody id="item-details" class="tbody-light" style="font-size: 0.75em;">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="btnEdit" type="button" class="btn btn-info btn-sm" style="width: 100px;">Edit</button>
                <button id="btnRelease" type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="updateStatus()">For Release</button>
                <button id="btnIssue" type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="updateStatus()">Issue</button>
                <button id="btnSubmit" type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="updateStatus()">Submit</button>
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
    var table;

    function updateStatus() {
        id = $("#trx-id").val();
        status = $("#stat").html();

        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('transaction_id', id);
        formData.append('status', status);

        $.ajax({
            url: "{{route('os_status')}}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (result) {
                $("#TrxDetails").modal("toggle");
                table.ajax.reload();
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    }

    $(document).on("click",".view-details", function() {
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('transaction_id', $(this).attr("id"));

        $.ajax({
            url: "{{route('get_trx_info')}}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (trx) {
                // alert(trx);
                
                if (trx[0].type == "Incoming") {
                    if (trx[0].status == "Open") {
                        $("#btnSubmit").show();
                        $("#btnEdit").show();
                        $("#btnRelease").hide();
                        $("#btnIssue").hide();
                    } else {
                        $("#btnSubmit").hide();
                        $("#btnEdit").hide();
                        $("#btnRelease").hide();
                        $("#btnIssue").hide();
                    }
                } else if (trx[0].type == "Request") {
                    if (trx[0].status == "Open") {
                        $("#btnSubmit").show();
                        $("#btnEdit").show();
                        $("#btnRelease").hide();
                        $("#btnIssue").hide();
                    } else if (trx[0].status == "Submitted") { 
                        $("#btnSubmit").hide();
                        $("#btnEdit").show();
                        $("#btnRelease").show();
                        $("#btnIssue").hide();
                    } else if (trx[0].status == "For Release") { 
                        $("#btnSubmit").hide();
                        $("#btnEdit").hide();
                        $("#btnRelease").hide();
                        $("#btnIssue").show();
                    } else {
                        $("#btnSubmit").hide();
                        $("#btnEdit").hide();
                        $("#btnRelease").hide();
                        $("#btnIssue").hide();
                    }
                }

                $("#trx-id").val(trx[0].id);
                $("#cno").html(trx[0].control_no);
                $("#date").html(trx[0].date);
                $("#type").html(trx[0].type);
                $("#stat").html(trx[0].status);
                myRows = "";

                $.each(trx, function(i, v) {
                    myRows += '<tr><td>'+v.category+'</td><td>'+v.item+'</td><td>'+v.qty+'</td><td>'+v.unit_cost+'</td><td>'+v.total_cost+'</td></tr>';
                });

                $("#item-details").html(myRows);
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    });

    $(document).ready(function() {
        table = $('#trx-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('trx_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'Excel',
                    filename: "os_transactions_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'CSV',
                    filename: "os_transactions_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'control_no' },
                { data: 'type' },
                { data: 'department' },
                { data: 'date' },
                { data: 'status' },
                { data: 'total_cost' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-12"><a href="#" id="'+full.id+'" role="button" class="btn btn-sm btn-success view-details" style="width: 100%;" data-toggle="modal" data-target="#TrxDetails">View Details</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush