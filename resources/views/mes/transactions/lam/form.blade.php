@extends('layouts.app')
@section('content')
<form method="POST" action="/mes/packaging" id="TrxForm"> 
    @csrf 
    <div class="container-fluid">
        <h3>Create Pre-Lam Transaction</h3>

        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                        <div class="card-header">
                            <strong>Laminator Selection - [Line {{ $prod_line }}]</strong>
                        </div>
                        <div class="card-body">
                            @foreach($laminators as $lam)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="lam" id="{{ $lam->code }}" value="{{ $lam->id }}">
                                    <label class="form-check-label" for="lam">
                                        {{ $lam->descr }}
                                    </label>
                                </div>
                            @endforeach
                        </div>        
                </div>
                <div class="card">
                    <div class="card-header bg-secondary text-white"><strong>Lam Outs</strong></div>
                    <div class="card-body">
                        <table class="table table-condensed table-striped" id="lam-outs">
                            <thead>
                                <th width="30%" class="table-dark">Laminator</th>
                                <th width="14%" class="table-secondary text-center">Total</th>
                                <th width="14%" class="table-info text-center">A</th>
                                <th width="14%" class="table-info text-center">B</th>
                                <th width="14%" class="table-info text-center">C</th>
                                <th width="14%" class="table-info text-center">D</th>
                            </thead>
                            <tbody>
                                @foreach($lam_outs as $lam_out)
                                <tr>
                                    <td>{{ $lam_out->laminator }}</td>
                                    <td class="text-center">{{ $lam_out->total }}</td>
                                    <td class="text-center">{{ $lam_out->A }}</td>
                                    <td class="text-center">{{ $lam_out->B }}</td>
                                    <td class="text-center">{{ $lam_out->C }}</td>
                                    <td class="text-center">{{ $lam_out->D }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-sm-4 text-right">
                                <label for="sno">Scan Serial Number</label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="sno" id="sno" placeholder="Scan your serial here" autofocus>
                                <small class="form-text text-danger" id="err_sno"></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-warning">
                        <strong>List of Serial Numbers</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr class="table-info">
                                    <th width="20%">Location</th>
                                    <th width="40%">Serial No.</th>
                                    <th width="40%">Date Scanned</th>
                                </tr>
                            </thead>
                            <tbody id="serial-list">

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <a href="#" role="button" class="btn btn-success" id="save-trx" style="width: 200px;" onclick="SaveTransaction()">Save Transaction</a>
                            </div>
                            <div class="form-group col-sm-6 text-right">
                                <a href="/mes/packaging" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="errors-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Errors</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <p>
                        The following errors were encountered while saving transaction.
                    </p>
                    <ul id="error-list">

                    </ul>
                    <p>
                        Please check the data entered.
                    </p>
                </div>
                <div class="modal-footer">
                    <button id="btnClose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="width: 100px;">Close</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('jscript')
<script>
    var serials = [];

    function SaveTransaction() {
        if ($("input[name='lam']:checked").val() == undefined) {
            $('#error-list').html('');
            $('#error-list').append('<li>You have not yet selected a Laminator.</li>');
            $('#errors-modal').modal('toggle');
        } else {
            if ($('#serial-list tr').length > 0) {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('STATIONID', $("input[name='lam']:checked").val());
                
                lamserials = [];

                $('#serial-list tr').each(function(e){
                    sinput = [];
                    sinput.push($(this).children('td').slice(0, 1).html());
                    sinput.push($(this).children('td').slice(1, 2).html());
                    sinput.push($(this).children('td').slice(2, 3).html());
                    lamserials.push(sinput);
                });

                formData.append('SERIALNO[]', lamserials);
                // console.log(lamserials);

                $.ajax({
                    url: '/mes/lam',
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
                        if (dt.errors.length > 0) {
                            $('#error-list').html('');
                            $.each(dt.errors, function(index, value) {
                                $('#error-list').append('<li>'+ value +'</li>');
                            });
                            $('#errors-modal').modal('toggle');
                        } else {
                            window.location.href="/mescreate/{{$station->STNID}}";
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
            } else {
                $('#error-list').html('');
                $('#error-list').append('<li>No serial scanned.</li>');
                $('#errors-modal').modal('toggle');
            }
        }
    }

    $(document).ready(function () {
        $("#sno").focus();
        $("#sno").focusout(function() {
            $(this).focus();
        });

        $("#sno").keypress(function (e) {
            var key = e.which;
            var serialno = $(this).val().trim();
            if(key == 13) {
                e.preventDefault();
                fullpallet = (serials.length == 4);

                if (serials.indexOf(serialno.toUpperCase()) >= 0) {
                    $("#err_sno").html("Serial No. ["+serialno.toUpperCase()+"] was already scanned."); 
                } else if (fullpallet) {
                    $("#err_sno").html("Max load has been fulfilled. You cannot scan another serial."); 
                } else {
                    var token = $('input[name=_token]');
                    var formData = new FormData();
                    formData.append('serial', serialno);
                    
                    $.ajax({
                        url: '/mes/lam/validate',
                        method: 'POST',
                        contentType: false,
                        processData: false,
                        data: formData,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': token.val()
                        },
                        success: function (dt) {
                            if (dt.errors != undefined) {
                                $("#err_sno").html(dt.errors.error_msg);

                                if (dt.errors.error_msg == '') {
                                    serials.push(serialno.toUpperCase());
                                    
                                    $loc = "A";
                                    $loc = String.fromCharCode($loc.charCodeAt(0) + $("#serial-list > tr").length);
                                    
                                    myRow = '<tr><td>'+$loc+'</td><td class="serial-column">'+serialno.toUpperCase()+'</td><td>'+dt.SCANDATE+'</td></tr>';

                                    $("#serial-list").append(myRow);
                                }
                            } 
                        },
                        error: function(xhr, textStatus, errorThrown){
                            alert (errorThrown);
                        }	
                    });
                }

                $(this).val("");
            }
        });
    });
</script>
@endpush