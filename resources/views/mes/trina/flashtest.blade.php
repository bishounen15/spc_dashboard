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
                            <label for="WorkOrder_ID">Work Order ID</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="WorkOrder_ID" id="WorkOrder_ID" readonly>
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
                            <label for="Module_Colour">Module Color</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Module_Colour" id="Module_Colour" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Grade_of_Cell_Power">Grade of Cell Power</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Grade_of_Cell_Power" id="Grade_of_Cell_Power" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Cell_Power">Cell Power</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Cell_Power" id="Cell_Power" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="Cell_Color">Cell Color</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="Cell_Color" id="Cell_Color" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-1">
                        <div class="col-sm-5">
                            <label for="EFF">Efficiency</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" name="EFF" id="EFF" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <strong>Flash Test History</strong>
                </div>

                <table class="table table-condensed table-striped table-sm" id="ftd-list" style="width: 100%;">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        <tr>
                            <th>Action</th>
                            <th>Module ID</th>
                            <th>Title</th>
                            <th>Work Order ID</th>
                            <th>Test Date/Time</th>
                            <th>PMAX</th>
                            <th>FF</th>
                            <th>VOC</th>
                            <th>IMP</th>
                            <th>VPM</th>
                            <th>IPM</th>
                            <th>RS</th>
                            <th>RSH</th>
                            <th>Env Temp</th>
                            <th>Surf Temp</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-light" style="font-size: 0.75em;">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FTModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><strong>Reset Power</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Do you really want to reset the power?<br><br>
                    Press YES to proceed.
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="ResetButton">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    var mylink = "";

    $(document).ready(function() {
        $("#sno").focus();

        $('#FTModal').on('show.bs.modal', function(e) {
            mylink = $(e.relatedTarget).data('href');
        });

        $("#ResetButton").click(function() {
            var token = $('input[name=_token]');

            $.ajax({
                url: mylink,
                method: 'POST',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (dt) {
                    table.ajax.reload( null, false );
                    $("#FTModal").modal("toggle");
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
                    url: '/trina/loadtest/' + serialno,
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
                                $("#" + i).val(v);
                            });
                            
                            $("#err_sno").html("");
                        } else {
                            $("#err_sno").html("Module ID [" + serialno + "] does not exists.");
                            $(".form-control").val("");
                        }

                        table.ajax.url( '/trina/testresults/' + serialno ).load();
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
				 
				 $(this).val("");
			}
		});

        var table = $('#ftd-list').DataTable({
            "scrollX": true,
            "order": [],
            "searching": false,
            // ajax: '#',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ]
                    },
                    text:       'Excel',
                    filename: "ftd_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ]
                    },
                    text:       'CSV',
                    filename: "ftd_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            "columnDefs": [
                {
                    "targets": [ 1 ],
                    "visible": false
                }
            ],
            columns: [
                // { data: 'id' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    // console.log(full.IsDefault);
                    if (full.IsDefault == 1) {
                        return '<button class="btn btn-primary btn-sm btn-block" disabled>Default Test</button>';
                    } else {
                        return '<a href="#" data-href="/trina/resetpower/'+full.WorkOrder_ID+'/'+full.Module_ID+'/'+full.TEST_DATETIME+'" role="button" class="btn btn-sm btn-block btn-success{{Auth::user()->sysadmin == 1 ? "" : " disabled"}}" data-toggle="modal" data-target="#FTModal" style="width: 100%;">Set as Default</a></div>';
                    }
                }},
                { data: 'Module_ID' },
                { data: 'Title' },
                { data: 'WorkOrder_ID' },
                { data: 'TEST_DATETIME' },
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
                { data: 'Remark' },
                // { data: 'USER' },
            ],
        });
    });
</script>
@endpush