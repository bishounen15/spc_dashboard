@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA Module Inquiry</h3>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <label for="sno">Scan Serial No.</label>
                        <input type="text" class="form-control form-control-sm" name="sno" id="sno">
                        <small class="form-text text-danger" id="err_sno"></small>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>Module Information</strong></div>
                <div class="card-body">
                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Module_ID">Module ID</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Module_ID" id="Module_ID" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="OrderID">Order ID</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="OrderID" id="OrderID" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="WorkOrder_ID">Work Order ID</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="WorkOrder_ID" id="WorkOrder_ID" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="WorkOrder_vertion">WO Version</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="WorkOrder_vertion" id="WorkOrder_vertion" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Product_ID">Product ID</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Product_ID" id="Product_ID" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Product_Type">Product Type</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Product_Type" id="Product_Type" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Module_Grade">Module Grade</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Module_Grade" id="Module_Grade" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="EL_Grade">EL Grade</label>
                        </div>
                        <div class="col-sm-7">
                            @if(Auth::user()->mes_role != 'QUAL' && Auth::user()->sysadmin != 1)
                            <input type="text" class="form-control form-control-sm" name="EL_Grade" id="EL_Grade" readonly>
                            @else
                            @php
                                $status = ['', 'Q1', 'Q2'];
                            @endphp
                            <input type="hidden" id="origStatus" name="origStatus" value="">
                            <select class="form-control form-control-sm" name="EL_Grade" id="EL_Grade">
                                @foreach ($status as $stat)
                                <option value="{{$stat}}">{{$stat}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Status">Status</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Status" id="Status" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Operation">Current Operation</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Operation" id="Operation" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="LabelDate">Date Serial Printed</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="LabelDate" id="LabelDate" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        @if(Auth::user()->mes_role == 'QUAL' || Auth::user()->sysadmin == 1)
                            <button class="btn btn-sm btn-block btn-info" disabled="disabled" id="UpdateEL">Update EL Grade</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <strong>Transaction Details</strong>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-header text-white bg-success" id="string-card">Cell Sizing</div>
                        <div class="card-body" id="string-body">
                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="StringDate">Cell Sizing Date</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="StringDate" id="StringDate" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="CellLot">Cell Box Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="CellLot" id="CellLot" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="layup-card">Layup Info</div>
                        <div class="card-body" id="layup-body">
                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="LayupDate">Layup Date</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="LayupDate" id="LayupDate" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="Backsheet_lot">Backsheet Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="Backsheet_lot" id="Backsheet_lot" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="EVA_lot">1st EVA Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="EVA_lot" id="EVA_lot" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="OrdinaryEVA_lot">2nd EVA Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="OrdinaryEVA_lot" id="OrdinaryEVA_lot" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="Glass_lot">Glass Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="Glass_lot" id="Glass_lot" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="frame-card">Frameup Info</div>
                        <div class="card-body" id="frame-body">
                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="FrameUpDate">Frameup Date</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="FrameUpDate" id="FrameUpDate" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="frame_lot">Long Frame Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="frame_lot" id="frame_lot" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="ShortFrame_lot">Short Frame Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="ShortFrame_lot" id="ShortFrame_lot" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="JBOX_lot">JBOX Lot Number</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="JBOX_lot" id="JBOX_lot" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="clean-card">Cleaning</div>
                        <div class="card-body" id="clean-body">
                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="CleaningHoldDate">Hold Date</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="CleaningHoldDate" id="CleaningHoldDate" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="iv-card">IV Test</div>
                        <div class="card-body" id="iv-body">
                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="Testdate">Test Date</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="Testdate" id="Testdate" readonly>
                                </div>
                            </div>
                            
                            <table class="table table-sm table-condensed">
                                <thead class="thead-dark" style="font-size: 0.7em;">
                                    <th width="10%" class="text-center">PMAX</th>
                                    <th width="10%" class="text-center">VOC</th>
                                    <th width="10%" class="text-center">ISC</th>
                                    <th width="10%" class="text-center">VPM</th>
                                    <th width="10%" class="text-center">IPM</th>
                                    <th width="10%" class="text-center">RS</th>
                                    <th width="10%" class="text-center">RSH</th>
                                    <th width="10%" class="text-center">FF</th>
                                    <th width="10%" class="text-center">EnvTemp</th>
                                    <th width="10%" class="text-center">SurfTemp</th>
                                </thead>
                                <tbody>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="PMAX" name="PMAX" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="VOC" name="VOC" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="ISC" name="ISC" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="VPM" name="VPM" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="IPM" name="IPM" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="RS" name="RS" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="RSH" name="RSH" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="FF" name="FF" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="EnvTemp" name="EnvTemp" readonly></div></td>
                                    <td><div class="form-group"><input type="text" class="form-control form-control-sm" id="SurfTemp" name="SurfTemp" readonly></div></td>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="el-card">EL</div>
                        <div class="card-body" id="el-body">
                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="ELTIME">EL Date</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="ELTIME" id="ELTIME" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label>EL Image</label>
                                </div>
                                <div class="col-sm-8">
                                    <a href="#" id="ELPath">...</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="qa-card">QA Pass</div>
                        <div class="card-body" id="qa-body">
                            <div class="form-row mb-1">
                                <div class="col-sm-4">
                                    <label for="QCPassDate">QC Pass Date</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="QCPassDate" id="QCPassDate" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="np-card">Nameplate Printing</div>
                        <div class="card-body" id="np-body">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="NPOnlineDate">Online Print Date</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="NPOnlineDate" id="NPOnlineDate" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="Product">Product Template</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="Product" id="Product" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="Qlevel">Quality Level</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="Qlevel" id="Qlevel" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm">
                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="LastReprintDate">Last Reprint Date</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="LastReprintDate" id="LastReprintDate" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="TotalReprints">Total Reprints</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="TotalReprints" id="TotalReprints" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="card">
                        <div class="card-header text-white bg-success" id="pack-card">Packaging / Container</div>
                        <div class="card-body" id="pack-body">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="Packing_Date">Packing Date</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="Packing_Date" id="Packing_Date" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="Carton_No">Carton Number</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="Carton_No" id="Carton_No" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="PackingState">Packing State</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="PackingState" id="PackingState" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm">
                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="ContainerDate">Container Date</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="ContainerDate" id="ContainerDate" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row mb-1">
                                        <div class="col-sm-4">
                                            <label for="Container_no">Container Number</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="Container_no" id="Container_no" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ELModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><strong>Update EL Grade</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    You are about to change the EL Grade of [<span id="moduleid" class="text-danger"></span>] <br> 
                    from <strong>'<span id="origStat"></span>'</strong> to <strong>'<span id="newStat"></span>'</strong>?<br><br>
                    Press YES to proceed.
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="SaveButton">Yes</button>
                <button type="button" class="btn btn-secondary" id="CancelButton" data-dismiss="modal">No</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    function toggleClass(oField, cHead, cBody) {
        if (oField == null) {
            $("#" + cHead).removeClass("bg-success").addClass("bg-danger");
            $("#" + cBody).hide();
        } else {
            $("#" + cHead).removeClass("bg-danger").addClass("bg-success");
            $("#" + cBody).show();
        }
    }

    $(document).ready(function() {
        $("#sno").focus();

        $("#EL_Grade").change(function() {
            if ($(this).val() != $("#origStatus").val()) {
                $("#UpdateEL").attr("disabled", false);
            } else {
                $("#UpdateEL").attr("disabled", true);
            }
        });

        $("#UpdateEL").click(function() {
            $("#moduleid").html( $("#Module_ID").val() );
            $("#origStat").html( $("#origStatus").val() );
            $("#newStat").html( $("#EL_Grade").val() );
            $("#ELModal").modal('toggle');
        });

        $("#CancelButton").click(function() {
            $("#EL_Grade").val( $("#origStatus").val() );
        });

        $("#SaveButton").click(function() {
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('Module_ID', $("#Module_ID").val());
            formData.append('EL_Grade', $("#EL_Grade").val());
            
            $.ajax({
                url: '/trina/updateEL',
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (dt) {
                    $("#ELModal").modal("toggle");
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        });

        $("#sno").keypress(function (e) {
			var key = e.which;
			var serialno = $(this).val();
			if(key == 13) {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('Module_ID', serialno);
                
                $.ajax({
                    url: '/trina/inquire',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        if (dt[0] != undefined) {
                            $.each(dt[0], function(i, v) {
                                if (i == "ELPath") {
                                    $("#" + i).html(v);
                                    $("#" + i).attr("href",v);
                                } else if (i == "EL_Grade") {
                                    $("#origStatus").val(v);
                                    $("#" + i).val(v);
                                } else {
                                    $("#" + i).val(v);
                                }
                            });

                            toggleClass(dt[0].StringDate,"string-card","string-body");
                            toggleClass(dt[0].LayupDate,"layup-card","layup-body");
                            toggleClass(dt[0].FrameUpDate,"frame-card","frame-body");
                            toggleClass(dt[0].CleaningHoldDate,"clean-card","clean-body");
                            toggleClass(dt[0].Testdate,"iv-card","iv-body");
                            toggleClass(dt[0].ELTIME,"el-card","el-body");
                            toggleClass(dt[0].QCPassDate,"qa-card","qa-body");

                            if (dt[0].NPOnlineDate == null && dt[0].LastReprintDate == null) {
                                hidenp = null;
                            } else {
                                hidenp = 0;
                            }

                            toggleClass(hidenp,"np-card","np-body");

                            if (dt[0].Packing_Date == null && dt[0].ContainerDate == null) {
                                hidepack = null;
                            } else {
                                hidepack = 0;
                            }

                            toggleClass(hidepack,"pack-card","pack-body");

                            $("#err_sno").html("");
                        } else {
                            toggleClass(null,"string-card","string-body");
                            toggleClass(null,"layup-card","layup-body");
                            toggleClass(null,"frame-card","frame-body");
                            toggleClass(null,"clean-card","clean-body");
                            toggleClass(null,"iv-card","iv-body");
                            toggleClass(null,"el-card","el-body");
                            toggleClass(null,"qa-card","qa-body");
                            toggleClass(null,"np-card","np-body");
                            toggleClass(null,"pack-card","pack-body");

                            $("#err_sno").html("Module ID [" + serialno + "] does not exists.");
                            $(".form-control").val("");
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
				 
				 $(this).val("");
			}
		});
    });
</script>
@endpush