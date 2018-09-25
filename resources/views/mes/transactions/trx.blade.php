@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>MES Transactions [{{$station->STNDESC}}]</h3>
    <h4>{{$date}} - Shift {{$shift}}</h4>
    {{-- <a href="#" role="button" class="btn btn-primary">Create Log Entry</a> --}}
    {{-- <br><br> --}}
    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="col-sm-4 text-right">
                    Scan Serial Number
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="sno" id="sno" placeholder="Scan your serial here">
                    <small class="form-text text-danger" id="err_sno"></small>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="mes-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th width="10%">Serial Number</th>
            <th width="10%">Model</th>
            <th width="5%">Class</th>
            <th width="5%">Location</th>
            <th width="5%">Customer</th>
            <th width="10%">Trx. Date</th>
            <th width="10%">Scan Date</th>
            <th width="5%">Shift</th>
            <th width="5%">Status</th>
            <th width="20%">Remarks</th>
            <th width="15%">User</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>

    <div class="modal fade" id="MESCreate" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="serialno">Serial Number</label>
                            <input type="text" class="form-control form-control-sm" name="serialno" id="serialno" readonly>
                        </div>
        
                        <div class="form-group">
                            <label for="customer">Customer</label>
                            <input type="text" class="form-control form-control-sm" name="customer" id="customer" readonly>
                        </div>
        
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" class="form-control form-control-sm" name="model" id="model" readonly>
                        </div>
        
                        <div class="form-group">
                            <label for="station">Recent Location</label>
                            <input type="text" class="form-control form-control-sm" name="station" id="station" readonly>
                        </div>

                        <div class="form-group">
                            <label for="class">Current Class</label>
                            <input type="text" class="form-control form-control-sm" name="class" id="class" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 offset-sm-1">
                        <div class="form-group">
                            <div class="form-row">
                                <label for="status">Module Status</label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="stat0" value="0">
                                <label class="form-check-label" for="inlineRadio1">Good</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="stat1" value="1">
                                <label class="form-check-label" for="inlineRadio2">MRB</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="stat2" value="2">
                                <label class="form-check-label" for="inlineRadio3">Scrap</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="class">Module Class</label>
                            <select class="form-control form-control-sm" name="modclass" id="modclass"></select>
                            <small class="form-text text-danger" id="err_modclass"></small>
                        </div>

                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="8"></textarea>
                            <small class="form-text text-danger" id="err_remarks"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="SaveButton">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        var class_list;
        var class_allowed = '{{Auth::user()->portalUser->mesUser->assignment->where('STNCODE',$station->STNCODE)->first()->ALLOWCLS}}';

        $("#sno").focus()

        $("#sno").focusout(function() {
			$(this).focus();
		});

        $('#MESCreate').on('hidden.bs.modal', function () {
			$("#sno").focus();
		});

        $("#sno").keypress(function (e) {
			var key = e.which;
			var serialno = $(this).val();
			if(key == 13) {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('serial', serialno);
                formData.append('station', '{!!$station->STNCODE!!}');
                
                $.ajax({
                    url: '/mes/validate',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        console.log(dt);
                        if (dt.serial.serialno != undefined) {
                            $("#err_sno").html('');

                            $.each(dt.serial, function(i,v) {
                                if (i == 'statusCode') {
                                    $('#stat'+v).attr('checked',true);
                                    $('input[name="status"]').attr('disabled',false);
                                    for(i=0;i<v;i++) {
                                        $('#stat'+i).attr('disabled',true);
                                    }
                                } else if (i == 'class_list') {
                                    class_list = v;
                                    selitems = "<option disabled selected value> -- select an option -- </option>";
                                    $.each(class_list[dt.serial.statusCode], function(i,v) {
                                        if (v.MCLCODE == dt.serial.class) {
                                            selected = ' selected="selected"';
                                        } else {
                                            selected = "";
                                        }
                                        
                                        selitems += '<option value="' + v.MCLCODE + '"' + selected + '>' + v.MCLDESC + '</option>';
                                    });
                                    $('select[name="modclass"]').html(selitems);
                                } else {
                                    $('#' + i).val(v);
                                }
                            });

                            $('#MESCreate').modal('toggle');
                            // table.ajax.url( '/modules/ftd/' + serialno ).load();
                        } else {
                            $("#err_sno").html(dt.errors.error_msg);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
				 
				$(this).val("");
			}
		});

        $('input[name="status"]').change(function() {
            selitems = "<option disabled selected value> -- select an option -- </option>";
            $.each(class_list[$(this).val()], function(i,v) {
                    selitems += '<option value="' + v.MCLCODE + '">' + v.MCLDESC + '</option>';
            });
            $('select[name="modclass"]').html(selitems);
        });

        $("#SaveButton").click(function() {
            class_count = $('select[name="modclass"] option').length;
            err = 0;
            if (class_count > 1 && ($("#modclass").val() == "" || $("#modclass").val() == null)) {
                $("#err_modclass").html("Module Class is required");
                err++;
            } else {
                $("#err_modclass").html("");
            }

            if ($("#remarks").val() == "" || $("#remarks").val() == null) {
                $("#err_remarks").html("Remarks is required");
                err++;
            } else {
                $("#err_remarks").html("");
            }

            if (err == 0) {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('SERIALNO', $("#serialno").val());
                formData.append('MODCLASS', $("#modclass").val());
                formData.append('SNOSTAT', $("input[name='status']:checked").val());
                formData.append('REMARKS', $("#remarks").val());

                $.ajax({
                    url: '/mescreate/{!!$station->STNID!!}',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        console.log(dt);
                        table.ajax.reload();
                        $("#MESCreate").modal('toggle');
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });	
            }
        });

        var table = $('#mes-list').DataTable({
            // "scrollX": true,
            "order": [],
            "searching": false,
            ajax: '/mes/transactions/{{$date}}/{{$shift}}/{{$station->STNID}}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                    },
                    text:       'Excel',
                    filename: "{{$station->STNCODE}}_trx_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                    },
                    text:       'CSV',
                    filename: "{{$station->STNCODE}}_trx_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'SERIALNO' },
                { data: 'MODEL' },
                { data: 'MODCLASS' },
                { data: 'LOCNCODE' },
                { data: 'CUSTOMER' },
                { data: 'DATE' },
                { data: 'TRXDATE' },
                { data: 'SHIFT' },
                { data: 'STATUS' },
                { data: 'REMARKS' },
                { data: 'USER' },
            ],
        });
    });
</script>
@endpush