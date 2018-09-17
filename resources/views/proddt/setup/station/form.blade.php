@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? '/proddt/setup/station/' . $id : '/proddt/setup/station' }}" id="StationForm">
    @if($modify == 1)
    <input type="hidden" name="_method" value="put" />
    @endif
    @csrf 
    <div class="container">
        <h3>Station {{ $modify == 1 ? 'Update' : 'Creation' }}</h3>
        <div class="card">
            <div class="card-header">Station Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="code">Station Code</label>
                    <input type="text" class="form-control form-control-sm" name="code" id="code" placeholder="Machine Code" value="{{ old('code') ? old('code') : $code }}">
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="descr">Description</label>
                    <input type="text" class="form-control form-control-sm" name="descr" id="descr" placeholder="Machine Description" value="{{ old('descr') ? old('descr') : $descr }}">
                    <small class="form-text text-danger">{{ $errors->first('descr') }}</small>
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity per Hour</label>
                    <input type="number" step="1" class="form-control form-control-sm" name="capacity" id="capacity" placeholder="Capacity / Hour" value="{{ old('capacity') ? old('capacity') : $capacity }}">
                    <small class="form-text text-danger">{{ $errors->first('capacity') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="{{ $modify == 1 ? 'Update' : 'Create' }} Station" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="/proddt/setup/station" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection