@extends('layouts.app')
@section('content')
<form method="POST" action="{{ $modify == 1 ? '/proddt/logsheet/' . $id : '/proddt/logsheet' }}" id="StationForm">
    @if($modify == 1)
    <input type="hidden" name="_method" value="put" />
    @endif
    @csrf 
    <div class="container">
        <h3>{{ $modify == 1 ? 'Update' : 'Create' }} Log Entry</h3>
        <div class="card">
            <div class="card-header">Downtime Information</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control form-control-sm" name="date" id="date" value="{{ old('date') ? old('date') : $date }}">
                            <small class="form-text text-danger">{{ $errors->first('date') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="shift">Shift</label>
                            <input type="text" class="form-control form-control-sm" name="shift" id="shift" placeholder="Shift will be generated based on Time Start" value="{{old('shift', $shift)}}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('shift') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="start">Time Start</label>
                            <input type="text" class="form-control form-control-sm" name="start" id="start" placeholder="Enter the time in format (HH:MM)" value="{{ old('start') ? old('start') : $start }}">
                            <small class="form-text text-danger">{{ $errors->first('start') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="end">Time End</label>
                            <input type="text" class="form-control form-control-sm" name="end" id="end" placeholder="Enter the time in format (HH:MM)" value="{{old('end', $end)}}">
                            <small class="form-text text-danger">{{ $errors->first('end') }}</small>
                        </div>  

                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" class="form-control form-control-sm" name="duration" id="duration" placeholder="Computed based on Time Start and Time End" value="{{old('duration', $duration)}}" readonly>
                            <small class="form-text text-danger">{{ $errors->first('duration') }}</small>
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="form-group">
                            <label for="station_id">Station</label>
                            <select class="form-control form-control-sm" name="station_id" id="station_id">
                                <option readonly selected value> -- select an option -- </option>
                                @foreach($stations as $station)
                                <option value="{{$station->id}}"
                                @if ($station->id == old('station_id', $station_id))
                                    selected="selected"
                                @endif
                                >{{$station->descr}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-danger">{{ $errors->first('station_id') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control form-control-sm" name="category_id" id="category_id">
                                <option readonly selected value> -- select an option -- </option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                @if ($category->id == old('category_id', $category_id))
                                    selected="selected"
                                @endif
                                >{{$category->descr}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-danger">{{ $errors->first('category_id') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="downtime_id">Issue</label>
                            <select class="form-control form-control-sm" name="downtime_id" id="downtime_id">
                                <option readonly selected value> -- select an option -- </option>
                                @foreach($issues as $issue)
                                <option value="{{$issue->id}}"
                                @if ($issue->id == old('downtime_id', $downtime_id))
                                    selected="selected"
                                @endif
                                >{{$issue->descr}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-danger">{{ $errors->first('downtime_id') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="5">{{old('remarks', $remarks)}}</textarea>
                            <small class="form-text text-danger">{{ $errors->first('remarks') }}</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">

                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="{{ $modify == 1 ? 'Update' : 'Create' }} Log Entry" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="/proddt/logsheet" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection

@push('jscript')
<script>
    $(document).on('change', '#start', function () {
        var timeStart = $(this).val();
        if (moment(timeStart, 'HH:mm').isValid()) {
            if (timeStart >= "06:00" && timeStart < "14:00") {
                $("#shift").val("A");
            } else if (timeStart >= "14:00" && timeStart < "22:00") {
                $("#shift").val("B");
            } else {
                $("#shift").val("C");
            }
        } else {
            $("#shift").val("Invalid Time Start");
        }
        getDuration();
    });

    $(document).on('change', '#end', function () {
        getDuration();
    });

    function getDuration() {
        var timeStart = $("#start").val();
        var timeEnd = $("#end").val();

        if (moment(timeStart, 'HH:mm').isValid() && moment(timeEnd, 'HH:mm').isValid()) {
            tstart = moment($("#date").val() + ' ' + timeStart);
            tend = moment($("#date").val() + ' ' + timeEnd);

            if (timeStart < "06:00") {
                tstart = moment(tstart).add(1, 'days');
            }

            if (timeEnd < "06:00") {
                tend = moment(tend).add(1, 'days');
            }

            $("#duration").val(Math.round(((tend - tstart) * 0.00000027778) * 100) / 100);
        } else {
            $("#duration").val(0);
        }
        console.log();
    }

    $(document).on('change', 'select[name="station_id"]', function(index) {
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('station_id', $(this).val());

        $.ajax({
            url: "{{route('get_dtcategory_list')}}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (items) {
                selitems = "<option disabled selected value> -- select an option -- </option>";
                $('select[name="downtime_id"]').html(selitems);
                $.each(items, function(i, v) {
                    selitems += '<option value="' + v.id + '">' + v.descr + '</option>';
                });
                $('select[name="category_id"]').html(selitems);
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    });

    $(document).on('change', 'select[name="category_id"]', function(index) {
        var token = $('input[name=_token]');
        var formData = new FormData();
        console.log($("#station_id").val());
        formData.append('station_id', $("#station_id").val());
        formData.append('category_id', $(this).val());

        $.ajax({
            url: "{{route('get_dtissue_list')}}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (items) {
                selitems = "<option disabled selected value> -- select an option -- </option>";
                $.each(items, function(i, v) {
                    selitems += '<option value="' + v.id + '">' + v.downtime + '</option>';
                });
                $('select[name="downtime_id"]').html(selitems);
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    });
</script>
@endpush