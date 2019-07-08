@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>
        <i class="fas fa-edit"></i> Update Module Information
    </h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <strong>Enter Parameters</strong>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="param-input" id="sno" value="sno" checked>
                            <label for="pallet" class="form-check-label"><strong>Individual Filter</strong></label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="param-input" id="range" value="range">
                            <label for="date" class="form-check-label"><strong>Ranged Filter</strong></label>
                        </div>
                    </div>

                    <div id="grp-pallet">
                        <div class="form-group">
                            <label class="my-1 mr-2" for="serialno">Enter Serial Numbers (separated by comma[,])</label>
                            <textarea class="form-control form-control-sm" name="serialno" id="serialno" rows="5"></textarea>
                        </div>
                    </div>

                    <div id="grp-date" style="display: none;">
                        <div class="form-group">
                            <label class="my-1 mr-2" for="start">Start Serial Number</label>
                            <input type="text" class="form-control form-control-sm" name="start" id="start">
                        </div>

                        <div class="form-group">
                            <label class="my-1 mr-2" for="end">End Serial Number</label>
                            <input type="text" class="form-control form-control-sm" name="end" id="end">
                        </div>

                    </div>
                </div>
                <div class="card card-footer p-2">
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton"><i class="fas fa-sync"></i> Refresh Report</button>
                    <hr class="m-1">
                    <button type="submit" class="btn btn-info my-1" id="UpdateButton" disabled><i class="fas fa-pen-square"></i> Update Information</button>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <strong>Module Information Results</strong>
                </div>

                <table class="table table-sm table-condensed table-striped" id="ftd-list">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        <th>Work Order ID</th>
                        <th>Version</th>
                        <th>Module ID</th>
                        <th>Product Type</th>
                        <th>Module Color</th>
                        <th>Cell Supplier</th>
                        <th>Grade of Cell Power</th>
                        <th>Cell Power</th>
                        <th>Cell Color</th>
                        <th>Eff.</th>
                        <th>Module Grade</th>
                        <th>EL Grade</th>
                        <th>Status</th>
                        <th>Power Grade</th>
                        <th>Nameplate Type</th>
                        <th>Operation</th>
                    </thead>
                    <tbody style="font-size: 0.7em;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white"><strong>Update Information</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="jumbotron p-3 bg-danger text-center text-white" style="display: none;">
                    <h3 class="display-6" id="warn-msg">Please ensure that all modules are of the same Work Order when updating EFFICIENCY and CELL COLOR</h1>
                </div>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Change Efficiency</strong>
                    </div>
                    <div class="col-sm-5">
                        <select name="EFF" id="EFF" class="form-control form-control-sm update-fields"></select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Change Cell Color</strong>
                    </div>
                    <div class="col-sm-5">
                        <select name="Module_Colour" id="Module_Colour" class="form-control form-control-sm update-fields"></select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Change Status</strong>
                    </div>
                    <div class="col-sm-5">
                        <select name="Status" id="Status" class="form-control form-control-sm update-fields">
                            <option readonly selected value> -- select an option -- </option>
                            <option value="-"></option>
                            <option value="Pass">Pass</option>
                            <option value="Hold">Hold</option>
                            <option value="Release">Release</option>
                        </select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Change Module Grade</strong>
                    </div>
                    <div class="col-sm-5">
                        <select name="Module_Grade" id="Module_Grade" class="form-control form-control-sm update-fields">
                            <option readonly selected value> -- select an option -- </option>
                            <option value="-"></option>
                            <option value="Q1">Q1</option>
                            <option value="Q2">Q2</option>
                        </select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Change EL Grade</strong>
                    </div>
                    <div class="col-sm-5">
                        <select name="EL_Grade" id="EL_Grade" class="form-control form-control-sm update-fields">
                            <option readonly selected value> -- select an option -- </option>
                            <option value="-"></option>
                            <option value="Q1">Q1</option>
                            <option value="Q2">Q2</option>
                        </select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Change Current Operation</strong>
                    </div>
                    <div class="col-sm-5">
                        <select name="OPNO" id="OPNO" class="form-control form-control-sm update-fields">
                            <option readonly selected value> -- select an option -- </option>
                            @foreach($operations as $operation)
                            <option value="{{ $operation->opno }}">{{ $operation->opno . ' - ' . $operation->opname . ' (' . $operation->ch_name . ')' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Requested By</strong>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="requestor" id="requestor" class="form-control form-control-sm update-fields">
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-sm-5 text-right">
                        <strong>Reason for Update</strong>
                    </div>
                    <div class="col-sm-5">
                        <textarea name="reason" id="reason" class="form-control form-control-sm update-fields" rows="4"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="SaveButton">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        $(document).ajaxStart(function () {  
            $("#RefreshButton").html("Loading Report...");
            $("#RefreshButton").attr("disabled", true);
        });  

        $(document).ajaxStop(function () {  
            $("#RefreshButton").html('<i class="fas fa-sync"></i> Refresh Report');
            $("#RefreshButton").attr("disabled", false);
        });

        $('input[name^="param-input"]').change(function() {
            if ($(this).is(':checked') === true) {
                if ($(this).attr('id') === 'sno') {
                    $("#grp-pallet").show();
                    $("#grp-date").hide();
                } else {
                    $("#grp-date").show();
                    $("#grp-pallet").hide();
                }
            }
        });

        $("#UpdateButton").click(function () {
            $(".update-fields").val("");

            $("#UpdateModal").modal("toggle");
        });

        $(".update-fields").change(function () {
            if ($("#EFF").val() != "" || $("#Module_Colour").val() != "") {
                $(".jumbotron").show();
            } else {
                $(".jumbotron").hide();
            }
        });

        $("#SaveButton").click(function () {
            if ($("#requestor").val() != "" && $("#reason").val() != "") {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('serialno', $("#serialno").val());
                formData.append('start', $("#start").val());
                formData.append('end', $("#end").val());
                formData.append('param', $('input[name="param-input"]:checked').val());
                
                formData.append('EFF', $("#EFF").val());
                formData.append('Module_Colour', $("#Module_Colour").val());
                formData.append('Status', $("#Status").val());
                formData.append('Module_Grade', $("#Module_Grade").val());
                formData.append('EL_Grade', $("#EL_Grade").val());
                formData.append('OPNO', $("#OPNO").val());

                formData.append('requestor', $("#requestor").val());
                formData.append('reason', $("#reason").val());

                $.ajax({
                    url: '/trina/moduleupdate',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        if (dt.main_result >= 0 || dt.optn_result >= 0) {
                            mr = (dt.main_result >= 0 ? dt.main_result + " row/s updated for Module Information" : "");
                            or = (dt.optn_result >= 0 ? dt.optn_result + " row/s updated for Current Operation" : "");
                            sp = (dt.main_result >= 0 && dt.optn_result >= 0 ? " and " : "")
                            alert(mr + sp + or + ".");
                            $("#UpdateModal").modal('toggle');
                        } else {
                            alert("You have not selected any field to update.");
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
            } else {
                alert("Requestor and Reason are required!");
            }
        });

        $('#UpdateModal').on('hidden.bs.modal', function () {
			$("#RefreshButton").click();
		});

        $("#RefreshButton").click(function() {
            var type = $('input[name="param-input"]:checked').val();
            
            if (type == "sno" && ($("#serialno").val() == null || $("#serialno").val() == '')) {
                alert("Please enter Serial Number/(s)");
            } else if (type == "range" && (($("#start").val() == null || $("#start").val() == '') || ($("#end").val() == null || $("#end").val() == ''))) {
                alert("Start / End Serial Number should not be empty.");
            } else {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('serialno', $("#serialno").val());
                formData.append('start', $("#start").val());
                formData.append('end', $("#end").val());
                formData.append('param', $('input[name="param-input"]:checked').val());
                
                var tbl = $('#ftd-table').DataTable();
                tbl.clear().draw();

                $.ajax({
                    url: '/trina/listmodules',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        if (dt.mods.length > 0) {
                            $('#UpdateButton').attr('disabled',false);
                            
                            eff_list = "<option readonly selected value> -- select an option -- </option>";
                            $.each(dt.eff, function(i, obj){
                                eff_list += '<option value="'+obj.CODE+'">'+obj.DESCR+'</option>';
                            });

                            $("#EFF").html(eff_list);

                            clr_list = "<option readonly selected value> -- select an option -- </option>";
                            $.each(dt.clr, function(i, obj){
                                clr_list += '<option value="'+obj.CODE+'">'+obj.DESCR+'</option>';
                            });

                            $("#Module_Colour").html(clr_list);
                        } else {
                            $('#UpdateButton').attr('disabled',true);
                        }

                        table.dataTable().fnDestroy();

                        table.DataTable({
                            "scrollX": true,
                            processing: true,
                            "searching": false,
                            "order": [],
                            data: dt.mods,
                            dom: 'Blfrtip',
                            buttons: [
                                {
                                    extend:     'csv',
                                    exportOptions: {
                                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ]
                                    },
                                    text:       'Download CSV',
                                    filename: "modules_csv"
                                },
                            ],
                            columns: [
                                // { data: 'id' },
                                { data: 'WorkOrder_ID' },
                                { data: 'WorkOrder_vertion' },
                                { data: 'Module_ID' },
                                { data: 'Product_Type' },
                                { data: 'Module_Colour' },
                                { data: 'Cell_Suppliers' },
                                { data: 'Grade_of_Cell_Power' },
                                { data: 'Cell_Power' },
                                { data: 'Cell_Color' },
                                { data: 'EFF' },
                                { data: 'Module_Grade' },
                                { data: 'EL_Grade' },
                                { data: 'Status' },
                                { data: 'POWER_GRADE' },
                                { data: 'NAMEPLATE_Type' },
                                { data: 'Operation' },
                            ],
                            createdRow: function (row, data, index) {
                                // console.log(data.Module_ID + " [" + data.Module_Grade + " - " + data.EL_Grade + "]");
                                if (data.Module_Grade == data.EL_Grade && data.Module_Grade == 'Q1') {
                                    $(row).addClass('table-success');
                                } else {
                                    $(row).addClass('table-warning');
                                }

                                if (data.Status != "Pass") {
                                    $(row).addClass('text-danger');
                                }
                            },
                        });
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
            }
        });

        var table = $('#ftd-list');
        table.DataTable({
            "scrollX": true,
            processing: true,
            "searching": false,
            "order": [],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ]
                    },
                    text:       'Download CSV',
                    filename: "modules_csv"
                },
            ],
            columns: [
                // { data: 'id' },
                { data: 'WorkOrder_ID' },
                { data: 'WorkOrder_vertion' },
                { data: 'Module_ID' },
                { data: 'Product_Type' },
                { data: 'Module_Colour' },
                { data: 'Cell_Suppliers' },
                { data: 'Grade_of_Cell_Power' },
                { data: 'Cell_Power' },
                { data: 'Cell_Color' },
                { data: 'EFF' },
                { data: 'Module_Grade' },
                { data: 'EL_Grade' },
                { data: 'Status' },
                { data: 'POWER_GRADE' },
                { data: 'NAMEPLATE_Type' },
                { data: 'Operation' },
            ],
        });
    });
</script>
@endpush