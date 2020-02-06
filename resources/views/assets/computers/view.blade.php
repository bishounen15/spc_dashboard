@extends('layouts.app')
@section('content')
    <h3>Device Information</h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">General Informtation</div>
                <div class="card-body text-center">
                    <img class="card-img-top" height="300px" src="{{$asset->image_path()}}" alt="Card image cap">
                    <hr>
                    {{$asset->brand . " " . $asset->device_model()}} <br>
                    {{$asset->serial}} <br>
                    {{$asset->host_name}} <br>
                    {{$asset->status . " " . $asset->type}} <br>
                    {{$asset->device_status}} <br>
                    <hr>
                    <strong>Accountability</strong> <br>
                    {{$asset->id_number . " - " . $asset->name}} <br>
                    {{$asset->dept}} <br>
                    {{$asset->site . (($asset->sub_site == null || $asset->sub_site == '') ? "" : " - " . $asset->sub_site)}} <br>
                    @if ($asset->remarks != null || $asset->remarks != '')
                        <hr>
                        <strong>Remarks</strong> <br>
                        {{$asset->remarks}}
                    @endif
                    @if ($asset->updated_at != null)
                        <hr>
                        <strong>Last Scan Date</strong> <br>
                        {{$asset->updated_at}}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">Device Specifications</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="35%">Operating System</th>
                            <td width="65%">{{$asset->os}}</td>
                        </tr>

                        <tr>
                            <th width="35%">Processor</th>
                            <td width="65%">{{$asset->proc}}</td>
                        </tr>

                        <tr>
                            <th width="35%">Memory</th>
                            <td width="65%">{{$asset->ram}}</td>
                        </tr>

                        <tr>
                            <th width="35%">HDD Capacity</th>
                            <td width="65%">{{$asset->hdd}}</td>
                        </tr>

                        <tr>
                            <th width="35%">Graphics Card</th>
                            <td width="65%">{{$asset->gfx_card}}</td>
                        </tr>

                        <tr>
                            <th width="35%">User Accounts</th>
                            <td width="65%">{{$asset->user_accounts}}</td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="4" class="text-center">HDD Partitions</th>
                            </tr>
                            <tr>
                                <th width="10%">#</th>
                                <th width="30%">Root Directory</th>
                                <th width="30%">Capacity</th>
                                <th width="30%">Free Space</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asset->partitions as $partition)
                            <tr>
                                <td>#</td>
                                <td>{{$partition->root_dir}}</td>
                                <td>{{$partition->capacity}}</td>
                                <td>{{$partition->free_space}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <br>
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="6" class="text-center">Network Interface</th>
                            </tr>
                            <tr>
                                <th width="10%">#</th>
                                <th width="20%">IP Address</th>
                                <th width="20%">Mac Address</th>
                                <th width="20%">Name</th>
                                <th width="20%">Description</th>
                                <th width="10%">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asset->network as $net)
                            <tr>
                                <td>#</td>
                                <td>{{$net->ip}}</td>
                                <td>{{$net->mac}}</td>
                                <td>{{$net->name}}</td>
                                <td>{{$net->descr}}</td>
                                <td>{{$net->interface}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Software Installed</div>
                <div class="card-body">
                    <table class="table table-sm" id="software-list">
                        <thead class="thead-dark">
                            <tr>
                                <th width="10%">#</th>
                                <th width="20%">Install Date</th>
                                <th width="30%">Application Name</th>
                                <th width="20%">Version</th>
                                <th width="20%">Install Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        var t = $('#software-list').DataTable({
            "columnDefs": [ {
                "targets": 0
            } ],
            "scrollX": true,
            "order": [],
            ajax: '{{ "/assets/software/" . $asset->id }}',
            dom: 'Blfrtip',
            buttons: [
                // "print",
                // {
                //     extend:     'excel',
                //     exportOptions: {
                //         columns: [ 0, 1, 2, 3, 4 ]
                //     },
                //     text:       'Excel',
                //     filename: "sw_excel"
                // },
                // {
                //     extend:     'csv',
                //     exportOptions: {
                //         columns: [ 0, 1, 2, 3, 4 ]
                //     },
                //     text:       'CSV',
                //     filename: "sw_csv"
                // },
                // // {
                // //     extend:     'pdf',
                // //     text:       'PDF',
                // //     filename: "os_categories_pdf"
                // // },
            ],
            columns: [
                { data: null, defaultContent: '0' },
                { data: 'install_date' },
                { data: 'app_name' },
                { data: 'version' },
                { data: 'install_type' },
            ],
        });

         t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endpush