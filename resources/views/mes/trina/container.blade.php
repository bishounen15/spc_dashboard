@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3><i class="fas fa-shipping-fast"></i> TRINA Container Information</h3>
    {{-- <a href="#" role="button" class="btn btn-primary">Create Log Entry</a> --}}
    {{-- <br><br> --}}
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
    <table class="table table-condensed table-striped table-sm" id="cont-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <th>Contract no</th>
            <th>Batch No</th>
            <th>Carton No</th>
            <th>Workorder ID</th>
            <th>Module ID</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Purchase Order</th>
            <th>Country Of Original</th>
            <th>Cell Suppliers</th>
            <th>CONTAINER No</th>
            <th>SEAL.</th>
            <th>BOL.</th>
            <th>Ship destination</th>
            <th>Cells Per Panel</th>
            <th>Production Date</th>
            <th>cell No</th>
            <th>MODULE GRADE</th>
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
            table.ajax.url( '/trina/container/' + $('#start').val() + '/' + $('#end').val() ).load();
        });

        $("#FilterRefresh").click(function() {
            $("#RefreshButton").click();
        });

        $("#FilterButton").click(function() {
            $("#FilterModal").modal('toggle');
        });

        var table = $('#cont-list').DataTable({
            "scrollX": true,
            processing: true,
            "order": [],
            // ajax: '/trina/container/' + $('#start').val() + '/' + $('#end').val(),
            "ajax": {
                "url": '/trina/container/' + $('#start').val() + '/' + $('#end').val(),
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_Container_Info_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_Container_Info_csv"
                },
            ],
            columns: [
                { data: 'Contract no' },
                { data: 'Batch No' },
                { data: 'Carton No' },
                { data: 'Workorder ID' },
                { data: 'Module ID' },
                { data: 'Product ID' },
                { data: 'Product Type' },
                { data: 'Purchase Order' },
                { data: 'Country Of Original' },
                { data: 'Cell Suppliers' },
                { data: 'CONTAINER No' },
                { data: 'SEAL' },
                { data: 'BOL' },
                { data: 'Ship destination' },
                { data: 'Cells Per Panel' },
                { data: 'Production Date' },
                { data: 'cell No' },
                { data: 'MODULE GRADE' },
            ],
        });
    });
</script>
@endpush