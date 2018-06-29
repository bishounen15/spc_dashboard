@extends('layouts.app')
@section('content')
<form method="POST" action="#" id="TrxForm"> 
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
                            <input type="text" class="form-control form-control-sm" name="type" id="type" placeholder="Item Description" value="{{ old('type') ? old('type') : $type }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('type') }}</small>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control form-control-sm" name="date" id="date" placeholder="Item Description" value="{{ old('date') ? old('date') : $date }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('date') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control form-control-sm" name="status" id="status" placeholder="Item Description" value="{{ old('status') ? old('status') : $status }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('status') }}</small>
                        </div>
                    </div>
                </div>

                <table class="table table-condensed table-sm" style="font-size: 0.7em;">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Category</th>
                            <th width="30%">Item</th>
                            <th width="10%">Stock</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Unit Cost</th>
                            <th width="10%">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody id="item-list">
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control form-control-sm" name="" id=""></select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control form-control-sm" name="" id=""></select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" readonly>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" readonly>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" readonly>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <div class="form-row">
                <div class="form-group">
                    <a href="#" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    <a href="#" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                </div>
            </div>                
            </div>        
            
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="Save Transaction" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_items')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
    </div> 
</form>
@endsection