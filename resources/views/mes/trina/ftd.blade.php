@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3><i class="fas fa-poll"></i> TRINA FTD Report</h3>
    
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Start Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                    
                    <label class="my-1 mr-2" for="end">End Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="end" id="end" value="{{ date('Y-m-d') }}">        
                    
                    <button type="submit" class="btn btn-info my-1" id="FilterButton"><i class="fas fa-filter"></i> Filter Options</button>&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton"><i class="fas fa-sync"></i> Refresh Dashboard</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="ftd-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <th>OBA</th>
            <th>OBA Status</th>
            <th>Work Order ID</th>
            <th>Module ID</th>
            <th>Module Grade</th>
            <th>EL Grade</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Grade of Cell Power</th>
            <th>Cell Power</th>
            <th>Cell Color</th>
            <th>Cell Eff.</th>
            <th>Carton No.</th>
            <th>Packing Date</th>
            <th>Container No.</th>
            <th>Test Date/Time</th>
            <th>Title</th>
            <th>Grade</th>
            <th>PMAX</th>
            <th>FF</th>
            <th>VOC</th>
            <th>ISC</th>
            <th>VPM</th>
            <th>IPM</th>
            <th>RS</th>
            <th>RSH</th>
            <th>Env Temp</th>
            <th>Surf Temp</th>
            <th>Nameplate Type</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>

    <div class="modal fade" id="OBAModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><strong>OBA Judgement</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really want to tag this serial [<span id="moduleid" class="text-danger"></span>] carton no [<span id="cartonno" class="text-danger"></span>] as <strong><span id="judgement" class="text-white p-1"></span></strong>?</p>
                <div class="form-row">
                <label for="remarks">Remarks <span id="isoption"></span></label>
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

    <div class="modal fade" id="FilterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><strong>Filter Results</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FilterParam">
                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Product Type</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                @foreach($product_types as $prodtype)
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{$prodtype->Product_Type}}" name="Product_Type">
                                        <label class="form-check-label" for="Product_Type">
                                            {{$prodtype->Product_Type}}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Work Order ID</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                @foreach($work_orders as $wo)
                                <div class="col-sm-4">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$wo->WorkOrder_ID}}" name="WorkOrder_ID" data-prodtype="{{$wo->Product_Type}}">
                                        <label class="form-check-label" for="Product_Type">
                                            <small>{{$wo->WorkOrder_ID}}</small>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Module Grade</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ModuleGrade" value="All" checked>
                                        <label class="form-check-label" for="ModuleGrade">
                                            All
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ModuleGrade" value="Q1">
                                        <label class="form-check-label" for="ModuleGrade">
                                            Q1
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ModuleGrade" value="Q2">
                                        <label class="form-check-label" for="ModuleGrade">
                                            Q2
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Packing Status</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="PackStatus" value="All" checked>
                                        <label class="form-check-label" for="PackStatus">
                                            All
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="PackStatus" value="Packed">
                                        <label class="form-check-label" for="PackStatus">
                                            Packed
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="PackStatus" value="Not Packed">
                                        <label class="form-check-label" for="PackStatus">
                                            Not Packed
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Shipping Status</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ShipStatus" value="All" checked>
                                        <label class="form-check-label" for="ShipStatus">
                                            All
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ShipStatus" value="Shipped">
                                        <label class="form-check-label" for="ShipStatus">
                                            Shipped
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ShipStatus" value="Not Shipped">
                                        <label class="form-check-label" for="ShipStatus">
                                            Not Shipped
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-block" id="FilterRefresh" data-dismiss="modal">Refresh Dashboard</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    $(document).on("click",".oba-judgement", function () {
        $("#judgement").html($(this).html());
        $("#moduleid").html($(this).data('mid'));
        $("#cartonno").html($(this).data('cno'));
        if ($(this).html() == "Pass") {
            $("#judgement").removeClass("bg-danger").addClass("bg-success");
            $("#isoption").html("(Optional)");
        } else {
            $("#judgement").removeClass("bg-success").addClass("bg-danger");
            $("#isoption").html("");
        }
    });

    $(document).on("change","[name*='Product_Type']", function () {
        if ($("[name*='Product_Type']:checked").length == 0) {
            $("[name*='WorkOrder_ID']").removeAttr("disabled");
        } else {
            $("[name*='WorkOrder_ID']").attr("disabled",true);
        
            $.each($("[name*='Product_Type']:checked"), function(i){
                myProdType = $(this).val();

                $.each($("[name*='WorkOrder_ID']"), function(i){
                    if (myProdType == $(this).data("prodtype")) {
                        $(this).removeAttr("disabled");
                    }
                });
            });
        }
    });

    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/trina/ftd/' + $('#start').val() + '/' + $('#end').val() ).load();
        });

        $("#FilterRefresh").click(function() {
            $("#RefreshButton").click();
        });

        $("#FilterButton").click(function() {
            $("#FilterModal").modal('toggle');
        });

        $("#SaveButton").click(function() {
            if ($("#judgement").html() == "Fail" && $("#remarks").val() == "") {
                alert("Remarks is required.");
            } else {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('Module_ID', $("#moduleid").html());
                formData.append('Carton_no', $("#cartonno").html());
                formData.append('Judgement', $("#judgement").html());
                formData.append('Remarks', $("#remarks").val());
                
                $.ajax({
                    url: '/trina/oba',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        $("#RefreshButton").click();
                        $("#OBAModal").modal("toggle");
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
            }
        });

        var table = $('#ftd-list').DataTable({
            "scrollX": true,
            processing: true,
            "order": [],
            "serverSide": true,
            "ajax": {
                "url": '/trina/ftd/' + $('#start').val() + '/' + $('#end').val(),
                "type": "GET",
                "data": function(d){
                    pt = "";
                    wo = "";
                    $.each($('#FilterParam').serializeArray(), function(i, obj){
                        if (obj['name'] == "Product_Type" || obj['name'] == "WorkOrder_ID") {
                            if (obj['name'] == "Product_Type") {
                                pt += ((pt == "") ? "" : "|" ) + obj['value'];
                                d['form_' + obj['name']] = pt;
                            } else if (obj['name'] == "WorkOrder_ID") {
                                wo += ((wo == "") ? "" : "|" ) + obj['value'];
                                d['form_' + obj['name']] = wo;
                            }
                        } else {
                            d['form_' + obj['name']] = obj['value'];
                        }
                    });
                },
            }, 
            "paging": false,
            "deferRender": true,
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_ftd_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_ftd_csv"
                },
            ],
            "columnDefs": [
                {
                    "targets": [ 
                        @if(Auth::user()->mes_role != 'QUAL' && Auth::user()->sysadmin != 1)
                            0
                        @else
                            1
                        @endif
                     ],
                    "visible": false
                }
            ],
            columns: [
                { "render": function ( data, type, full, meta ) {
                    if (full.Carton_no != "") {
                        jdg = full.Judgement;
                        hdr = '<h6 class="dropdown-header bg-secondary text-white">Change Status</h6>';

                        if (full.Judgement == "Pass") {
                            cls = "btn-success";
                        } else if (full.Judgement == "Fail") {
                            cls = "btn-danger";
                        } else {
                            cls = "btn-secondary";
                            jdg = "Judgement";
                            hdr = '';
                        }

                        return '<div class="btn-group" role="group" aria-label="Button group with nested dropdown"><div class="btn-group" role="group"><button id="btnGroupDrop1" type="button" class="btn '+cls+' dropdown-toggle pt-0 pb-0 pl-1 pr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><small>'+jdg+'</small></button><div class="dropdown-menu p-0" aria-labelledby="btnGroupDrop1"><small>'+hdr+'</small><a class="dropdown-item bg-success text-white oba-judgement" href="#" data-toggle="modal" data-target="#OBAModal" data-mid="'+full.Module_ID+'" data-cno="'+full.Carton_no+'">Pass</a><a class="dropdown-item bg-danger text-white oba-judgement" href="#" data-toggle="modal" data-target="#OBAModal" data-mid="'+full.Module_ID+'" data-cno="'+full.Carton_no+'">Fail</a></div></div></div>';
                    } else {
                        return '';
                    }
                }},
                { data: 'Judgement' },
                { data: 'WorkOrder_ID' },
                { "render": function ( data, type, full, meta ) {
                    if (full.FILEPATH != "") {
                        return '<a href="'+full.FILEPATH+'" target="_blank" type="vnd.sealedmedia.softseal.jpg" class="modid">'+full.Module_ID+'</a>';
                    } else {
                        return full.Module_ID;
                    }
                }},
                { data: 'Module_Grade' },
                { data: 'EL_Grade' },
                { data: 'Product_ID' },
                { data: 'Product_Type' },
                { data: 'Grade_of_Cell_Power' },
                { data: 'Cell_Power' },
                { data: 'Cell_Color' },
                { data: 'EFF' },
                { data: 'Carton_no' },
                { data: 'Packing_Date' },
                { data: 'Container_No' },
                { data: 'TEST_DATETIME' },
                { data: 'TITLE' },
                { data: 'Grade' },
                { data: 'PMAX' },
                { data: 'FF' },
                { data: 'VOC' },
                { data: 'ISC' },
                { data: 'VPM' },
                { data: 'IPM' },
                { data: 'RS' },
                { data: 'RSH' },
                { data: 'EnvTemp' },
                { data: 'SurfTemp' },
                { data: 'NAMEPLATE_Type' },
            ],
        });
    });
</script>
@endpush