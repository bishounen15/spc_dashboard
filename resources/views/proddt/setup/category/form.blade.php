@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? route('modify_category',[$id]) : route('create_category') }}" id="ItemForm">
    @csrf 
    <div class="container">
        <h3>Category Creation</h3>
        <div class="card">
            <div class="card-header">Category Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="code">Category Code</label>
                    <input type="text" class="form-control form-control-sm" name="code" id="code" value="{{ old('code') ? old('code') : $code }}" readonly>
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="Category Description" value="{{ old('description') ? old('description') : $description }}">
                    <small class="form-text text-danger">{{ $errors->first('description') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="Create Category" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_categories')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection