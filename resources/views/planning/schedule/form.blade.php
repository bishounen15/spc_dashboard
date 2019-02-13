@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? '/planning/schedule/' . $id : '/planning/schedule' }}" id="SchedForm">
    @if($modify == 1)
    <input type="hidden" name="_method" value="put" />
    @endif
    @csrf 
    {{-- <div class="container"> --}}
        <h3>Scheduled {{ $modify == 1 ? 'Update' : 'Creation' }}</h3>
        <div class="card">
            <div class="card-header">Schedule Information</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="production_date">Production Date</label>
                            <input type="date" class="form-control form-control-sm" name="production_date" id="production_date" placeholder="Production Date" value="{{ old('production_date') ? old('production_date') : $production_date }}"{{ $modify == 1 ? ' readonly' : '' }}>
                            <small class="form-text text-danger">{{ $errors->first('production_date') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="work_week">Work Week</label>
                            <input type="text" class="form-control form-control-sm" name="work_week" id="work_week" placeholder="Based on selected date" value="{{ old('work_week') ? old('work_week') : $work_week }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('work_week') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="weekday">Weekday</label>
                            <input type="text" class="form-control form-control-sm" name="weekday" id="weekday" placeholder="Based on selected date" value="{{ old('weekday') ? old('weekday') : $weekday }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('weekday') }}</small>
                        </div>
                    </div>

                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label>Select Shift</label>
                            <p>
                            @foreach($shifts as $shift)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="selected_shifts[]" value="{{$shift->id}}" 
                                @if ($modify == 1 && $sched->associated($shift->id) > 0)
                                checked
                                @endif
                                >
                                <label class="form-check-label" for="defaultCheck1">
                                    {{$shift->code}} - {{$shift->descr}}
                                </label>
                            </div>
                            @endforeach
                            <br>
                            <span class="text-danger" id="shift-label">
                                @if($selected_sched == 0)
                                <small>Product Types will not be saved since no shift is selected.<br>This date will be treated as <strong>RESTDAY</strong>.</small>
                                @endif
                            </span>
                            </p>
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

                <table class="table table-sm table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="table-dark text-center" colspan="{{5 + $lines->count()}}">Product Type Selection</th>
                        </tr>
                        <tr>
                            <th width="5%" rowspan="2">#</th>
                            <th width="{{100 - (($lines->count() * 10) + 45)}}%" rowspan="2">Product Type</th>
                            <th colspan="{{$lines->count()}}" class="text-center">Plan Quantity</th>
                            <th width="15%" rowspan="2">Cell</th>
                            <th width="15%" rowspan="2">Backsheet</th>
                            {{-- <th width="5%" rowspan="2">Default</th> --}}
                        </tr>
                        <tr>
                            @foreach($lines as $line)
                            <th width="10%">Line {{$line->LINCODE}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody id="product-types">
                        @if($products != null && $products->count() > 0)
                            @foreach($products as $product)
                                @if ($loop->first)
                                <tr class="tr-clone">
                                @else
                                <tr>
                                @endif
                                    <td>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="line-item[]" value="1" id="defaultCheck1">
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <select name="product-type[]" class="form-control">
                                                <option disabled selected value> -- select an option -- </option>
                                                @foreach($types as $type)
                                                <option value="{{$type->PRODTYPE}}"
                                                @if($type->PRODTYPE == $product->model_name)
                                                selected="selected"
                                                @endif
                                                >{{$type->PRODTYPE}}</option>
                                                @endforeach
                                            </select>
                                            <span class="form-text text-danger" id="err_product_type[]"></span>
                                        </div>
                                    </td>

                                    @foreach($lines as $line)
                                        <td>
                                            <input type="number" name="line-{{$line->LINCODE}}[]" class="form-control" value="{{$product["line_".$line->LINCODE]}}">
                                        </td>
                                    @endforeach

                                    <td>
                                        <input type="text" name="cell[]" class="form-control" value="{{$product->cell}}">
                                        <span class="form-text text-danger" id="err_cell[]"></span>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <select name="backsheet[]" class="form-control">
                                                <option disabled selected value> -- select an option -- </option>
                                                <option value="Thin"
                                                @if($product->backsheet == "Thin")
                                                selected="selected"
                                                @endif
                                                >Thin</option>
                                                <option value="Thick"
                                                @if($product->backsheet == "Thick")
                                                selected="selected"
                                                @endif
                                                >Thick</option>
                                            </select>
                                            <span class="form-text text-danger" id="err_backsheet[]"></span>
                                        </div>
                                    </td>

                                    {{-- <td class="text-right">
                                        <div class="form-group">
                                            <div class="default-check">
                                                <input class="form-check-input" type="checkbox" name="is-default[]" value="1" id="defaultCheck1">
                                            </div>
                                        </div>
                                    </td> --}}

                                </tr>
                            @endforeach
                        @else
                            <tr class="tr-clone">
                                <td>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="line-item[]" value="1" id="defaultCheck1">
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <select name="product-type[]" class="form-control">
                                            <option disabled selected value> -- select an option -- </option>
                                            @foreach($types as $type)
                                            <option value="{{$type->PRODTYPE}}">{{$type->PRODTYPE}}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-danger" id="err_product_type[]"></span>
                                    </div>
                                </td>

                                @foreach($lines as $line)
                                    <td>
                                        <input type="number" name="line-{{$line->LINCODE}}[]" class="form-control" value="0">
                                    </td>
                                @endforeach

                                <td>
                                    <input type="text" name="cell[]" class="form-control">
                                    <span class="form-text text-danger" id="err_cell[]"></span>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <select name="backsheet[]" class="form-control">
                                            <option disabled selected value> -- select an option -- </option>
                                            <option value="Thin">Thin</option>
                                            <option value="Thick">Thick</option>
                                        </select>
                                        <span class="form-text text-danger" id="err_backsheet[]"></span>
                                    </div>
                                </td>

                                {{-- <td class="text-right">
                                    <div class="form-group">
                                        <div class="default-check">
                                            <input class="form-check-input" type="checkbox" name="is-default[]" value="1" id="defaultCheck1">
                                        </div>
                                    </div>
                                </td> --}}

                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <a href="#" role="button" class="btn btn-success" id="save-trx" style="width: 200px;">{{ $modify == 1 ? 'Update' : 'Create' }} Schedule</a>
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="/planning/schedule" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div>  --}}
</form>
@endsection

@push('jscript')
    <script>
        Date.prototype.getWeek = function() {
            var onejan = new Date(this.getFullYear(),0,1);
            var today = new Date(this.getFullYear(),this.getMonth(),this.getDate());
            var dayOfYear = ((today - onejan +1)/86400000);
            return Math.ceil((dayOfYear+1)/7)
        };

        var $tr;
        function addItem() {
            var $clone = $tr.clone().find("input,select").val("").end();
            $("#product-types").append($clone);
        }

        $(document).ready(function() {
            $tr = $(".tr-clone");

            $("#rem-item").click(function() {
                selected = $('input[name="line-item[]"]:checked');
                if ($(selected).length > 0) {
                    $(selected).closest('tr').remove();
                }
            });

            $("#save-trx").click(function () {
                var validated = true;
                var exists = [];

                if ($("input[name='selected_shifts[]']:checked").length > 0) {
                    $('select[name^="product-type"]').each( function() {
                        i = $('select[name="product-type[]"]').index(this);
                        
                        if ($(this).val() == "" || $(this).val() == null) {
                            $('span[id="err_product_type[]"]').eq(i).html("You have not selected a product type.");
                            validated = false;
                        } else {
                            var qty = 0;

                            @foreach($lines as $line)
                            lq = $('input[name="line-{{$line->LINCODE}}[]"]').eq(i).val();
                            qty += lq;
                            @endforeach

                            if (qty == 0) {
                                $('span[id="err_product_type[]"]').eq(i).html("Plan quantity is not set for this product type.");
                                validated = false;
                            } else {
                                if (exists.indexOf($(this).val()) >= 0) {
                                    $('span[id="err_product_type[]"]').eq(i).html("This product type has already been selected.");
                                    validated = false;
                                } else {
                                    $('span[id="err_product_type[]"]').eq(i).html("");
                                    exists.push($(this).val());
                                    console.log(exists);
                                }
                            }
                        }
                    });

                    $('input[name^="cell"]').each( function() {
                        i = $('input[name="cell[]"]').index(this);
                        
                        if ($(this).val() == "") {
                            $('span[id="err_cell[]"]').eq(i).html("Cell field is required.");
                            validated = false;
                        } else {
                            $('span[id="err_cell[]"]').eq(i).html("");
                        }
                    });

                    $('select[name^="backsheet"]').each( function() {
                        i = $('select[name="backsheet[]"]').index(this);
                        
                        if ($(this).val() == "" || $(this).val() == null) {
                            $('span[id="err_backsheet[]"]').eq(i).html("Backsheet field is required.");
                            validated = false;
                        } else {
                            $('span[id="err_backsheet[]"]').eq(i).html("");
                        }
                    });
                }

                if (validated == true) {
                    $("#SchedForm").submit();
                }
            });

            $("input[name='selected_shifts[]']").change(function() {
                if ($("input[name='selected_shifts[]']:checked").length == 0) {
                    $("#shift-label").html("<small>Product Types will not be saved since no shift is selected.<br>This date will be treated as <strong>RESTDAY</strong>.</small>");
                } else {
                    $("#shift-label").html("");
                }
            })

            $('#production_date').change(function() {
                var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

                var myDate = new Date($(this).val());
                var work_week = myDate.getWeek();
                var ww;

                if (work_week < 10) {
                    ww = "0" + work_week;
                } else {
                    ww = work_week;
                }

                $("#work_week").val("WW" + ww);
                $("#weekday").val(weekday[myDate.getDay()]);
            });
        });
    </script>
@endpush