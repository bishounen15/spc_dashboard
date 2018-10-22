@extends('layouts.app')
@section('content')
<form method="POST" action="{{$id == null ? route('store_yield') : route('modify_yield',[$id])}}" id="YieldForm"> 
    @csrf 
    <div class="container">
        <h3>Yield Data Entry Form (<span id="range-date">{{$from}} - {{$to}}</span>)</h3>
            <div class="card">
                <div class="card-header">
                    General Information
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-row">
                                    <input type="hidden" name="from" id="from" value="{{$from}}">
                                    <input type="hidden" name="to" id="to" value="{{$to}}">
                                    <div class="col-sm-3 text-right">Team Selection</div>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-sm" name="team" id="team">
                                            <option readonly selected value> -- select an option -- </option>
                                            @foreach($teams as $pteam)
                                            <option value="{{$pteam['code']}}" 
                                            @if ($pteam['code'] == old('team', $team))
                                                selected="selected"
                                            @endif    
                                            >{{$pteam['description']}}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-danger" id="err_team"></small>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-3 text-right">Transaction Date</div>
                                    <div class="col-sm-4">
                                    @if(Auth::user()->yield_role == 'ADMIN' || Auth::user()->sysadmin == 1)
                                        <input type="date" class="form-control form-control-sm" name="date" id="date" value="{{old('date', $trxdate)}}" onchange="changeShift()">
                                    @else
                                        <input type="text" class="form-control form-control-sm" name="date" id="date" value="{{old('date', $trxdate)}}" readonly>
                                    @endif
                                    </div>
                                    <div class="col-sm-2 text-right">Shift</div>
                                    <div class="col-sm-3">
                                    @if(Auth::user()->yield_role == 'ADMIN' || Auth::user()->sysadmin == 1)
                                        <select class="form-control form-control-sm" name="shift" id="shift" onchange="changeShift()">
                                            <option readonly selected value> -- select an option -- </option>
                                            <option value="A" {{$shift == "A" ? "selected" : ""}}>A</option>
                                            <option value="B" {{$shift == "B" ? "selected" : ""}}>B</option>
                                            <option value="C" {{$shift == "C" ? "selected" : ""}}>C</option>
                                            <option value="6AM-6PM" {{$shift == "6AM-6PM" ? "selected" : ""}}>6AM-6PM</option>
                                            <option value="6PM-6AM" {{$shift == "6PM-6AM" ? "selected" : ""}}>6PM-6AM</option>
                                        </select>
                                    @else
                                        <input type="text" class="form-control form-control-sm" name="shift" id="shift" value="{{old('shift', $shift)}}" readonly>
                                    @endif
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-3 text-right">Build</div>
                                    <div class="col-sm-4">
                                        {{-- <input type="text" class="form-control form-control-sm" name="build" id="build" value="GT" readonly> --}}
                                        <select class="form-control form-control-sm" name="build" id="build" onchange="changeBuild()">
                                            <option readonly selected value> -- select an option -- </option>
                                            @foreach ($prod_types as $type)
                                                <option value="{{$type->code}}" {{$prod_types->count() == 1 && $id == null ? "selected" : ($build == $type->code ? "selected" : "")}}>{{$type->code}}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-danger" id="err_build"></small>
                                    </div>
                                    <div class="col-sm-2 text-right">Target (%)</div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" name="target" id="target" value="{{$prod_types->count() == 1 ? number_format($prod_types->first()->target,2) : $target}}" readonly>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-6 text-right">Product Size</div>
                                    <div class="col-sm-6">
                                        <select class="form-control form-control-sm" name="product_size" id="product_size" onchange="inputCELL()">
                                            <option readonly selected value> -- select an option -- </option>
                                            <option value="72" {{$product_size == 72 ? "selected" : ""}}>72-Cell</option>
                                            <option value="60" {{$product_size == 60 ? "selected" : ""}}>60-Cell</option>
                                        </select>
                                        <small class="form-text text-danger" id="err_product_size"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-6 text-right">Input (CELL)</div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="input_cell" id="input_cell" value="{{$input_cell ? $input_cell : ""}}" readonly>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-6 text-right">Input (MODULE)</div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="input_mod" id="input_mod" value="{{$input_mod}}" readonly>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Cell
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="">In-Process (CELL)</label>
                            <input type="number" step="1" class="form-control form-control-sm" name="inprocess_cell" id="inprocess_cell" value="{{$inprocess_cell}}">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">CCD (CELL)</label>
                            <input type="number" step="1" class="form-control form-control-sm" name="ccd_cell" id="ccd_cell" value="{{$ccd_cell}}">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">Visual Defect (CELL)</label>
                            <input type="number" step="1" class="form-control form-control-sm" name="visualdefect_cell" id="visualdefect_cell" value="{{$visualdefect_cell}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="">BE Defect (CELL)</label>
                            <input type="text" class="form-control form-control-sm" name="cell_defect" id="cell_defect" value="{{$cell_defect}}" readonly>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">BE Class B (CELL)</label>
                            <input type="text" class="form-control form-control-sm" name="cell_class_b" id="cell_class_b" value="{{$cell_class_b}}" readonly>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">BE Class C (CELL)</label>
                            <input type="text" class="form-control form-control-sm" name="cell_class_c" id="cell_class_c" value="{{$cell_class_c}}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">String Rework</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">String Produced (STR)</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="str_produced" id="str_produced" value="{{$str_produced}}">
                            </div>
                            <div class="form-group">
                                <label for="">String Defect (STR)</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="str_defect" id="str_defect" value="{{$str_defect}}">
                                <small class="form-text text-danger" id="err_str_defect"></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">Matrix Rework</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">EL1 Inspected (MTX)</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="el1_inspected" id="el1_inspected" value="{{$el1_inspected}}">
                            </div>
                            <div class="form-group">
                                <label for="">EL1 Defect (MTX)</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="el1_defect" id="el1_defect" value="{{$el1_defect}}">
                                <small class="form-text text-danger" id="err_el1_defect"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Laminate Visual Inspection
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="">BE Inspected (MOD)</label>
                            <input type="text" class="form-control form-control-sm" name="be_inspected" id="be_inspected" value="{{$be_inspected}}" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">BE Class B (MOD)</label>
                            <input type="text" class="form-control form-control-sm" name="be_class_b" id="be_class_b" value="{{$be_class_b}}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="">BE Defect (MOD)</label>
                            <input type="text" class="form-control form-control-sm" name="be_defect" id="be_defect" value="{{$be_defect}}" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">BE Class C (MOD)</label>
                            <input type="text" class="form-control form-control-sm" name="be_class_c" id="be_class_c" value="{{$be_class_c}}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Test and EL2
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <div class="form-group">
                                <label for="">EL2 Inspected (MOD)</label>
                                <input type="text" class="form-control form-control-sm" name="el2_class_a" id="el2_class_a" value="{{$el2_class_a}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">EL2 Defect (MOD)</label>
                                <input type="text" class="form-control form-control-sm" name="el2_defect" id="el2_defect" value="{{$el2_defect}}" readonly>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="form-group">
                                <label for="">EL2 Class B (MOD)</label>
                                <input type="text" class="form-control form-control-sm" name="el2_class_b" id="el2_class_b" value="{{$el2_class_b}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">EL2 Class C (MOD)</label>
                                <input type="text" class="form-control form-control-sm" name="el2_class_c" id="el2_class_c" value="{{$el2_class_c}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">EL2 Low Power (MOD)</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="el2_low_power" id="el2_low_power" value="{{$el2_low_power}}" onchange="EL2Defect()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    4M
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <div class="form-group">
                                <label for="">MAN</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="man" id="man" value="{{$man}}" onchange="total4M()">
                            </div>
                            <div class="form-group">
                                <label for="">MAC</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="mac" id="mac" value="{{$mac}}" onchange="total4M()">
                            </div>
                            <div class="form-group">
                                <label for="">MAT</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="mat" id="mat" value="{{$mat}}" onchange="total4M()">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="form-group">
                                <label for="">MET</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="met" id="met" value="{{$met}}" onchange="total4M()">
                            </div>
                            <div class="form-group">
                                <label for="">ENV</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="env" id="env" value="{{$env}}" onchange="total4M()">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="">Total 4M</label>
                                    <input type="text" class="form-control form-control-sm" readonly name="total_4m" id="total_4m" value="{{$total_4m}}">
                                    <small class="form-text text-danger" id="err_total_4m"></small>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Total Defect</label>
                                    <input type="text" class="form-control form-control-sm" readonly name="total_defect" id="total_defect" value="{{$total_defect}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                {{-- <button type="submit" class="btn btn-success">Save Employee</button> --}}
                <a href="#" role="button" class="btn btn-success" id="submit" onclick="Validate()">Save Record</a>
                <a href="{{route('list_yield')}}" role="button" class="btn btn-danger">Cancel</a>
            </div>
    </div>

    <div class="modal fade" id="YieldCompute" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Save Yield Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Do you really want to save the current record?</p>
              <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="">Process Yield % (PY)</label>
                    <input type="text" class="form-control form-control-sm" readonly name="py" id="py" value="0">
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Economic Yield % (EY)</label>
                    <input type="text" class="form-control form-control-sm" readonly name="ey" id="ey" value="0">
                </div>
                <div class="form-group col-sm-6">
                    <label for="">String Rework Rate % (SRR)</label>
                    <input type="text" class="form-control form-control-sm" readonly name="srr" id="srr" value="0">
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Matrix Rework Rate % (MRR)</label>
                    <input type="text" class="form-control form-control-sm" readonly name="mrr" id="mrr" value="0">
                </div>
              </div>
              @if($id != null)
              <div class="form-row">
                <label for="remarks">Reason for Updating</label>
                <textarea class="form-control form-control-sm" name="remarks" id="remarks"></textarea>
                <small class="form-text text-danger" id="err_remarks"></small>
              </div>
              @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="SaveButton">Save Record</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>
@endsection

@push('jscript')
    <script>
        function total4M() {
            if ($('#man').val() != "") { man = parseInt($('#man').val()); } else { man = 0; }
            if ($('#mac').val() != "") { mac = parseInt($('#mac').val()); } else { mac = 0; }
            if ($('#mat').val() != "") { mat = parseInt($('#mat').val()); } else { mat = 0; }
            if ($('#met').val() != "") { met = parseInt($('#met').val()); } else { met = 0; }
            if ($('#env').val() != "") { env = parseInt($('#env').val()); } else { env = 0; }

            $("#total_4m").val(man + mac + mat + met + env);
        }

        function inputCELL() {
            if ($('#input_mod').val() != "") { input_mod = parseInt($('#input_mod').val()); } else { input_mod = 0; }
            if ($('#product_size').val() != null && $("#product_size").val() != "") { product_size = parseInt($('#product_size').val()); } else { product_size = 0; }
            
            if ($('#be_class_b').val() != "") { be_class_b = parseInt($('#be_class_b').val()); } else { be_class_b = 0; }
            if ($('#be_class_c').val() != "") { be_class_c = parseInt($('#be_class_c').val()); } else { be_class_c = 0; }
            if ($('#el2_class_b').val() != "") { el2_class_b = parseInt($('#el2_class_b').val()); } else { el2_class_b = 0; }
            if ($('#el2_class_c').val() != "") { el2_class_c = parseInt($('#el2_class_c').val()); } else { el2_class_c = 0; }
            // if ($('#el2_low_power').val() != "") { el2_low_power = parseInt($('#el2_low_power').val()); } else { el2_low_power = 0; }
            
            $("#input_cell").val(input_mod * product_size);
            $("#cell_class_b").val((be_class_b + el2_class_b) * product_size);
            $("#cell_class_c").val((be_class_c + el2_class_c) * product_size);
            $("#cell_defect").val((parseInt($('#cell_class_b').val()) + parseInt($('#cell_class_c').val())));
        }

        function EL2Defect() {
            if ($('#el2_class_b').val() != "") { el2_class_b = parseInt($('#el2_class_b').val()); } else { el2_class_b = 0; }
            if ($('#el2_class_c').val() != "") { el2_class_c = parseInt($('#el2_class_c').val()); } else { el2_class_c = 0; }
            if ($('#el2_low_power').val() != "") { el2_low_power = parseInt($('#el2_low_power').val()); } else { el2_low_power = 0; }
            
            $("#el2_defect").val(el2_class_b + el2_class_c + el2_low_power);

            totalDefect();
            inputCELL();
        }

        function totalDefect() {
            if ($('#el2_defect').val() != "") { el2_defect = parseInt($('#el2_defect').val()); } else { el2_defect = 0; }
            if ($('#be_defect').val() != "") { be_defect = parseInt($('#be_defect').val()); } else { be_defect = 0; }

            $("#total_defect").val(be_defect + el2_defect);
        }
        
        function YieldCompute() {
            if ($('#input_cell').val() != "") { input_cell = parseInt($('#input_cell').val()); } else { input_cell = 0; }
            if ($('#inprocess_cell').val() != "") { inprocess_cell = parseInt($('#inprocess_cell').val()); } else { inprocess_cell = 0; }
            if ($('#ccd_cell').val() != "") { ccd_cell = parseInt($('#ccd_cell').val()); } else { ccd_cell = 0; }
            if ($('#visualdefect_cell').val() != "") { visualdefect_cell = parseInt($('#visualdefect_cell').val()); } else { visualdefect_cell = 0; }
            if ($('#cell_defect').val() != "") { cell_defect = parseInt($('#cell_defect').val()); } else { cell_defect = 0; }
            if ($('#cell_class_c').val() != "") { cell_class_c = parseInt($('#cell_class_c').val()); } else { cell_class_c = 0; }
            
            if ($('#str_produced').val() != "") { str_produced = parseInt($('#str_produced').val()); } else { str_produced = 0; }
            if ($('#str_defect').val() != "") { str_defect = parseInt($('#str_defect').val()); } else { str_defect = 0; }
            
            if ($('#el1_inspected').val() != "") { el1_inspected = parseInt($('#el1_inspected').val()); } else { el1_inspected = 0; }
            if ($('#el1_defect').val() != "") { el1_defect = parseInt($('#el1_defect').val()); } else { el1_defect = 0; }

            if (input_cell == 0) {
                $("#py").val("0.00");
                $("#ey").val("0.00");
            } else {
                $("#py").val( ( ( (input_cell - (inprocess_cell + ccd_cell + visualdefect_cell + cell_defect) ) / input_cell) * 100 ).toFixed(2) );
                $("#ey").val( ( ( ( input_cell - (inprocess_cell + ccd_cell + visualdefect_cell + cell_class_c) ) / input_cell ) * 100 ).toFixed(2) );
            }
            
            if (str_produced == 0) { $("#srr").val('0.00'); } else { $("#srr").val( ( ( str_defect / str_produced ) * 100 ).toFixed(2) ); }
            if (el1_inspected == 0) { $("#mrr").val('0.00'); } else { $("#mrr").val( ( ( el1_defect / el1_inspected ) * 100 ).toFixed(2) ); }
        }

        function Validate() {
            var err = 0;

            if ($("#team").val() == null || $("#team").val() == "") {
                $("#err_team").html("Team is a required field.");
                err++;
            } else {
                $("#err_team").html("");
            }
            
            if ($("#product_size").val() == null || $("#product_size").val() == "") {
                $("#err_product_size").html("Product Size is a required field.");
                err++;
            } else {
                $("#err_product_size").html("");
            }

            if ($("#build").val() == null || $("#build").val() == "") {
                $("#err_build").html("Build is a required field.");
                err++;
            } else {
                $("#err_build").html("");
            }

            if ($('#str_produced').val() != "") { str_produced = parseInt($('#str_produced').val()); } else { str_produced = 0; }
            if ($('#str_defect').val() != "") { str_defect = parseInt($('#str_defect').val()); } else { str_defect = 0; }

            if (str_defect > str_produced) {
                $("#err_str_defect").html("String Defect must not be greater than String Produced.");
                err++;
            } else {
                $("#err_str_defect").html("");
            }

            if ($('#el1_inspected').val() != "") { el1_inspected = parseInt($('#el1_inspected').val()); } else { el1_inspected = 0; }
            if ($('#el1_defect').val() != "") { el1_defect = parseInt($('#el1_defect').val()); } else { el1_defect = 0; }

            if (el1_defect > el1_inspected) {
                $("#err_el1_defect").html("EL1 Defect must not be greater than EL1 Inspected.");
                err++;
            } else {
                $("#err_el1_defect").html("");
            }

            if ($('#total_4m').val() != "") { total_4m = parseInt($('#total_4m').val()); } else { total_4m = 0; }
            if ($('#total_defect').val() != "") { total_defect = parseInt($('#total_defect').val()); } else { total_defect = 0; }

            if (total_defect != total_4m) {
                $("#err_total_4m").html("Total 4M must be equal to Total Defect.");
                err++;
            } else {
                $("#err_total_4m").html("");
            }

            if (err == 0) {
                YieldCompute();
                $("#YieldCompute").modal("toggle");
            }
        }

        function changeShift() {
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('date', $("#date").val());
            formData.append('shift', $("#shift").val());

            $.ajax({
                url: "{{route('refresh_yield_data')}}",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (details) {
                    
                    $('#range-date').html(details.start + " - " + details.end);
                    $('#from').val(details.start);
                    $('#to').val(details.end);

                    $('#input_mod').val(details.input_mod);
                    $('#be_inspected').val(details.be_inspected);
                    $('#be_defect').val(details.be_defect);
                    $('#be_class_b').val(details.be_class_b);
                    $('#be_class_c').val(details.be_class_c);
                    $('#el2_class_a').val(details.el2_class_a);
                    $('#el2_class_c').val(details.el2_class_c);
                    $('#el2_class_b').val(details.el2_class_b);

                    EL2Defect();
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        }

        function changeBuild() {
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('build', $("#build").val());
            
            $.ajax({
                url: "{{route('product_type_target')}}",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (details) {
                    $('#target').val(details.target.toFixed(2));
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        }

        $(document).ready(function() {
            EL2Defect();

            $("#SaveButton").click(function (e) {
                e.preventDefault();
                @if($id != null)
                if ($("#remarks").val() == null || $("#remarks").val() == "") {
                    $("#err_remarks").html("Reason for Updating is a required field!");
                } else {
                    $("#YieldForm").submit();
                }
                @else
                $("#YieldForm").submit();
                @endif
            });
        });
    </script>
@endpush