@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>Module Information Inquiry</h3>
    <br>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Module Information
                </div>

                <div class="card-body">
                    <div class="form-row">
                        <label for="sno">Scan Serial No.</label>
                        <input type="text" class="form-control form-control-sm" name="sno" id="sno">
                        <small class="form-text text-danger" id="err_sno"></small>
                    </div>
                </div>

                <table class="table table-condensed table-sm">
                    <tbody>
                        <tr>
                            <th width="35%" class="bg-dark text-light">Serial No.</th>
                            <td width="65%" id="SERIALNO" class="serial-info"></td>
                        </tr>

                        <tr>
                            <th width="35%" class="bg-dark text-light">Customer</th>
                            <td width="65%" id="CUSTOMER" class="serial-info"></td>
                        </tr>

                        <tr>
                            <th width="35%" class="bg-dark text-light">Part Number</th>
                            <td width="65%" id="PARTNO" class="serial-info"></td>
                        </tr>

                        <tr>
                            <th width="35%" class="bg-dark text-light">Model</th>
                            <td width="65%" id="MODEL" class="serial-info"></td>
                        </tr>
                        
                        <tr>
                            <th width="35%" class="bg-dark text-light">BOM</th>
                            <td width="65%" id="BOM" class="serial-info"></td>
                        </tr>

                        <tr>
                            <th width="35%" class="bg-dark text-light">Color</th>
                            <td width="65%" id="COLOR" class="serial-info"></td>
                        </tr>
                        
                        <tr>
                            <th width="35%" class="bg-dark text-light">Module Class</th>
                            <td width="65%" id="MODCLASS" class="serial-info"></td>
                        </tr>
                        
                        <tr>
                            <th width="35%" class="bg-dark text-light">Status</th>
                            <td width="65%" id="STATUS" class="serial-info"></td>
                        </tr>
                        
                        <tr>
                            <th width="35%" class="bg-dark text-light">Production Line</th>
                            <td width="65%" id="PRODLINE" class="serial-info"></td>
                        </tr>

                        <tr>
                            <th width="35%" class="bg-dark text-light">Pallet Number</th>
                            <td width="65%" id="PALLETNO" class="serial-info"></td>
                        </tr>

                        <tr>
                            <th width="35%" class="bg-dark text-light">Container No.</th>
                            <td width="65%" id="CONTAINER" class="serial-info"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    Flash Test Data
                </div>

                <table class="table table-condensed table-striped table-sm" id="ftd-list" style="width: 100%;">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        {{-- <th>#</th> --}}
                        <tr>
                            <th class="serial-hide" hidden>Serial No.</th>
                            <th width="15%">Inspection Time</th>
                            <th width="10%">Isc</th>
                            <th width="10%">Uoc</th>
                            <th width="10%">Impp</th>
                            <th width="10%">Umpp</th>
                            <th width="10%">Pmpp</th>
                            <th width="10%">Shunt Resistance</th>
                            <th width="10%">FF</th>
                            <th width="5%">Bin</th>
                            <th width="10%">Reset</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-light" style="font-size: 0.75em;">
                        
                    </tbody>
                </table>
            </div>
            <br>
            <div class="card">
                <div class="card-header bg-info text-white">
                    Transaction History
                </div>

                <table class="table table-condensed table-striped table-sm" id="mes-list" style="width: 100%;">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        {{-- <th>#</th> --}}
                        <tr>
                            <th class="serial-hide" hidden>Serial No.</th>
                            <th width="5%">Prod. Line</th>
                            <th width="10%">Station</th>
                            <th width="15%">Trasaction Date</th>
                            <th width="10%">Status</th>
                            <th width="10%">Class</th>
                            <th width="30%">Remarks</th>
                            <th width="20%">Transacted By</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-light" style="font-size: 0.75em;">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-reset" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Reset Power</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id" value="0">
            <p>Do you want to reset power to "<small><span id="descr"></span></small>"?</p>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary btn-yes reset-power">Yes</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    var mylink = '';
    $(document).ready(function() {
        $("#sno").focus();

        $("#sno").focusout(function() {
			$(this).focus();
		});

        $("#sno").keypress(function (e) {
			var key = e.which;
			var serialno = $(this).val();
			if(key == 13) {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('SERIALNO', serialno);
                console.log(serialno)
                $.ajax({
                    url: '/modules/inquire',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        // console.log(dt);
                        if (dt.SERIALNO != undefined) {
                            $.each(dt, function(i, v) {
                                $("#" + i).html(v);
                            });

                            $("#err_sno").html("");
                        } else {
                            $("#err_sno").html("Serial No. [" + serialno + "] does not exists.");
                            $(".serial-info").html("");
                        }

                        table.ajax.url( '/modules/ftd/' + serialno ).load();
                        mes_table.ajax.url( '/modules/mes/' + serialno ).load();
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
				//$("#RecordData").modal("toggle");
				//  $("#myRows").load("loadModInq.php?serial="+ serialno);
                 
				 $(this).val("");
			}
		});

        $('#confirm-reset').on('show.bs.modal', function(e) {
            $("#descr").html($(e.relatedTarget).attr('id'));
            mylink = $(e.relatedTarget).data('href');
            // $("#delete-record").attr("action", $(e.relatedTarget).data('href'));
        });

        $(".reset-power").click(function() {
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
                    console.log(dt);
                    table.ajax.url( '/modules/ftd/' + dt ).load();
                    $("#confirm-reset").modal('toggle');                    
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        });

        $("#RefreshButton").click(function() {
            // table.ajax.url( '/mes/data/' + $('#start').val() + '/' + $('#end').val() ).load();
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                    },
                    text:       'Excel',
                    filename: "ftd_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
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
                    "targets": [ 0 ],
                    "visible": false
                }
            ],
            columns: [
                // { data: 'id' },
                { data: 'ModuleID' },
                { data: 'InspectionTime' },
                { data: 'Isc' },
                { data: 'Uoc' },
                { data: 'Impp' },
                { data: 'Umpp' },
                { data: 'Pmpp' },
                { data: 'ShuntResistance' },
                { data: 'FF' },
                { data: 'Bin' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<a href="#" data-href="/mes/resetpower/'+full.ModuleID+'/'+full.ROWID+'" role="button" class="btn btn-sm btn-success{{Auth::user()->sysadmin == 1 ? "" : " disabled"}}" data-toggle="modal" data-target="#confirm-reset" id="'+full.Bin+'" style="width: 100%;">Reset</a></div>';
                }},
                // { data: 'USER' },
            ],
            createdRow: function (row, data, index) {
                //
                // if the second column cell is blank apply special formatting
                //
                if (data.skip == 1) {
                    $(row).addClass('table-danger');
                } else {
                    $(row).addClass('table-success');
                }
            },
        });

        var mes_table = $('#mes-list').DataTable({
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                    },
                    text:       'Excel',
                    filename: "mes_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                    },
                    text:       'CSV',
                    filename: "mes_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false
                }
            ],
            columns: [
                // { data: 'id' },
                { data: 'SERIALNO' },
                { data: 'PRODLINE' },
                { data: 'LOCNCODE' },
                { data: 'TRXDATE' },
                { data: 'STATUS' },
                { data: 'MODCLASS' },
                { data: 'REMARKS' },
                { data: 'TRXUSER' },
            ],
        });
    });
</script>
@endpush