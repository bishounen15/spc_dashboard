@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Yield Dashboard</h3>
    <a href="{{route('create_yield')}}" role="button" class="btn btn-primary">Add Yield Record</a>
    <br><br>
    <div>
    <table class="table table-condensed table-hover table-sm" id="yield-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            <td class="table-primary"><strong>Year</strong></td>
            <td class="table-primary"><strong>Quarter</strong></td>
            <td class="table-primary"><strong>WW</strong></td>
            <td class="table-primary"><strong>WWD</strong></td>
            <td class="table-primary"><strong>Date</strong></td>

            <td class="table-danger"><strong>Input (CELL)</strong></td>
            <td class="table-success"><strong>Input (MODULE)</strong></td>
            <td class="table-danger"><strong>In-Process (CELL)</strong></td>
            <td class="table-danger"><strong>CCD (CELL)</strong></th>
            <td class="table-danger"><strong>Visual Defect (CELL)</strong></td>
            <td class="table-danger"><strong>BE Defect (CELL)</strong></td>
            <td class="table-danger"><strong>BE Class B (CELL)</strong></td>
            <td class="table-danger"><strong>BE Class C (CELL)</strong></td>

            <td class="table-success"><strong>Product Size</strong></td>
            <td class="table-success"><strong>String Produced (STR)</strong></td>
            <td class="table-success"><strong>String Defect (STR)</strong></td>
            <td class="table-success"><strong>EL1 Inspected (MTX)</strong></td>
            <td class="table-success"><strong>EL1 Defect (MTX)</strong></td>

            <td class="table-info"><strong>BE Inspected (MOD)</strong></td>
            <td class="table-info"><strong>BE Defect (MOD)</strong></td>
            <td class="table-info"><strong>BE Class B (MOD)</strong></td>
            <td class="table-info"><strong>BE Class C (MOD)</strong></td>

            <td class="table-warning"><strong>MAN</strong></td>
            <td class="table-warning"><strong>MAC</strong></td>
            <td class="table-warning"><strong>MAT</strong></td>
            <td class="table-warning"><strong>MET</strong></td>
            <td class="table-warning"><strong>ENV</strong></td>

            <td class="table-info"><strong>EL2 Class A (MOD)</strong></td>
            <td class="table-info"><strong>EL2 Class A w/ Crack (MOD)</strong></td>
            <td class="table-info"><strong>EL2 Defect (MOD)</strong></td>
            <td class="table-info"><strong>EL2 Class B (MOD)</strong></td>
            <td class="table-info"><strong>EL2 Class C (MOD)</strong></td>
            <td class="table-info"><strong>EL2 Low Power (MOD)</strong></td>

            <td class="table-warning"><strong>Build</strong></td>
            <td class="table-success"><strong>Target</strong></td>

            <td class="table-default"><strong>PY</strong></td>
            <td class="table-default"><strong>EY</strong></td>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>
    </div>
</div>

<div class="modal fade" id="yield-details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Yield Details for <span id="yield-date"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="overflow:auto;">
            <table class="table table-condensed table-hover table-sm" style="width: 100%;">
                <thead class="thead-dark" style="font-size: 0.7em;">
                    <td class="table-default data-edit"></td>

                    <td class="table-default data-edit"><strong>Team</strong></td>
                    <td class="table-primary"><strong>Date Start</strong></td>
                    <td class="table-primary"><strong>Date End</strong></td>
                    <td class="table-default data-edit"><strong>Trx Date</strong></td>
                    <td class="table-default data-edit"><strong>Shift</strong></td>
        
                    <td class="table-danger"><strong>Input (CELL)</strong></td>
                    <td class="table-success"><strong>Input (MODULE)</strong></td>
                    <td class="table-danger"><strong>In-Process (CELL)</strong></td>
                    <td class="table-danger"><strong>CCD (CELL)</strong></th>
                    <td class="table-danger"><strong>Visual Defect (CELL)</strong></td>
                    <td class="table-danger"><strong>BE Defect (CELL)</strong></td>
                    <td class="table-danger"><strong>BE Class B (CELL)</strong></td>
                    <td class="table-danger"><strong>BE Class C (CELL)</strong></td>
        
                    <td class="table-success"><strong>Product Size</strong></td>
                    <td class="table-success"><strong>String Produced (STR)</strong></td>
                    <td class="table-success"><strong>String Defect (STR)</strong></td>
                    <td class="table-success"><strong>EL1 Inspected (MTX)</strong></td>
                    <td class="table-success"><strong>EL1 Defect (MTX)</strong></td>
        
                    <td class="table-info"><strong>BE Inspected (MOD)</strong></td>
                    <td class="table-info"><strong>BE Defect (MOD)</strong></td>
                    <td class="table-info"><strong>BE Class B (MOD)</strong></td>
                    <td class="table-info"><strong>BE Class C (MOD)</strong></td>
        
                    <td class="table-warning"><strong>MAN</strong></td>
                    <td class="table-warning"><strong>MAC</strong></td>
                    <td class="table-warning"><strong>MAT</strong></td>
                    <td class="table-warning"><strong>MET</strong></td>
                    <td class="table-warning"><strong>ENV</strong></td>
        
                    <td class="table-info"><strong>EL2 Class A (MOD)</strong></td>
                    <td class="table-info"><strong>EL2 Class A w/ Crack (MOD)</strong></td>
                    <td class="table-info"><strong>EL2 Defect (MOD)</strong></td>
                    <td class="table-info"><strong>EL2 Class B (MOD)</strong></td>
                    <td class="table-info"><strong>EL2 Class C (MOD)</strong></td>
                    <td class="table-info"><strong>EL2 Low Power (MOD)</strong></td>
        
                    <td class="table-warning"><strong>Build</strong></td>
                    <td class="table-success"><strong>Target</strong></td>
        
                    <td class="table-default"><strong>PY</strong></td>
                    <td class="table-default"><strong>EY</strong></td>
                    <td class="table-default"><strong>Encoder</strong></td>
                    <td class="table-default"><strong>Record Created</strong></td>
                </thead>
                <tbody class="tbody-light" id="detail-list" style="font-size: 0.75em;">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
{{-- </div> --}}
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        $('#yield-list').DataTable({
            "scrollX": true,
            "order": [],
            ajax: '{!! route('yield_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    text:       'Excel',
                    filename: "yield_excel"
                },
                {
                    extend:     'csv',
                    text:       'CSV',
                    filename: "yield_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "yield_pdf"
                // },
            ],
            columns: [
                { data: 'yr' },
                { data: 'qtr' },
                { data: 'wk' },
                { data: 'wkd' },
                { data: 'date' },
                { data: 'input_cell' },
                { data: 'input_mod' },
                { data: 'inprocess_cell' },
                { data: 'ccd_cell' },
                { data: 'visualdefect_cell' },
                { data: 'cell_defect' },
                { data: 'cell_class_b' },
                { data: 'cell_class_c' },
                { data: 'product_size' },
                { data: 'str_produced' },
                { data: 'str_defect' },
                { data: 'el1_inspected' },
                { data: 'el1_defect' },
                { data: 'be_inspected' },
                { data: 'be_defect' },
                { data: 'be_class_b' },
                { data: 'be_class_c' },
                { data: 'man' },
                { data: 'mac' },
                { data: 'mat' },
                { data: 'met' },
                { data: 'env' },
                { data: 'el2_class_a' },
                { data: null, defaultContent: '0' },
                { data: 'el2_defect' },
                { data: 'el2_class_b' },
                { data: 'el2_class_c' },
                { data: 'el2_low_power' },
                { data: 'build' },
                { data: 'target' },
                { data: 'py' },
                { data: 'ey' },
            ],
        });

        $('#yield-list tbody').on( 'click', 'tr', function () {
            var myDate = this.cells[4].innerHTML;
            var d = new Date(myDate);
            $("#yield-date").html(d.toString().substring(0,15));

            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('date', myDate);
            $.ajax({
                url: "{{route('yield_per_date')}}",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (trx) {
                    console.log(trx);
                    $("#detail-list").html("")
                    btnclass = "";
                    disabled = "";

                    $.each(trx, function(i, v) {
                        myRows = '<tr>';
                        
                        $.each(v, function(i,v) {
                            // console.log(i);
                            if (i == "edits") {
                                if (v == 0) {
                                    btnclass = "info";
                                    disabled = "";
                                } else if (v == 1) {
                                    btnclass = "warning";
                                    disabled = "";
                                } else if (v == 2) {
                                    btnclass = "danger";
                                    disabled = "";
                                } else {
                                    btnclass = "secondary";
                                    disabled = " disabled";
                                }
                            } else if (i == "id") {
                                myRows += '<td class="data-edit"><a href="/Yield/edit/'+v+'" role="button" class="btn btn-'+btnclass+' btn-sm'+disabled+'">Edit</a></td>';    
                            } else {
                                myRows += '<td>'+ v +'</td>';
                            }
                        });

                        myRows += '</tr>';
                        // console.log(myRows);
                        $("#detail-list").append(myRows);

                        $('table .data-edit').hide();
                        if ("SUPV" == "{!! Auth::user()->yield_role !!}" || 1 == {!! Auth::user()->sysadmin !!}) {
                            $('table .data-edit').show();
                        }
                        $("#yield-details").modal("toggle");
                    });
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        });
    });
</script>
@endpush