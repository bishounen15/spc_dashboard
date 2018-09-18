@extends('layouts.app')
@section('content')
    <h3>Downtime Types for [{{ $station->descr }}]</h3>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs nav-fill">
                @foreach($categories as $key => $value)
                <li class="nav-item">
                    <a class="category-link nav-link{{ $key == 0 ? " active" : "" }}" id="{{$value->id}}" href="#">{{$value->descr}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    
    <div class="row">
    @foreach($categories as $key => $value)
    <div class="col-sm-12 my-tabs tab-{{$value->id}} "{{ $key == 0 ? "" : " hidden" }}>
        <div class="card">
            <div class="card-header{{ " bg-" . $value->color_scheme }} text-white">
                <strong>Downtime List for {{$value->descr}}</strong>
            </div>
        </div>
    </div>
    @endforeach
    </div>

    <table class="table table-condensed table-striped table-sm" id="downtime-list">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="70%">Downtime</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
    </table>
@endsection

@push('jscript')
<script>
    $(document).ready(function () {
        $(".category-link").click(function() {
            if ($(this).hasClass('active') == false) {
                $(".category-link").removeClass('active');
                
                $(this).addClass('active');
                
                $(".my-tabs").attr('hidden',true);
                $(".tab-" + $(this).attr('id')).removeAttr('hidden');
            }
        });
    });
</script>
@endpush