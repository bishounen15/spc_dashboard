@extends('layouts.app')
@section('content')
@php
    $planner = (Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1);
@endphp
<div class="container-fluid">
    <h3><i class="fas fa-tasks"></i> TRINA Work Order</h3>
    <table class="table table-condensed table-striped table-sm" id="wo-list" style="width: 100%;">
        <thead class="thead-dark">
            <th>Work Order ID</th>
            <th>Version</th>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Cell Supplier</th>
            <th>Module Color</th>
            <th>Is Bonded</th>
            <th class="text-center">State</th>
        </thead>
        <tbody class="tbody-light">
            
        </tbody>
    </table>

    <div class="modal fade" id="ToggleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><strong>Change State</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really want to change the state of Work Order [<span id="woid" class="text-danger"></span>] to <strong><span id="wostate"></span></strong>?</p>
                <div class="form-row">
                <label for="remarks">Reason for change<span id="isoption"></span></label>
                <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="4"></textarea>
                <small class="form-text text-danger" id="err_remarks"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="SaveButton">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    var table
    var planner = {{ Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1 ? 'true' : 'false' }};

    $(document).on("click",".toggle-wo", function() {
        $("#woid").html($(this).attr('id'));
        $("#remarks").val("");
        if ($(this).html() == "Open") {
            $("#wostate").html("Close").addClass("text-danger").removeClass("text-success");
        } else {
            $("#wostate").html("Open").removeClass("text-danger").addClass("text-success");
        }
    });

    $(document).on("click","#SaveButton", function() {
        if ($("#remarks").val() != "") {
            toggleState($("#woid").html());
        } else {
            $("#err_remarks").html("Reason is required.");
        }
    });

    function toggleState(wo) {
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('remarks', $("#remarks").val());

        $.ajax({
            url: '/trina/wo/toggle/'+wo,
            method: 'post',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (dt) {
                table.ajax.url('/trina/wo/load').load();
                $("#ToggleModal").modal('toggle');
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    }

    $(document).ready(function() {
        table = $('#wo-list').DataTable({
            "scrollX": true,
            "stateSave": true,
            processing: true,
            // serverSide: true,
            "order": [],
            ajax: '/trina/wo/load',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_wo_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_wo_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { sortable: true, "render": function ( data, type, full, meta ) {
                    return '<a href="/trina/workorder/'+full.WorkOrder_ID+'/'+full.WorkOrder_vertion+'">'+full.WorkOrder_ID+'</a>';
                }},
                { data: 'WorkOrder_vertion' },
                { data: 'OrderID' },
                { data: 'Product_ID' },
                { data: 'Product_Type' },
                { data: 'Cell_Suppliers' },
                { data: 'Module_Colour' },
                { data: 'IsBonded' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    if (full.State == "Open") {
                        cls = "btn-success";
                    } else {
                        cls = "btn-danger";
                    }

                    if (planner) {
                        return '<div class="text-center"><button class="btn btn-sm '+cls+' toggle-wo" id="'+full.WorkOrder_ID+'/'+full.WorkOrder_vertion+'" title="Click button to change state" data-toggle="modal" data-target="#ToggleModal">'+full.State+'</button></div>';
                    } else {
                        return '<div class="text-center">'+full.State+'</div>';
                    }
                }, 
                },
            ],
            createdRow: function (row, data, index) {
                if (data.State == "Open") {
                    $(row).addClass('table-success');
                } else {
                    $(row).addClass('table-danger');
                }
            },
        });
    });
</script>
@endpush