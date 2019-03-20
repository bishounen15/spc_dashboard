@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>Device Information</h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">General Informtation</div>
                <div class="card-body text-center">
                    <img class="card-img-top" height="300px" src="{{$asset->image_path()}}" alt="Card image cap">
                    <hr>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#ServiceRecord">Log Service Record</button>
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
                            @foreach ($asset->partitions as $key => $partition)
                            <tr>
                                <td>{{$key + 1}}</td>
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
                            @foreach ($asset->network as $key => $net)
                            <tr>
                                <td>{{$key + 1}}</td>
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

    <div class="modal fade" id="ServiceRecord" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Service Record</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="trx-id">
                <table class="table table-sm" style="font-size: 0.9em;">
                    <tr>
                        <th>Date Raised:</th>
                        <td>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="date_raised" id="date_raised" value="{{date('Y-m-d')}}">
                            </div>    
                        </td>
                    </tr>
                    <tr>
                        <th>Raised by:</th>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="raised_by" id="raised_by" value="">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Problem Encountered:</th><td>
                            <div class="form-group" id="group-issue">
                                <textarea class="form-control form-control-sm" name="issue_details" id="issue_details" rows="2"></textarea>
                                <small class="form-text text-danger"></small>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th>Date Reported:</th>
                        <td>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="date_reported" id="date_reported" value="">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Reported by:</th>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="reported_by" id="reported_by" value="">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Vendor Commitment:</th><td>
                            <div class="form-group" id="group-issue">
                                <textarea class="form-control form-control-sm" name="vendor_commitment" id="vendor_commitment" rows="2"></textarea>
                                <small class="form-text text-danger"></small>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Commitment Date:</th><td>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="date[]" value="">
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="form-row">
                    <div class="form-group text-right">
                        &nbsp;
                        <a href="#" id="add-item" role="button" class="btn btn-success btn-sm">Add</a>
                        <a href="#" id="rem-item" role="button" class="btn btn-danger btn-sm">Remove</a>
                    </div>
                </div>

                <table class="table table-condensed table-striped table-sm" style="width: 100%;">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                            <th width="10%"></th>
                        <th width="20%">Date</th>
                        <th width="70%">Service Log</th>
                    </thead>
                    <tbody id="item-details" class="tbody-light" style="font-size: 0.75em;">
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="line-item[]" value="1" id="defaultCheck1">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-sm" name="date[]" value="{{date('Y-m-d')}}">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="form-group" id="group-log">
                                        <textarea class="form-control form-control-sm" name="log[]" rows="3"></textarea>
                                        <small class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table table-sm" style="font-size: 0.9em;">
                    <tr>
                        <th>Date Closed:</th>
                        <td>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="date_closed" id="date_closed" value="{{date('Y-m-d')}}">
                            </div>    
                        </td>
                    </tr>
                    <tr>
                        <th>Closed by:</th>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="closed_by" id="closed_by" value="">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Remarks (Optional):</th><td>
                            <div class="form-group" id="group-remarks">
                                <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="3"></textarea>
                                <small class="form-text text-danger"></small>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                {{-- onclick="updateStatus()" --}}
                <button id="btnSave" type="button" class="btn btn-success btn-sm" style="width: 100px;">Save</button> 
                <button id="btnClose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="width: 100px;">Close</button>
            </div>
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