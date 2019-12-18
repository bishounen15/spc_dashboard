@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3><i class="fas fa-info-circle"></i> TRINA Module Information</h3>
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Start Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                    
                    <label class="my-1 mr-2" for="end">End Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="end" id="end" value="{{ date('Y-m-d') }}">        
                    
                    <button type="submit" class="btn btn-info my-1" id="FilterButton"><i class="fas fa-filter"></i> Filter Options</button>&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton"><i class="fas fa-sync"></i> Refresh Dashboard</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="mod-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <th>Module ID</th>
            <th>Order ID</th>
            <th>Work Order ID</th>
            <th>Version</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Grade of Cell Power</th>
            <th>Cell Power</th>
            <th>Cell Color</th>
            <th>Cell Eff.</th>
            <th>Module Grade</th>
            <th>EL Grade</th>
            <th>Status</th>
            <th>Carton No.</th>
            <th>Test Line</th>
            <th>Test Date</th>
            <th>Packing Date</th>
            <th>Packing State</th>
            <th>Container No.</th>
            <th>Container Date</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>

    <div class="modal fade" id="FilterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><strong>Filter Results</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FilterParam">
                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Product Type</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                @foreach($product_types as $prodtype)
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{$prodtype->Product_Type}}" name="Product_Type">
                                        <label class="form-check-label" for="Product_Type">
                                            {{$prodtype->Product_Type}}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Work Order ID</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                @foreach($work_orders as $wo)
                                <div class="col-sm-4">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$wo->WorkOrder_ID}}" name="WorkOrder_ID" data-prodtype="{{$wo->Product_Type}}">
                                        <label class="form-check-label" for="Product_Type">
                                            <small>{{$wo->WorkOrder_ID}}</small>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Module Grade</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ModuleGrade" value="All" checked>
                                        <label class="form-check-label" for="ModuleGrade">
                                            All
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ModuleGrade" value="Q1">
                                        <label class="form-check-label" for="ModuleGrade">
                                            Q1
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ModuleGrade" value="Q2">
                                        <label class="form-check-label" for="ModuleGrade">
                                            Q2
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Packing Status</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="PackStatus" value="All" checked>
                                        <label class="form-check-label" for="PackStatus">
                                            All
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="PackStatus" value="Packed">
                                        <label class="form-check-label" for="PackStatus">
                                            Packed
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="PackStatus" value="Not Packed">
                                        <label class="form-check-label" for="PackStatus">
                                            Not Packed
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row">
                        <div class="col-sm-4">
                            <strong>Shipping Status</strong>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ShipStatus" value="All" checked>
                                        <label class="form-check-label" for="ShipStatus">
                                            All
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ShipStatus" value="Shipped">
                                        <label class="form-check-label" for="ShipStatus">
                                            Shipped
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ShipStatus" value="Not Shipped">
                                        <label class="form-check-label" for="ShipStatus">
                                            Not Shipped
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-block" id="FilterRefresh" data-dismiss="modal">Refresh Dashboard</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    $(document).on("change","[name*='Product_Type']", function () {
        if ($("[name*='Product_Type']:checked").length == 0) {
            $("[name*='WorkOrder_ID']").removeAttr("disabled");
        } else {
            $("[name*='WorkOrder_ID']").attr("disabled",true);
        
            $.each($("[name*='Product_Type']:checked"), function(i){
                myProdType = $(this).val();

                $.each($("[name*='WorkOrder_ID']"), function(i){
                    if (myProdType == $(this).data("prodtype")) {
                        $(this).removeAttr("disabled");
                    }
                });
            });
        }
    });

    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/trina/modinfo/' + $('#start').val() + '/' + $('#end').val() ).load();
        });
        
        $("#FilterRefresh").click(function() {
            $("#RefreshButton").click();
        });

        $("#FilterButton").click(function() {
            $("#FilterModal").modal('toggle');
        });

        var table = $('#mod-list').DataTable({
            "scrollX": true,
            processing: true,
            // serverSide: true,
            "order": [],
            // ajax: '/trina/modinfo/' + $('#start').val() + '/' + $('#end').val() ,
            "ajax": {
                "url": '/trina/modinfo/' + $('#start').val() + '/' + $('#end').val() ,
                "type": "GET",
                "data": function(d){
                    pt = "";
                    wo = "";
                    $.each($('#FilterParam').serializeArray(), function(i, obj){
                        if (obj['name'] == "Product_Type" || obj['name'] == "WorkOrder_ID") {
                            if (obj['name'] == "Product_Type") {
                                pt += ((pt == "") ? "" : "|" ) + obj['value'];
                                d['form_' + obj['name']] = pt;
                            } else if (obj['name'] == "WorkOrder_ID") {
                                wo += ((wo == "") ? "" : "|" ) + obj['value'];
                                d['form_' + obj['name']] = wo;
                            }
                        } else {
                            d['form_' + obj['name']] = obj['value'];
                        }
                    });
                },
            }, 
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_module_info_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_module_info_csv"
                },
            ],
            columns: [
                { data: 'Module_ID' },
                { data: 'OrderID' },
                { data: 'WorkOrder_ID' },
                { data: 'WorkOrder_vertion' },
                { data: 'Product_ID' },
                { data: 'Product_Type' },
                { data: 'Grade_of_Cell_Power' },
                { data: 'Cell_Power' },
                { data: 'Cell_Color' },
                { data: 'EFF' },
                { data: 'Module_Grade' },
                { data: 'EL_Grade' },
                { data: 'Status' },
                { data: 'Carton_No' },
                { data: 'Title' },
                { data: 'TEST_DATETIME' },
                { data: 'Packing_Date' },
                { data: 'PackingState' },
                { data: 'Container_no' },
                { data: 'ContainerDate' },
            ],
        });
    });
</script>
@endpush