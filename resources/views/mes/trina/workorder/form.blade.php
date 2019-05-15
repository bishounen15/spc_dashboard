@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>TRINA Work Order Details - [{{ $wo->WorkOrder_ID }}]</h3>
    <div class="card">
        <div class="card-header">
            Work Order Details
        </div>
        <div class="card-body table-info">
            <div class="form-row">
                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="OrderID">Order ID</label>
                        <input type="text" class="form-control form-control-sm" name="OrderID" id="OrderID" value="{{ $wo->OrderID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>
            
                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="WorkOrder_ID">Work Order ID</label>
                        <input type="text" class="form-control form-control-sm" name="WorkOrder_ID" id="WorkOrder_ID" value="{{ $wo->WorkOrder_ID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="WorkOrder_vertion">Work Order Version</label>
                        <input type="text" class="form-control form-control-sm" name="WorkOrder_vertion" id="WorkOrder_vertion" value="{{ $wo->WorkOrder_vertion }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Product_ID">Product ID</label>
                        <input type="text" class="form-control form-control-sm" name="Product_ID" id="Product_ID" value="{{ $wo->Product_ID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Module_Colour">Module Color</label>
                        @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
                        <select class="form-control form-control-sm" name="Module_Colour" id="Module_Colour">
                            @foreach($modColor as $mc)
                            <option value="{{$mc->descr}}" {{ $mc->descr == $wo->Module_Colour ? "selected" : "" }}>{{$mc->descr}}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="text" class="form-control form-control-sm" name="Module_Colour" id="Module_Colour" value="{{ $wo->Module_Colour }}" readonly>
                        @endif
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Layout_QTY_of_Cell">Layout QTY of Cell</label>
                        <input type="text" class="form-control form-control-sm" name="Layout_QTY_of_Cell" id="Layout_QTY_of_Cell" value="{{ $wo->Layout_QTY_of_Cell }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Cell_MID">Cell MID</label>
                        <input type="text" class="form-control form-control-sm" name="Cell_MID" id="Cell_MID" value="{{ $wo->Cell_MID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Cell_Suppliers">Cell Suppliers</label>
                        @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
                        <select class="form-control form-control-sm" name="Cell_Suppliers" id="Cell_Suppliers">
                            @foreach($cellSup as $cs)
                            <option value="{{$cs->code}}" {{ $cs->code == $wo->Cell_Suppliers ? "selected" : "" }}>{{$cs->descr}}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="text" class="form-control form-control-sm" name="Cell_Suppliers" id="Cell_Suppliers" value="{{ $wo->Cell_Suppliers }}" readonly>
                        @endif
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Cell_Size">Cell Size</label>
                        <input type="text" class="form-control form-control-sm" name="Cell_Size" id="Cell_Size" value="{{ $wo->Cell_Size }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="Cell_Thickness">Cell Thickness</label>
                        <input type="text" class="form-control form-control-sm" name="Cell_Thickness" id="Cell_Thickness" value="{{ $wo->Cell_Thickness }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="BackSheet_MID">BackSheet MID</label>
                        <input type="text" class="form-control form-control-sm" name="BackSheet_MID" id="BackSheet_MID" value="{{ $wo->BackSheet_MID . "@" . $wo->BackSheet_Dec }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="BackSheet_Suppliers">BackSheet Suppliers</label>
                        <input type="text" class="form-control form-control-sm" name="BackSheet_Suppliers" id="BackSheet_Suppliers" value="{{ $wo->BackSheet_Suppliers }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="BackSheet_Thickness">BackSheet Thickness</label>
                        <input type="text" class="form-control form-control-sm" name="BackSheet_Thickness" id="BackSheet_Thickness" value="{{ $wo->BackSheet_Thickness }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="EVA_MID">EVA MID</label>
                        <input type="text" class="form-control form-control-sm" name="EVA_MID" id="EVA_MID" value="{{ $wo->EVA_MID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="EVA_Suppliers">EVA Suppliers</label>
                        <input type="text" class="form-control form-control-sm" name="EVA_Suppliers" id="EVA_Suppliers" value="{{ $wo->EVA_Suppliers }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="OrdinaryEVA_MID">Ordinary EVA MID</label>
                        <input type="text" class="form-control form-control-sm" name="OrdinaryEVA_MID" id="OrdinaryEVA_MID" value="{{ $wo->OrdinaryEVA_MID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="OrdinaryEVA_Suppliers">Ordinary EVA Suppliers</label>
                        <input type="text" class="form-control form-control-sm" name="OrdinaryEVA_Suppliers" id="OrdinaryEVA_Suppliers" value="{{ $wo->OrdinaryEVA_Suppliers }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Glass_MID">Glass MID</label>
                        <input type="text" class="form-control form-control-sm" name="Glass_MID" id="Glass_MID" value="{{ $wo->Glass_MID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Glass_Suppliers">Glass Suppliers</label>
                        <input type="text" class="form-control form-control-sm" name="Glass_Suppliers" id="Glass_Suppliers" value="{{ $wo->Glass_Suppliers }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Jbox_MID">Jbox MID</label>
                        <input type="text" class="form-control form-control-sm" name="Jbox_MID" id="Jbox_MID" value="{{ $wo->Jbox_MID . "@" . $wo->Jbox_Dec }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Jbox_Suppliers">Jbox Suppliers</label>
                        <input type="text" class="form-control form-control-sm" name="Jbox_Suppliers" id="Jbox_Suppliers" value="{{ $wo->Jbox_Suppliers }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Frame_MID">Frame MID</label>
                        <input type="text" class="form-control form-control-sm" name="Frame_MID" id="Frame_MID" value="{{ $wo->Frame_MID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="Frame_Suppliers">Frame Suppliers</label>
                        <input type="text" class="form-control form-control-sm" name="Frame_Suppliers" id="Frame_Suppliers" value="{{ $wo->Frame_Suppliers }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="ShortFrame_MID">Short Frame MID</label>
                        <input type="text" class="form-control form-control-sm" name="ShortFrame_MID" id="ShortFrame_MID" value="{{ $wo->ShortFrame_MID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="ShortFrame_Suppliers">ShortFrame Suppliers</label>
                        <input type="text" class="form-control form-control-sm" name="ShortFrame_Suppliers" id="ShortFrame_Suppliers" value="{{ $wo->ShortFrame_Suppliers }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="IsBonded">Is Bonded?</label>
                        @if(Auth::user()->mes_role == 'PLAN' || Auth::user()->sysadmin == 1)
                        <select class="form-control form-control-sm" name="IsBonded" id="IsBonded">
                            @foreach($isBondedList as $ib)
                            <option value="{{$ib->code}}" {{ $ib->code == $wo->IsBonded ? "selected" : "" }}>{{$ib->descr}}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="text" class="form-control form-control-sm" name="IsBonded" id="IsBonded" value="{{ $wo->IsBonded }}" readonly>
                        @endif
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="bar_type">Bar Type</label>
                        <input type="text" class="form-control form-control-sm" name="bar_type" id="bar_type" value="{{ $wo->bar_type }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="DWorkOrder">DWorkOrder</label>
                        <input type="text" class="form-control form-control-sm" name="DWorkOrder" id="DWorkOrder" value="{{ $wo->DWorkOrder }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="OP_ID">User ID</label>
                        <input type="text" class="form-control form-control-sm" name="OP_ID" id="OP_ID" value="{{ $wo->OP_ID }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="CTCFac">CTCFac</label>
                        <input type="text" class="form-control form-control-sm" name="CTCFac" id="CTCFac" value="{{ $wo->CTCFac }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="CTCStd">CTCStd</label>
                        <input type="text" class="form-control form-control-sm" name="CTCStd" id="CTCStd" value="{{ $wo->CTCStd }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="StringFac">StringFac</label>
                        <input type="text" class="form-control form-control-sm" name="StringFac" id="StringFac" value="{{ $wo->StringFac }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group table-danger">
                        <label for="StringStd">StringStd</label>
                        <input type="text" class="form-control form-control-sm" name="StringStd" id="StringStd" value="{{ $wo->StringStd }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="WorkOrder_Type">WorkOrder Type</label>
                        <input type="text" class="form-control form-control-sm" name="WorkOrder_Type" id="WorkOrder_Type" value="{{ $wo->WorkOrder_Type }}" readonly>
                        {{-- <small class="form-text text-danger">{{ $errors->first('code') }}</small> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        
    });
</script>
@endpush