@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3><i class="fas fa-tasks"></i> TRINA Shipment Information</h3>
    <a href="#" role="button" class="btn btn-success disabled" id="MarkShip" data-toggle="modal" data-target="#ShipModal"><i class="far fa-check-circle"></i> Mark as Shipped</a>
    <br>
    <form id="ShipForm">
        <table class="table table-condensed table-striped table-sm" id="ship-list" style="width: 100%;">
            <thead class="thead-dark">
                <th class="text-center">#</th>
                <th>Container No.</th>
                <th>Work Order</th>
                <th>Product Type</th>
                <th>Date</th>
                <th>Total Cartons</th>
                <th>Is Shipped</th>
            </thead>
            <tbody class="tbody-light">
                
            </tbody>
        </table>
    </form>

    <div class="modal fade" id="ShipModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><strong>Mark as Shipped</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Do you really want to tag the marked containers as <strong>SHIPPED</strong>?
                </p>

                <div class="form-group">
                    <label for="date_shipped">Shipment Date</label>
                    <input type="date" class="form-control form-control-sm" name="date_shipped" id="date_shipped" value="{{ date('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="cipl_no">CIPL No.</label>
                    <input type="text" class="form-control form-control-sm" name="cipl_no" id="cipl_no">
                    <span class="text-danger" id="err_cipl_no"></span>
                </div>

                <div class="form-group">
                    <label for="pl_no">PL No.</label>
                    <input type="text" class="form-control form-control-sm" name="pl_no" id="pl_no">
                    <span class="text-danger" id="err_pl_no"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="ShipButton">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    var selectedContainers;

    $(document).on('change','input[name="ContainerSelect"]',function() {
        var atLeastOneIsChecked = $('input[name="ContainerSelect"]:checked').length;
        if (atLeastOneIsChecked) {
            selectedContainers = "";
            $.each($('input[name="ContainerSelect"]:checked'), function(i){
                selectedContainers += (selectedContainers == "" ? "" : "|") + $(this).val();
            });
            
            $("#MarkShip").removeClass("disabled");
        } else {
            $("#MarkShip").addClass("disabled");
        }
    });

    function clearForm() {
        $("#date_shipped").val("{{ date('Y-m-d') }}");
        $("#cipl_no").val("");
        $("#pl_no").val("");
        $("#err_cipl_no").html("");
        $("#err_pl_no").html("");
    }

    $(document).ready(function() {
        $("#MarkShip").click(function() {
            clearForm();
        });

        $("#ShipButton").click(function(d) {
            if ($("#cipl_no").val() != "" && $("#pl_no").val() != "") {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('containers', selectedContainers);

                $.ajax({
                    url: '/trina/markshipment/' + $("#date_shipped").val() + '/' + $("#cipl_no").val() + '/' + $("#pl_no").val() ,
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    success: function (dt) {
                        $("#MarkShip").addClass("disabled");
                        table.ajax.url( '/trina/ship/load' ).load();
                        $("#ShipModal").modal("toggle");
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert (errorThrown);
                    }	
                });
            } else {
                if ($("#cipl_no").val() == "") {
                    $("#err_cipl_no").html("CIPL Number is required.");
                } else {
                    $("#err_cipl_no").html("");
                }

                if ($("#pl_no").val() == "") {
                    $("#err_pl_no").html("PL Number is required.");
                } else {
                    $("#err_pl_no").html("");
                }
            }
        });

        var table = $('#ship-list').DataTable({
            // "scrollX": true,
            "stateSave": true,
            processing: true,
            "order": [],
            ajax: '/trina/ship/load',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6 ]
                    },
                    text:       'Excel',
                    filename: "TRINA_shipping_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6 ]
                    },
                    text:       'CSV',
                    filename: "TRINA_shipping_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="form-check text-center"><input class="form-check-input" type="checkbox" name="ContainerSelect" value="'+full.Container_no+'"'+(full.IsShipped == "Yes" ? " disabled" : "")+'></div>';
                }},
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<a href="/trina/shipment/'+full.Container_no+'">'+full.Container_no+'</a>';
                }},
                { data: 'WO' },
                { data: 'Product_Type' },
                { data: 'Container_Time' },
                { data: 'TotalCarton' },
                { data: 'IsShipped' },
            ],
            createdRow: function (row, data, index) {
                if (data.IsShipped == "Yes") {
                    $(row).addClass('table-success');
                } else {
                    $(row).addClass('table-warning');
                }
            },
        });
    });
</script>
@endpush