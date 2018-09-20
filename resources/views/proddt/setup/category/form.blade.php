@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? '/proddt/setup/category/' . $id : '/proddt/setup/category' }}" id="CategoryForm">
    @if($modify == 1)
    <input type="hidden" name="_method" value="put" />
    @endif
    @csrf 
    <div class="container">
        <h3>Category {{ $modify == 1 ? 'Update' : 'Creation' }}</h3>
        <div class="card">
            <div class="card-header">Category Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="code">Category Code</label>
                    <input type="text" class="form-control form-control-sm" name="code" id="code" placeholder="Category Code" value="{{ old('code') ? old('code') : $code }}">
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="descr">Description</label>
                    <input type="text" class="form-control form-control-sm" name="descr" id="descr" placeholder="Category Description" value="{{ old('descr') ? old('descr') : $descr }}">
                    <small class="form-text text-danger">{{ $errors->first('descr') }}</small>
                </div>
                <div class="form-group">
                    <label for="color_scheme">Color Scheme</label>
                    <input type="text" class="form-control form-control-sm" name="color_scheme" id="color_scheme" placeholder="Color Scheme" value="{{ old('color_scheme') ? old('color_scheme') : $color_scheme }}">
                    <small class="form-text text-danger">{{ $errors->first('color_scheme') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="{{ $modify == 1 ? 'Update' : 'Create' }} Category" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="/proddt/setup/category" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection