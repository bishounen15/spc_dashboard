@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? route('modify_cost_center',[$id]) : route('create_cost_center') }}" id="CostCenterForm">
    @csrf 
    <div class="container">
        <h3>Cost Center Creation</h3>
        <div class="card">
            <div class="card-header">Cost Center Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="code">Cost Center Code</label>
                    <input type="text" class="form-control form-control-sm" name="code" id="code" placeholder="Cost Center Code" value="{{ old('code') ? old('code') : $code }}" {{ $modify == 1 ? "readonly" : "" }} autofocus>
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="Description" value="{{ old('description') ? old('description') : $description }}">
                    <small class="form-text text-danger">{{ $errors->first('description') }}</small>
                </div>
                <div class="form-group">
                    <label for="owner">Owner</label>
                    <input type="text" class="form-control form-control-sm" name="owner" id="owner" placeholder="Owner" value="{{ old('owner') ? old('owner') : $owner }}">
                    <small class="form-text text-danger">{{ $errors->first('owner') }}</small>
                </div>
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control form-control-sm" name="designation" id="designation" placeholder="Owner" value="{{ old('designation') ? old('designation') : $designation }}">
                    <small class="form-text text-danger">{{ $errors->first('designation') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="Save Department" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_cost_centers')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection