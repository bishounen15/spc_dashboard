@extends('layouts.app')
@section('content')
<form method="POST" action="{{route('create_trx',[old('type') ? old('type') : $type])}}" id="TrxForm"> 
    @csrf 
    <div class="container">
        <h3>{{$trx}}</h3>
        <div class="card">
            <div class="card-header">Transaction Details</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label for="control_no">Control Number</label>
                            <input type="text" class="form-control form-control-sm" name="control_no" id="control_no" value="{{ old('control_no') ? old('control_no') : $control_no }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('control_no') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="type">Transaction Type</label>
                            <input type="text" class="form-control form-control-sm" name="type" id="type" placeholder="Transaction Type" value="{{ old('type') ? old('type') : $type }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('type') }}</small>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control form-control-sm" name="date" id="date" placeholder="Transaction Date" value="{{ old('date') ? old('date') : $date }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('date') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control form-control-sm" name="status" id="status" placeholder="Status" value="{{ old('status') ? old('status') : $status }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('status') }}</small>
                        </div>
                    </div>
                </div>
                      
                <div class="form-row">
                    <div class="form-group text-right">
                        &nbsp;
                        <a href="#" id="add-item" role="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="addItem()">Add</a>
                        <a href="#" id="rem-item" role="button" class="btn btn-danger btn-sm" style="width: 100px;">Remove</a>
                    </div>
                </div>    

                <table class="table table-condensed table-sm" style="font-size: 0.7em;">
                    <thead class="table-dark">
                        <tr>
                            <th width="3%">#</th>
                            <th width="25%">Category</th>
                            <th width="32%">Item</th>
                            <th width="10%">Stock</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Unit Cost</th>
                            <th width="10%">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody id="item-list">
                        <tr class="tr-clone">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="line-item[]" value="1" id="defaultCheck1">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control form-control-sm" name="category[]">
                                        <option readonly selected value> -- select an option -- </option>
                                        @foreach($categories as $category)
                                        <option value="{{$category['id']}}"
                                        {{-- @if ($category->id == old('category_id', $category_id))
                                            selected="selected"
                                        @endif --}}
                                        >{{$category['description']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-text text-danger" id="err_category[]"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control form-control-sm" name="item[]">
                                        <option readonly selected value> -- select an option -- </option>
                                    </select>
                                    <span class="form-text text-danger" id="err_item[]"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" name="stock[]" value="0" readonly>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" step="1" class="form-control form-control-sm" name="qty[]" value="0">
                                    <span class="form-text text-danger" id="err_qty[]"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" name="unit-cost[]" value="0" readonly>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" name="total-cost[]" value="0" readonly>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="3"></textarea>
                    <small class="form-text text-danger">{{ $errors->first('type') }}</small>
                </div>
            </div>        
            
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        {{-- <input type="submit" class="btn btn-success" name="save" id="save" value="Save Transaction" style="width: 200px;"> --}}
                        <a href="#" role="button" class="btn btn-success" id="save-trx" style="width: 200px;" onclick="validate()">Save Transaction</a>
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_trx')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
    </div> 
</form>
@endsection

@push('jscript')
<script>
    var $tr;
    function addItem() {
        var $clone = $tr.clone().find("input,textarea").val("0").end();
        $("#item-list").append($clone);
    }

    function validate() {
        var validated = true;

        $('select[name^="category"]').each( function() {
            i = $('select[name="category[]"]').index(this);
            
            if ($(this).val() == "") {
                $('span[id="err_category[]"]').eq(i).html("You have not selected a category.");
                validated = false;
            } else {
                $('span[id="err_category[]"]').eq(i).html("");
            }
        });

        $('select[name^="item"]').each( function() {
            i = $('select[name="item[]"]').index(this);
            
            if ($(this).val() == "") {
                $('span[id="err_item[]"]').eq(i).html("You have not selected an item.");
                validated = false;
            } else {
                $('span[id="err_item[]"]').eq(i).html("");
            }
        });

        $('input[name^="qty"]').each( function() {
            i = $('input[name="qty[]"]').index(this);
            cqty = parseInt($(this).val());
            if (cqty > 0) {
                if ($("#type").val() == "Request" && parseInt($('input[name="stock[]"]').eq(i).val()) < cqty) {
                    $('span[id="err_qty[]"]').eq(i).html("Your request exceeds the current stock.");
                    validated = false;
                } else {
                    $('span[id="err_qty[]"]').eq(i).html("");
                }
            } else {
                $('span[id="err_qty[]"]').eq(i).html("Quantity must be greater than 0.");
                validated = false;
            }
        });

        if (validated == true) {
            $("#TrxForm").submit();
        }
    }

    $(document).ready(function () {
        $tr = $(".tr-clone");

        $("#rem-item").click(function() {
            selected = $('input[name="line-item[]"]:checked');
            if ($(selected).length > 0) {
                $(selected).closest('tr').remove();
            }
        });

        $(document).on('change', 'select[name="category[]"]', function(index) {
            i = $('select[name="category[]"]').index(this);
            
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('category_id', $(this).val());

            $.ajax({
                url: "{{route('get_item_list')}}",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (items) {
                    selitems = "<option disabled selected value> -- select an option -- </option>";
                    $.each(items, function(i, v) {
                        selitems += '<option value="' + v.id + '">' + v.description + '</option>';
                    });
                    $('select[name="item[]"]').eq(i).html(selitems);
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        });

        $(document).on('change', 'select[name="item[]"]', function(index) {
            i = $('select[name="item[]"]').index(this);
            
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('item_id', $(this).val());

            $.ajax({
                url: "{{route('get_item_details')}}",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (details) {
                    
                    $('input[name="stock[]"]').eq(i).val(details.stock_limit);
                    $('input[name="unit-cost[]"]').eq(i).val((details.unit_cost).toFixed(2));
                    $('input[name="total-cost[]"]').eq(i).val( (parseInt($('input[name="qty[]"]').eq(i).val()) * details.unit_cost).toFixed(2) );
                    
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        });

        $(document).on('change', 'input[name="qty[]"]', function(index) {
            i = $('input[name="qty[]"]').index(this);
            $('input[name="total-cost[]"]').eq(i).val(parseInt( ($('input[name="qty[]"]').eq(i).val()) * parseFloat($('input[name="unit-cost[]"]').eq(i).val())).toFixed(2) );
        });
    });
</script>
@endpush