@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? route('modify_uofm',[$id]) : route('create_uofm') }}" id="UofMForm">
    @csrf 
    <div class="container">
        <h3>UOFM Creation</h3>
        <div class="card">
            <div class="card-header">UOFM Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="code">UOFM Code</label>
                    <input type="text" class="form-control form-control-sm" name="code" id="code" placeholder="U of M Code" value="{{ old('code') ? old('code') : $code }}" {{ $modify == 1 ? "readonly" : "" }}>
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="U of M Description" value="{{ old('description') ? old('description') : $description }}">
                    <small class="form-text text-danger">{{ $errors->first('description') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="Create U of M" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_uofm')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection