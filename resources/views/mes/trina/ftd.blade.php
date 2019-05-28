@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA FTD Report</h3>
    {{-- <a href="#" role="button" class="btn btn-primary">Create Log Entry</a> --}}
    {{-- <br><br> --}}
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Start Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                    
                    <label class="my-1 mr-2" for="end">End Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="end" id="end" value="{{ date('Y-m-d') }}">        
                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="pack" name="pack" value="option1">
                        <label class="form-check-label" for="pack">Packed Only</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="shipped" name="shipped" value="option1">
                        <label class="form-check-label" for="shipped">Exclude Shipped</label>
                    </div>

                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Dashboard</button>
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

    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/trina/ftd/' + $('#start').val() + '/' + $('#end').val() + "/" + $("#pack").is(":checked") + "/" + $("#shipped").is(":checked") ).load();
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
            // serverSide: true,
            "order": [],
            ajax: '/trina/ftd/' + $('#start').val() + '/' + $('#end').val() + "/" + $("#pack").is(":checked") + "/" + $("#shipped").is(":checked"),
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_ftd_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27 ]
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
            ],
        });
    });
</script>
@endpush