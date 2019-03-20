@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? '/planning/setup/shift/' . $id : '/planning/setup/shift' }}" id="ShiftForm">
    @if($modify == 1)
    <input type="hidden" name="_method" value="put" />
    @endif
    @csrf 
    <div class="container">
        <h3>Shift {{ $modify == 1 ? 'Update' : 'Creation' }}</h3>
        <div class="card">
            <div class="card-header">Shift Information</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">Shift Code</label>
                            <input type="text" class="form-control form-control-sm" name="code" id="code" placeholder="Shift Code" value="{{ old('code') ? old('code') : $code }}">
                            <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="descr">Description</label>
                            <input type="text" class="form-control form-control-sm" name="descr" id="descr" placeholder="Description" value="{{ old('descr') ? old('descr') : $descr }}">
                            <small class="form-text text-danger">{{ $errors->first('descr') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="overday">Overday</label>
                            <input type="text" class="form-control form-control-sm" name="overday" id="overday" placeholder="Overday" value="{{ old('overday') ? old('overday') : $overday }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('overday') }}</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_time">Start Time</label>
                            <input type="text" class="form-control form-control-sm time-input" name="start_time" id="start_time" placeholder="HH:MM" value="{{ old('start_time') ? old('start_time') : $start_time }}">
                            <small class="form-text text-danger">{{ $errors->first('start_time') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <input type="text" class="form-control form-control-sm time-input" name="end_time" id="end_time" placeholder="HH:MM" value="{{ old('end_time') ? old('end_time') : $end_time }}">
                            <small class="form-text text-danger">{{ $errors->first('end_time') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" class="form-control form-control-sm" name="duration" id="duration" placeholder="Duration" value="{{ old('duration') ? old('duration') : $duration }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('duration') }}</small>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="{{ $modify == 1 ? 'Update' : 'Create' }} Shift" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="/planning/setup/shift" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection

@push('jscript')
    <script>
        $(document).on('change', '.time-input', function () {
            getOverday();
        });

        function getOverday() {
            var timeStart = $("#start_time").val();
            var timeEnd = $("#end_time").val();

            if (moment(timeStart, 'HH:mm').isValid() && moment(timeEnd, 'HH:mm').isValid()) {
                if (timeStart > timeEnd) {
                    $("#overday").val("Yes");
                } else {
                    $("#overday").val("No");
                }

                getDuration();
            } else {
                $("#overday").val("Invalid Time Range");
            }
        }

        function getDuration() {
            var timeStart = $("#start_time").val();
            var timeEnd = $("#end_time").val();

            if (moment(timeStart, 'HH:mm').isValid() && moment(timeEnd, 'HH:mm').isValid()) {
                tstart = moment('2019-01-01' + ' ' + timeStart);
                tend = moment('2019-01-01' + ' ' + timeEnd);

                if (timeStart < "06:00") {
                    tstart = moment(tstart).add(1, 'days');
                }

                if (timeEnd <= "06:00") {
                    tend = moment(tend).add(1, 'days');
                }

                $("#duration").val(Math.round(((tend - tstart) * 0.00000027778) * 100) / 100);
            } else {
                $("#duration").val(0);
            }
            console.log();
        }
    </script>
@endpush