@extends('layouts.app')
@section('content')
    <h3>Downtime Types for [{{ $machine->descr }}]</h3>
    <a href="#" role="button" class="btn btn-primary" data-toggle="modal" data-target="#InputDowntime">Add Downtime</a>
    <a href="/proddt/setup/machine" role="button" class="btn btn-warning">Back to Machines</a>
    <br><br>
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
                {{-- <th width="10%">#</th> --}}
                <th width="80%">Downtime</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
    </table>

    <div class="modal fade" id="InputDowntime" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Downtime Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="editlink" value="">
                    <label for="downtime">Downtime Description</label>
                    <input type="text" class="form-control" name="downtime" id="downtime">
                    <small class="form-text text-danger" id="err_downtime"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="SaveButton">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
@endsection

@push('jscript')
<script>
    $(document).ready(function () {
        var mc = {{$machine->id}};
        @foreach($categories as $key => $value)
        @if($key == 0)
        var ct = {{$value->id}};
        @endif
        @endforeach

        function SaveDowntime() {
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('machine_id', mc);
            formData.append('category_id', ct);
            formData.append('downtime', $("#downtime").val());

            $.ajax({
                url: "/proddt/setup/machine/" + mc + "/downtime",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (dt) {
                    // console.log(dt.downtime);
                    if (dt.downtime == undefined) {
                        $("#InputDowntime").modal('toggle');
                        $("#downtime").val("");
                        $("#err_downtime").html("");

                        table.ajax.url( '/proddt/setup/downtime/data/' + mc + '/' + ct ).load();
                    } else {
                        $("#err_downtime").html(dt.downtime);
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        }

        function UpdateDowntime(upd_link) {
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('_method', 'put');
            formData.append('machine_id', mc);
            formData.append('category_id', ct);
            formData.append('downtime', $("#downtime").val());
            console.log(upd_link);
            $.ajax({
                url: upd_link,
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (dt) {
                    console.log(dt);
                    if (dt.downtime == undefined) {
                        $("#InputDowntime").modal('toggle');
                        $("#downtime").val("");
                        $("#err_downtime").html("");

                        table.ajax.url( '/proddt/setup/downtime/data/' + mc + '/' + ct ).load();
                    } else {
                        $("#err_downtime").html(dt.downtime);
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        }

        var table = $('#downtime-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '/proddt/setup/downtime/data/' + mc + '/' + ct,
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'Excel',
                    filename: "stations_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'CSV',
                    filename: "stations_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'downtime' },
                // { data: 'descr' },
                // { data: 'machine' },
                // { data: 'capacity' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="#" data-href="/proddt/setup/machine/'+mc+'/downtime/'+full.id+'" role="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#InputDowntime" id="'+full.downtime+'" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="#" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });

        $("#SaveButton").click(function () {
            if ($("#editlink").val() != "") {
                UpdateDowntime($("#editlink").val());
            } else {
                SaveDowntime();
            }
        });

        $(".category-link").click(function() {
            if ($(this).hasClass('active') == false) {
                $(".category-link").removeClass('active');
                
                $(this).addClass('active');
                
                $(".my-tabs").attr('hidden',true);
                $(".tab-" + $(this).attr('id')).removeAttr('hidden');

                ct = $(this).attr('id');
                // table.ajax.reload();
                table.ajax.url( '/proddt/setup/downtime/data/' + mc + '/' + ct ).load();
            }
        });

        $('#InputDowntime').on('show.bs.modal', function(e) {
            // console.log($(e.relatedTarget).data('href'));

            if ($(e.relatedTarget).data('href') != undefined) {
                $("#downtime").val($(e.relatedTarget).attr('id'));
                $("#editlink").val($(e.relatedTarget).data('href'));
            } else {
                $("#downtime").val("");
                $("#editlink").val("");
            }

            $("#err_downtime").html("");
        });
    });
</script>
@endpush