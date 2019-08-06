@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>
        Flash Test Data Report
    </h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <strong>Enter Parameters</strong>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="param-input" id="pallet" value="pallet" checked>
                            <label for="pallet" class="form-check-label"><strong>Filter by Pallet</strong></label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="param-input" id="date" value="date">
                            <label for="date" class="form-check-label"><strong>Filter by Date</strong></label>
                        </div>
                    </div>

                    <div id="grp-pallet">
                        <div class="form-group">
                            <label class="my-1 mr-2" for="palletno">Enter Pallet Numbers (separated by comma[,])</label>
                            <textarea class="form-control form-control-sm" name="palletno" id="palletno" rows="5"></textarea>
                        </div>
                    </div>

                    <div id="grp-date" style="display: none;">
                        <div class="form-group">
                            <label class="my-1 mr-2" for="start">Start Date</label>
                            <input type="date" class="form-control form-control-sm" name="start" id="start" value="{{date('Y-m-d')}}">
                        </div>

                        <div class="form-group">
                            <label class="my-1 mr-2" for="end">End Date</label>
                            <input type="date" class="form-control form-control-sm" name="end" id="end" value="{{date('Y-m-d')}}">
                        </div>

                        <div class="form-group">
                            <label class="my-1 mr-2" for="customer">Customer</label>
                            <select class="form-control form-control-sm" name="customer" id="customer">
                            @foreach ($customers as $customer)
                                <option value="{{$customer->CODE}}">{{$customer->DESC}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="my-1 mr-2">Type</label>

                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="packtype" id="both" value="both" checked>
                                    <label for="both" class="form-check-label">All (Including Not Packed)</label>
                                </div>
        
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="packtype" id="standard" value="standard">
                                    <label for="standard" class="form-check-label">Standard</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="packtype" id="mrb" value="mrb">
                                    <label for="mrb" class="form-check-label">MRB</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-footer">
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Report</button>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <strong>FTD Results</strong>
                </div>

                <table class="table table-sm table-condensed table-striped" id="ftd-list">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        <th>Pallet No.</th>
                        <th>Carton No.</th>
                        <th>Date</th>
                        <th>Product No.</th>
                        <th>Model Name</th>
                        <th>Seq No.</th>
                        <th>Serial No.</th>
                        <th>Module Class</th>
                        <th>Remarks</th>
                        <th>Test Date</th>
                        <th>Bin</th>
                        <th>Power (W)</th>
                        <th>Voc</th>
                        <th>Isc</th>
                        <th>Vmp</th>
                        <th>Imp</th>
                        <th>Rsh</th>
                        <th>FF</th>
                        <th>Pallet Serial No.</th>
                        <th>Cabinet No.</th>
                    </thead>
                    <tbody style="font-size: 0.7em;">

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
        $(document).ajaxStart(function () {  
            $("#RefreshButton").html("Loading Report...");
            $("#RefreshButton").attr("disabled", true);
        });  

        $(document).ajaxStop(function () {  
            $("#RefreshButton").html("Refresh Report");
            $("#RefreshButton").attr("disabled", false);
        });

        $('input[name^="param-input"]').change(function() {
            if ($(this).is(':checked') === true) {
                if ($(this).attr('id') === 'pallet') {
                    $("#grp-pallet").show();
                    $("#grp-date").hide();
                } else {
                    $("#grp-date").show();
                    $("#grp-pallet").hide();
                }
            }
        });

        $("#RefreshButton").click(function() {
            var type = $('input[name="param-input"]:checked').val();

            if (type == "pallet" && ($("#palletno").val() == null || $("#palletno").val() == '')) {
                alert("Please enter Pallet Number/(s)");
            } else {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('palletno', $("#palletno").val());
                formData.append('start', $("#start").val());
                formData.append('end', $("#end").val());
                formData.append('customer', $('#customer').val());
                formData.append('type', $('input[name="packtype"]:checked').val());
                formData.append('param', $('input[name="param-input"]:checked').val());
                
                var tbl = $('#ftd-table').DataTable();
                tbl.clear().draw();

                $.ajax({
                    url: '/mes/ftdreport',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        table.dataTable().fnDestroy();

                        table.DataTable({
                            "scrollX": true,
                            processing: true,
                            "searching": false,
                            "order": [],
                            data: dt,
                            dom: 'Blfrtip',
                            buttons: [
                                {
                                    extend:     'csv',
                                    exportOptions: {
                                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
                                    },
                                    text:       'Download CSV',
                                    filename: "ftd_csv"
                                },
                            ],
                            columns: [
                                // { data: 'id' },
                                { data: 'PalletNo' },
                                { data: 'CartonNo' },
                                { data: 'Date' },
                                { data: 'ProductNo' },
                                { data: 'ModelName' },
                                { data: 'SeqNo' },
                                { data: 'SerialNo' },
                                { data: 'ModuleClass' },
                                { data: 'Remarks' },
                                { data: 'TestDate' },
                                { data: 'Bin' },
                                { data: 'Power' },
                                { data: 'Voc' },
                                { data: 'Isc' },
                                { data: 'Vmp' },
                                { data: 'Imp' },
                                { data: 'Rsh' },
                                { data: 'FF' },
                                { data: 'PALLETSNO' },
                                { data: 'ContainerNo' },
                            ],
                        });
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
            }
        });

        var table = $('#ftd-list');
        table.DataTable({
            "scrollX": true,
            processing: true,
            "searching": false,
            "order": [],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
                    },
                    text:       'Download CSV',
                    filename: "ftd_csv"
                },
            ],
            columns: [
                // { data: 'id' },
                { data: 'Pallet No.' },
                { data: 'Carton No.' },
                { data: 'Date' },
                { data: 'Product No.' },
                { data: 'Model Name' },
                { data: 'Seq No.' },
                { data: 'Serial No.' },
                { data: 'Module Class' },
                { data: 'Remarks' },
                { data: 'Test Date' },
                { data: 'Bin' },
                { data: 'Power (W)' },
                { data: 'Voc' },
                { data: 'Isc' },
                { data: 'Vmp' },
                { data: 'Imp' },
                { data: 'Rsh' },
                { data: 'FF' },
                { data: 'PALLETSNO' },
                { data: 'Container No.' },
            ],
        });
    });
</script>
@endpush