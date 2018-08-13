@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? route('modify_dept',[$id]) : route('create_dept') }}" id="ItemForm">
    @csrf 
    <div class="container">
        <h3>Department Creation</h3>
        <div class="card">
            <div class="card-header">Department Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="description">Department</label>
                    <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="Department" value="{{ old('description') ? old('description') : $description }}">
                    <small class="form-text text-danger">{{ $errors->first('description') }}</small>
                </div>
                <div class="form-group">
                    <label for="abbrv">Abbreviation</label>
                    <input type="text" class="form-control form-control-sm" name="abbrv" id="abbrv" placeholder="Abbreviation" value="{{ old('abbrv') ? old('abbrv') : $abbrv }}">
                    <small class="form-text text-danger">{{ $errors->first('abbrv') }}</small>
                </div>
                <div class="form-group">
                    <label for="cost_center">Cost Center</label>
                    <input type="text" class="form-control form-control-sm" name="cost_center" id="cost_center" placeholder="Cost Center" value="{{ old('cost_center') ? old('cost_center') : $cost_center }}">
                    <small class="form-text text-danger">{{ $errors->first('cost_center') }}</small>
                </div>
                <div class="form-group">
                    <label for="head">Department Head</label>
                    <input type="text" class="form-control form-control-sm" name="head" id="head" placeholder="Department Head" value="{{ old('head') ? old('head') : $head }}">
                    <small class="form-text text-danger">{{ $errors->first('head') }}</small>
                </div>
                <div class="form-group">
                    <label for="head_email">Dept. Head's Email</label>
                    <input type="text" class="form-control form-control-sm" name="head_email" id="head_email" placeholder="Dept. Head's Email" value="{{ old('head_email') ? old('head_email') : $head_email }}">
                    <small class="form-text text-danger">{{ $errors->first('head_email') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="Save Department" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_depts')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection