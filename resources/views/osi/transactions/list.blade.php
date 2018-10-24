@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    @csrf
    <h3>Office Supplies Inventory</h3>
    @if(Auth::user()->osi_role == "CUST" || Auth::user()->sysadmin == 1)
    <a href="{{route('create_trx',['Incoming'])}}" role="button" class="btn btn-success" style="width: 200px;">Incoming Transaction</a>
    @endif
    <a href="{{route('create_trx',['Request'])}}" role="button" class="btn btn-info" style="width: 200px;">Request Office Supplies</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="trx-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Control No.</th>
            <th>Type</th>
            <th>User</th>
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
                        <th width="15%" class="stock">Stock</th>
                        <th width="10%"><span id="trx-label"></span> Qty</th>
                        <th width="10%">Unit Cost</th>
                        <th width="10%">Total Cost</th>
                    </thead>
                    <tbody id="item-details" class="tbody-light" style="font-size: 0.75em;">
                        
                    </tbody>
                </table>

                <div class="form-group" id="group-remarks">
                    <label for="remarks">Remarks (Optional)</label>
                    <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="3"></textarea>
                    <small class="form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnEdit" type="button" class="btn btn-info btn-sm" style="width: 100px;" disabled>Edit</button>
                <button id="btnRelease" type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="updateStatus()">For Release</button>
                <button id="btnIssue" type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="updateStatus()">Issue</button>
                <button id="btnSubmit" type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="updateStatus()">Submit</button>
                <button id="btnClose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="width: 100px;">Close</button>
            </div>
          </div>
        </div>
    </div>
{{-- </div> --}}
@endsection

@include('layouts.modal')
@push('jscript')
<script>
    var table;

    function updateStatus() {
        // console.log($('input[name="qty[]"]').eq(0).val());
        id = $("#trx-id").val();
        cno = $("#cno").html();
        status = $("#stat").html();

        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('transaction_id', id);
        formData.append('status', status);

        if ($('input[name="qty[]"]').eq(0).val() != undefined) {
            qty = [];
            cost = [];
            id = [];

            $.each($('input[name^="qty"]'), function() {
                i = $('input[name="qty[]"]').index(this);
                qty.push($(this).val());
                cost.push($('input[name="total-cost[]"]').eq(i).val());
                id.push($('input[name="recid[]"]').eq(i).val());
            });

            formData.append('qty', qty);
            formData.append('total-cost', cost);
            formData.append('trxid', id);
            formData.append('remarks', $('textarea[name="remarks"]').val());
        }

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
                // console.log(result);
                table.ajax.reload();
                $("#sys-messages").html('<div class="alert alert-success" id="success-msg">Transaction ['+ cno +'] successfully updated.</div>');
                $('textarea[name="remarks"]').val("");
                $("#TrxDetails").modal("toggle");
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
                $('table .stock').show();

                $("#trx-id").val(trx[0].id);
                $("#cno").html(trx[0].control_no);
                $("#date").html(trx[0].date);
                $("#type").html(trx[0].type);
                $("#stat").html(trx[0].status);
                myRows = "";

                $.each(trx, function(i, v) {
                    if (trx[0].type == "Request" && trx[0].status == "Submitted" && ("CUST" == "{!! Auth::user()->osi_role !!}" || 1 == {!! Auth::user()->sysadmin !!})) {
                        inputField = '<td><input type="hidden" name="recid[]" value="'+v.trxid+'"><input type="number" class="form-control form-control-sm" name="qty[]" value="'+v.qty+'"></td><td><input type="text" class="form-control form-control-sm" name="unit-cost[]" value="'+v.unit_cost+'" readonly></td><td><input type="text" class="form-control form-control-sm" name="total-cost[]" value="'+ v.total_cost +'" readonly></td>';
                        $("#group-remarks").show();
                    } else {
                        inputField = '<td>'+v.qty+'</td><td>'+v.unit_cost+'</td><td>'+ v.total_cost +'</td>';
                        $("#group-remarks").hide();
                    }
                    
                    myRows += '<tr><td>'+v.category+'</td><td>'+v.item+'</td><td class="stock">'+v.current_stock+'</td>'+inputField+'</tr>';
                });

                $("#item-details").html(myRows);
                
                $("#trx-label").html(trx[0].type);
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

                        $('table .stock').hide();
                    }
                } else if (trx[0].type == "Request") {
                    if (trx[0].status == "Open") {
                        if (trx[0].user_id == {!! Auth::user()->id !!}) {
                            $("#btnSubmit").show();
                            $("#btnEdit").show();
                        } else {
                            $("#btnSubmit").hide();
                            $("#btnEdit").hide();
                        }
                        
                        $("#btnRelease").hide();
                        $("#btnIssue").hide();
                    } else if (trx[0].status == "Submitted") { 
                        $("#btnSubmit").hide();
                        
                        if ("CUST" == "{!! Auth::user()->osi_role !!}" || 1 == {!! Auth::user()->sysadmin !!}) {
                            $("#btnEdit").show();
                            $("#btnRelease").show();
                        } else {
                            $("#btnEdit").hide();
                            $("#btnRelease").hide();
                        }

                        $("#btnIssue").hide();
                    } else if (trx[0].status == "For Release") { 
                        $("#btnSubmit").hide();
                        $("#btnEdit").hide();
                        $("#btnRelease").hide();
                        
                        if ("CUST" == "{!! Auth::user()->osi_role !!}" || 1 == {!! Auth::user()->sysadmin !!}) {
                            $("#btnIssue").show();
                        } else {
                            $("#btnIssue").hide();
                        }
                    } else {
                        $("#btnSubmit").hide();
                        $("#btnEdit").hide();
                        $("#btnRelease").hide();
                        $("#btnIssue").hide();

                        $('table .stock').hide();
                    }
                }

                $('textarea[name="remarks"]').val("");
                $("#TrxDetails").modal("toggle");
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    });

    $(document).on('change', 'input[name="qty[]"]', function(index) {
        i = $('input[name="qty[]"]').index(this);
        $('input[name="total-cost[]"]').eq(i).val(parseFloat( ($('input[name="qty[]"]').eq(i).val()) * parseFloat($('input[name="unit-cost[]"]').eq(i).val())).toFixed(2));
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
                { data: 'name' },
                { data: 'department' },
                { data: 'date' },
                { data: 'status' },
                { data: 'total_cost' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-12"><a href="#" id="'+full.id+'" role="button" class="btn btn-sm btn-success view-details" style="width: 100%;">View Details</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush