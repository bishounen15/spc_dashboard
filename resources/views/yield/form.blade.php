@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Yield Data Entry Form</h3>
        <form>
            <div class="card">
                <div class="card-header">
                    General Information
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-3 text-right">Team Selection</div>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-sm" name="team" id="team">
                                            <option disabled selected value> -- select an option -- </option>
                                            @foreach($teams as $pteam)
                                            <option value="{{$pteam['code']}}" 
                                            @if ($pteam['description'] == old('team', $team))
                                                selected="selected"
                                            @endif    
                                            >{{$pteam['description']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-3 text-right">Transaction Date</div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" name="date" id="date" value="{{old('date', $trxdate)}}" disabled>
                                    </div>
                                    <div class="col-sm-3 text-right">Current Shift</div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm"name="shift" id="shift" value="{{old('shift', $shift)}}" disabled>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-3 text-right">Build</div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" disabled>
                                    </div>
                                    <div class="col-sm-3 text-right">Target</div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" disabled>
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
                                            <option disabled selected value> -- select an option -- </option>
                                            <option value="72">72-Cell</option>
                                            <option value="60">60-Cell</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-6 text-right">Input (CELL)</div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="input_cell" id="input_cell" disabled>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-sm-6 text-right">Input (MODULE)</div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="input_mod" id="input_mod" value="{{$input_mod}}" disabled>
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
                            <input type="number" step="1" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">CCD (CELL)</label>
                            <input type="number" step="1" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">Visual Defect (CELL)</label>
                            <input type="number" step="1" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="">BE Defect (CELL)</label>
                            <input type="text" class="form-control form-control-sm" name="cell_defect" id="cell_defect" value="0" disabled>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">BE Class B (CELL)</label>
                            <input type="text" class="form-control form-control-sm" name="cell_class_b" id="cell_class_b" value="0" disabled>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">BE Class C (CELL)</label>
                            <input type="text" class="form-control form-control-sm" name="cell_class_c" id="cell_class_c" value="0" disabled>
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
                                <input type="number" step="1" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label for="">String Defect (STR)</label>
                                <input type="number" step="1" class="form-control form-control-sm">
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
                                <input type="number" step="1" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label for="">EL1 Defect (MTX)</label>
                                <input type="number" step="1" class="form-control form-control-sm">
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
                            <input type="text" class="form-control form-control-sm" name="be_inspected" id="be_inspected" value="{{$be_inspected}}" disabled>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">BE Defect (MOD)</label>
                            <input type="text" class="form-control form-control-sm" name="be_defect" id="be_defect" value="{{$be_defect}}" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="">BE Class B (MOD)</label>
                            <input type="text" class="form-control form-control-sm" name="be_class_b" id="be_class_b" value="{{$be_class_b}}" disabled>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">BE Class C (MOD)</label>
                            <input type="text" class="form-control form-control-sm" name="be_class_c" id="be_class_c" value="{{$be_class_c}}" disabled>
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
                                <input type="text" class="form-control form-control-sm" name="el2_class_a" id="el2_class_a" value="{{$el2_class_a}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">EL2 Defect (MOD)</label>
                                <input type="text" class="form-control form-control-sm" name="el2_defect" id="el2_defect" value="0" disabled>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="form-group">
                                <label for="">EL2 Class B (MOD)</label>
                                <input type="text" class="form-control form-control-sm" name="el2_class_b" id="el2_class_b" value="{{$el2_class_b}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">EL2 Class C (MOD)</label>
                                <input type="text" class="form-control form-control-sm" name="el2_class_c" id="el2_class_c" value="{{$el2_class_c}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">EL2 Low Power (MOD)</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="el2_low_power" id="el2_low_power" value="0" onchange="EL2Defect()">
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
                                <input type="number" step="1" class="form-control form-control-sm" name="man" id="man" onchange="total4M()">
                            </div>
                            <div class="form-group">
                                <label for="">MAC</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="mac" id="mac" onchange="total4M()">
                            </div>
                            <div class="form-group">
                                <label for="">MAT</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="mat" id="mat" onchange="total4M()">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="form-group">
                                <label for="">MET</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="met" id="met" onchange="total4M()">
                            </div>
                            <div class="form-group">
                                <label for="">ENV</label>
                                <input type="number" step="1" class="form-control form-control-sm" name="env" id="env" onchange="total4M()">
                            </div>
                            <div class="form-group">
                                <label for="">Total 4M</label>
                                <input type="text" class="form-control form-control-sm" disabled name="total_4m" id="total_4m" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <button type="submit" class="btn btn-success">Save Employee</button>
                <a href="#" role="button" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
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
            if ($('#product_size').val() != "") { product_size = parseInt($('#product_size').val()); } else { product_size = 0; }
            
            if ($('#be_class_b').val() != "") { be_class_b = parseInt($('#be_class_b').val()); } else { be_class_b = 0; }
            if ($('#be_class_c').val() != "") { be_class_c = parseInt($('#be_class_c').val()); } else { be_class_c = 0; }
            if ($('#el2_class_b').val() != "") { el2_class_b = parseInt($('#el2_class_b').val()); } else { el2_class_b = 0; }
            if ($('#el2_class_c').val() != "") { el2_class_c = parseInt($('#el2_class_c').val()); } else { el2_class_c = 0; }
            
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
        }

        $(document).ready(function() {
            EL2Defect();
        });
    </script>
@endpush