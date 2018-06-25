@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? route('modify_item',[$id]) : route('create_item') }}" id="ItemForm"> 
    @csrf 
    <div class="container">
        <h3>Office Supplies Creation</h3>
        <div class="card">
            <div class="card-header">Item Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="code">Item Code</label>
                    <input type="text" class="form-control form-control-sm" name="code" id="code" value="{{ old('code') ? old('code') : $code }}" readonly>
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="Item Description" value="{{ old('description') ? old('description') : $description }}">
                    <small class="form-text text-danger">{{ $errors->first('description') }}</small>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control form-control-sm" name="category_id" id="category_id">
                                <option readonly selected value> -- select an option -- </option>
                                @foreach($categories as $category)
                                <option value="{{$category['id']}}"
                                @if ($category->id == old('category_id', $category_id))
                                    selected="selected"
                                @endif
                                >{{$category['description']}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-danger">{{ $errors->first('category_id') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="uofm_id">U of M</label>
                            <select class="form-control form-control-sm" name="uofm_id" id="uofm_id">
                                <option readonly selected value> -- select an option -- </option>
                                @foreach($uofms as $uofm)
                                <option value="{{$uofm['id']}}"
                                @if ($uofm->id == old('uofm_id', $uofm_id))
                                    selected="selected"
                                @endif
                                >{{$uofm['code']}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-danger">{{ $errors->first('uofm_id') }}</small>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label for="unit_cost">Unit Cost (PHP)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="unit_cost" id="unit_cost" value="{{ old('unit_cost') ? old('unit_cost') : $unit_cost }}">
                            <small class="form-text text-danger">{{ $errors->first('unit_cost') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="stock_limit">Stock Limit</label>
                            <input type="number" step="1" class="form-control form-control-sm" name="stock_limit" id="stock_limit" value="{{ old('stock_limit') ? old('stock_limit') : $stock_limit }}">
                            <small class="form-text text-danger">{{ $errors->first('stock_limit') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="Create Item" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_items')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection