@extends('layouts.app')
@section('content')
<form method="POST" action="/mes/packaging" id="TrxForm"> 
    @csrf 
    {{-- <div class="container"> --}}
        <h3>Create Packaging Transaction</h3>

        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                        <div class="card-header">
                            <strong>Packaging Details</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-condensed table-sm" style="font-size: 0.8em;">
                                <tr>
                                    <th>Pallet No.</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="PALLETNO" id="PALLETNO" placeholder="Generated upon saving" value="{{ old('PALLETNO') ? old('PALLETNO') : $PALLETNO }}" readonly>
                                            <small class="form-text text-danger">{{ $errors->first('PALLETNO') }}</small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Product No.</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="PRODUCTNO" id="PRODUCTNO" placeholder="Generated from 1st Scan" value="{{ old('PRODUCTNO') ? old('PRODUCTNO') : $PRODUCTNO }}" readonly>
                                            <small class="form-text text-danger">{{ $errors->first('PRODUCTNO') }}</small>
                                        </div>
                                    </td>
                                </tr>
            
                                <tr>
                                    <th>Date</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="TRXDATE" id="TRXDATE" value="{{ old('TRXDATE') ? old('TRXDATE') : $TRXDATE }}" readonly>
                                            <small class="form-text text-danger">{{ $errors->first('TRXDATE') }}</small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Model Name</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="MODELNAME" id="MODELNAME" placeholder="Generated from 1st Scan" value="{{ old('MODELNAME') ? old('MODELNAME') : $MODELNAME }}" readonly>
                                            <small class="form-text text-danger">{{ $errors->first('MODELNAME') }}</small>
                                        </div>
                                    </td>
                                </tr>
            
                                <tr>
                                    <th>Customer</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="CUSTOMER" id="CUSTOMER" placeholder="Generated from 1st Scan" value="{{ old('CUSTOMER') ? old('CUSTOMER') : $CUSTOMER }}" readonly>
                                            <small class="form-text text-danger">{{ $errors->first('CUSTOMER') }}</small>
                                        </div>
                                    </td>
                                </tr>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Last Scanned Serial</strong>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="#" role="button" data-toggle="modal" data-target="#SerialDetails" class="btn btn-success btn-sm">View all serials</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div>
                                    <strong>
                                        <h1 id="last-sn" class="display-4">-</h1>
                                    </strong>
                                </div>
                                <div>
                                    <h2 id="last-model">-</h2>
                                </div>
                                <div>
                                    <h2 id="last-class">-</h2>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <h3>Module Count:</h3><br>
                                <div class="text-center">
                                    <strong><h1 id="module-count" class="display-3">-</h1></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                {{-- <input type="submit" class="btn btn-success" name="save" id="save" value="Save Transaction" style="width: 200px;"> --}}
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
        
        <div class="modal fade" id="SerialDetails" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Serial List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-condensed table-sm" id="serial-numbers" style="font-size: 0.9em;">
                        <thead class="table-dark">
                            <tr>
                                <th width="10%">#</th>
                                <th width="25%">Serial Number</th>
                                <th width="25%">Model Name</th>
                                <th width="15%">Class</th>
                                <th width="15%">Bin</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="serial-list">
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="btnClose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="width: 100px;">Close</button>
                </div>
                </div>
            </div>
        </div>
{{-- </div> --}}
</form>
@endsection

@push('jscript')
<script>
    var serials = [];

    $(document).on('click', '.remove-item', function() {
        sno = $(this).closest('tr').children('td').slice(1, 2).html();
        var index = serials.indexOf(sno);
        if (index !== -1) serials.splice(index,1);
        $(this).closest('tr').remove();

        if ($("#module-count").html().includes("/")) {
            modcount = $("#module-count").html().split("/");
            $("#module-count").html((modcount[0].trim() - 1) + ' / ' + modcount[1].trim());
        }
    });

    function SaveTransaction() {
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('PALLETNO', $("#PALLETNO").val());
        formData.append('TRXDATE', $("#TRXDATE").val());
        formData.append('CUSTOMER', $("#CUSTOMER").val());
        formData.append('PRODUCTNO', $("#PRODUCTNO").val());
        formData.append('MODELNAME', $("#MODELNAME").val());

        plserials = [];

        $('#serial-list tr').each(function(e){
            plserials.push($(this).children('td').slice(1, 2).html());
        });

        formData.append('SERIALNO[]', plserials);

        $.ajax({
            url: '/mes/packaging',
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (dt) {
                window.location.href="/mes/packaging";
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    }

    $(document).ready(function () {
        $("#sno").focus();
        $("#sno").focusout(function() {
            $(this).focus();
        });

        $('#SerialDetails').on('hidden.bs.modal', function () {
            $("#sno").focus();
        });

        $("#sno").keypress(function (e) {
            var key = e.which;
            var serialno = $(this).val().trim();
            if(key == 13) {
                fullpallet = false;

                if ($("#module-count").html().includes("/")) {
                    modcount = $("#module-count").html().split("/");
                    fullpallet = (modcount[0].trim() == modcount[1].trim());
                }

                if(serials.indexOf(serialno.toUpperCase()) >= 0) {
                    $("#err_sno").html("Serial No. ["+serialno.toUpperCase()+"] was already scanned."); 
                } else if (fullpallet) {
                    $("#err_sno").html("Max load has been fulfilled. You cannot scan another serial."); 
                } else {
                    var token = $('input[name=_token]');
                    var formData = new FormData();
                    formData.append('serial', serialno);
                    formData.append('model', $("#MODELNAME").val());
                    formData.append('date', $("#TRXDATE").val());

                    $.ajax({
                        url: '/mes/packaging/validate',
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
                                    
                                    $("#last-sn").html(serialno.toUpperCase()); 
                                    $("#last-model").html(dt.MODELNAME);
                                    $("#last-class").html("Class " + dt.MODCLASS);
                                    $("#module-count").html(($("#serial-list > tr").length+1) + " / " + dt.MAXPALLET);

                                    myRow = '<tr><td>'+($("#serial-list > tr").length+1)+'</td><td class="serial-column">'+serialno.toUpperCase()+'</td><td>'+dt.MODELNAME+'</td><td>'+dt.MODCLASS+'</td><td>'+dt.BIN+'</td><td><a href="#" role="button" class="btn btn-danger btn-sm remove-item">Remove</a></td></tr>';

                                    if ($("#serial-list > tr").length == 0) {
                                        $("#PALLETNO").val(dt.PALLETFORMAT);
                                        $("#CUSTOMER").val(dt.CUSTOMER);
                                        $("#MODELNAME").val(dt.MODELNAME);
                                        $("#PRODUCTNO").val(dt.PRODUCTNO);

                                        // $("#serial-list").append(myRow);
                                    } else {
                                        // $('#serial-list > tr:first').before(myRow);
                                    }

                                    $("#serial-list").append(myRow);
                                    
                                    // $("#err_sno").html("");
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

    // var $tr;
    // function addItem() {
    //     var $clone = $tr.clone().find("input,textarea").val("0").end();
    //     $("#item-list").append($clone);
    // }

    // function validate() {
    //     var validated = true;

    //     $('select[name^="category"]').each( function() {
    //         i = $('select[name="category[]"]').index(this);
            
    //         if ($(this).val() == "") {
    //             $('span[id="err_category[]"]').eq(i).html("You have not selected a category.");
    //             validated = false;
    //         } else {
    //             $('span[id="err_category[]"]').eq(i).html("");
    //         }
    //     });

    //     $('select[name^="item"]').each( function() {
    //         i = $('select[name="item[]"]').index(this);
            
    //         if ($(this).val() == "") {
    //             $('span[id="err_item[]"]').eq(i).html("You have not selected an item.");
    //             validated = false;
    //         } else {
    //             $('span[id="err_item[]"]').eq(i).html("");
    //         }
    //     });

    //     $('input[name^="qty"]').each( function() {
    //         i = $('input[name="qty[]"]').index(this);
    //         cqty = parseInt($(this).val());
    //         if (cqty > 0) {
    //             if ($("#type").val() == "Request" && parseInt($('input[name="stock[]"]').eq(i).val()) < cqty) {
    //                 $('span[id="err_qty[]"]').eq(i).html("Your request exceeds the current stock.");
    //                 validated = false;
    //             } else {
    //                 $('span[id="err_qty[]"]').eq(i).html("");
    //             }
    //         } else {
    //             $('span[id="err_qty[]"]').eq(i).html("Quantity must be greater than 0.");
    //             validated = false;
    //         }
    //     });

    //     if (validated == true) {
    //         $("#TrxForm").submit();
    //     }
    // }

    // $(document).ready(function () {
    //     $tr = $(".tr-clone");

    //     $("#rem-item").click(function() {
    //         selected = $('input[name="line-item[]"]:checked');
    //         if ($(selected).length > 0) {
    //             $(selected).closest('tr').remove();
    //         }
    //     });

    //     $(document).on('change', 'select[name="category[]"]', function(index) {
    //         i = $('select[name="category[]"]').index(this);
            
    //         var token = $('input[name=_token]');
    //         var formData = new FormData();
    //         formData.append('category_id', $(this).val());

    //         $.ajax({
    //             url: "{{route('get_item_list')}}",
    //             method: 'POST',
    //             contentType: false,
    //             processData: false,
    //             data: formData,
    //             dataType: 'json',
    //             headers: {
    //                 'X-CSRF-TOKEN': token.val()
    //             },
    //             success: function (items) {
    //                 selitems = "<option disabled selected value> -- select an option -- </option>";
    //                 $.each(items, function(i, v) {
    //                     selitems += '<option value="' + v.id + '">' + v.description + '</option>';
    //                 });
    //                 $('select[name="item[]"]').eq(i).html(selitems);
    //             },
    //             error: function(xhr, textStatus, errorThrown){
    //                 alert (errorThrown);
    //             }	
    //         });
    //     });

    //     $(document).on('change', 'select[name="item[]"]', function(index) {
    //         i = $('select[name="item[]"]').index(this);
            
    //         var token = $('input[name=_token]');
    //         var formData = new FormData();
    //         formData.append('item_id', $(this).val());

    //         $.ajax({
    //             url: "{{route('get_item_details')}}",
    //             method: 'POST',
    //             contentType: false,
    //             processData: false,
    //             data: formData,
    //             dataType: 'json',
    //             headers: {
    //                 'X-CSRF-TOKEN': token.val()
    //             },
    //             success: function (details) {
                    
    //                 $('input[name="stock[]"]').eq(i).val(details.current_stock);
    //                 $('input[name="unit-cost[]"]').eq(i).val((details.unit_cost).toFixed(2));
    //                 $('input[name="total-cost[]"]').eq(i).val( (parseInt($('input[name="qty[]"]').eq(i).val()) * details.unit_cost).toFixed(2) );
                    
    //             },
    //             error: function(xhr, textStatus, errorThrown){
    //                 alert (errorThrown);
    //             }	
    //         });
    //     });

    //     $(document).on('change', 'input[name="qty[]"]', function(index) {
    //         i = $('input[name="qty[]"]').index(this);
    //         $('input[name="total-cost[]"]').eq(i).val(parseFloat( ($('input[name="qty[]"]').eq(i).val()) * parseFloat($('input[name="unit-cost[]"]').eq(i).val())).toFixed(2) );
    //     });
    // });
</script>
@endpush