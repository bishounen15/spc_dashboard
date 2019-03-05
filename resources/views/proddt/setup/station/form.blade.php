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
                    <input type="text" class="form-control form-control-sm" name="code" id="code" placeholder="Station Code" value="{{ old('code') ? old('code') : $code }}">
                    <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                </div>
                <div class="form-group">
                    <label for="descr">Description</label>
                    <input type="text" class="form-control form-control-sm" name="descr" id="descr" placeholder="Station Description" value="{{ old('descr') ? old('descr') : $descr }}">
                    <small class="form-text text-danger">{{ $errors->first('descr') }}</small>
                </div>
                <div class="form-group">
                    <label for="capacity">Machine</label>
                    <select class="form-control form-control-sm" name="machine_id" id="machine_id">
                        <option readonly selected value> -- select an option -- </option>
                        @foreach($machines as $mac)
                        <option value="{{$mac->id}}" 
                        @if ($mac->id == old('machine_id', $machine_id))
                            selected="selected"
                        @endif    
                        >{{$mac->descr}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('machine_id') }}</small>
                </div>
                <div class="form-group">
                    <label for="production_line">Production Line</label>
                    <select class="form-control form-control-sm" name="production_line" id="production_line">
                        <option readonly selected value> -- select an option -- </option>
                        @foreach($lines as $line)
                        <option value="{{$line->LINCODE}}" 
                        @if ($line->LINCODE == old('production_line', $production_line))
                            selected="selected"
                        @endif    
                        >{{$line->LINDESC}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('production_line') }}</small>
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