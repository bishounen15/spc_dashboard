@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? '/planning/schedule/' . $id : '/planning/schedule' }}" id="SchedForm">
    @if($modify == 1)
    <input type="hidden" name="_method" value="put" />
    @endif
    @csrf 
    <div class="container">
        <h3>Scheduled {{ $modify == 1 ? 'Update' : 'Creation' }}</h3>
        <div class="card">
            <div class="card-header">Schedule Information</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="production_date">Production Date</label>
                            <input type="date" class="form-control form-control-sm" name="production_date" id="production_date" placeholder="Production Date" value="{{ old('production_date') ? old('production_date') : $production_date }}">
                            <small class="form-text text-danger">{{ $errors->first('production_date') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="work_week">Work Week</label>
                            <input type="text" class="form-control form-control-sm" name="work_week" id="work_week" placeholder="Based on selected date" value="{{ old('work_week') ? old('work_week') : $work_week }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('work_week') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="weekday">Weekday</label>
                            <input type="text" class="form-control form-control-sm" name="weekday" id="weekday" placeholder="Based on selected date" value="{{ old('weekday') ? old('weekday') : $weekday }}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('weekday') }}</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="{{ $modify == 1 ? 'Update' : 'Create' }} Shift" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="/planning/schedule" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
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