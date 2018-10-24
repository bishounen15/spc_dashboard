@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? '/yield/setup/product_types/' . $id : '/yield/setup/product_types' }}" id="CategoryForm">
    @if($modify == 1)
    <input type="hidden" name="_method" value="put" />
    @endif
    @csrf 
    <div class="container">
        <h3>Product Type {{ $modify == 1 ? 'Update' : 'Creation' }}</h3>
        <div class="card">
            <div class="card-header">Yield Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="code">Product Type Code</label>
                    <input type="text" class="form-control form-control-sm" name="code" id="code" placeholder="Category Code" value="{{ old('code') ? old('code') : $code }}">
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="descr">Description</label>
                    <input type="text" class="form-control form-control-sm" name="descr" id="descr" placeholder="Category Description" value="{{ old('descr') ? old('descr') : $descr }}">
                    <small class="form-text text-danger">{{ $errors->first('descr') }}</small>
                </div>
                <div class="form-group">
                    <label for="target">Target (%)</label>
                    <input type="number" step="0.01" class="form-control form-control-sm" name="target" id="target" value="{{$target}}">
                    <small class="form-text text-danger">{{ $errors->first('target') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="{{ $modify == 1 ? 'Update' : 'Create' }} Product Type" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="/yield/setup/product_types" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection