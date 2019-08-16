@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>Yield Dashboard</h3>
    @if(Auth::user()->yield_role == 'USER' || Auth::user()->yield_role == 'ADMIN' || Auth::user()->sysadmin == 1)
    <a href="{{route('create_yield')}}" role="button" class="btn btn-primary">Add Yield Record</a>
    <br><br>
    @endif
    <div>
    <table class="table table-condensed table-hover table-sm" id="yield-list" style="width: 100%;">
        <thead class="thead-light" style="font-size: 0.7em;">
            <tr>
                <th colspan="39" class="bg-primary text-white">Filtered Summary</td>
            </tr>
            <tr>
                <th id="summ-yr">-</th>
                <th id="summ-qtr">-</th>
                <th id="summ-wk">-</th>
                <th>-</th>
                <th>-</th>
                <th>-</th>

                <th id="summ-py"></th>
                <th id="summ-ey"></th>
                <th id="summ-srr"></th>
                <th id="summ-mrr"></th>

                <th id="summ-input_cell"></th>
                <th id="summ-input_mod"></th>
                <th id="summ-inprocess_cell"></th>
                <th id="summ-ccd_cell"></th>
                <th id="summ-visualdefect_cell"></th>
                <th id="summ-cell_defect"></th>
                <th id="summ-cell_class_b"></th>
                <th id="summ-cell_class_c"></th>

                <th id="summ-product_size">-</th>
                <th id="summ-str_produced"></th>
                <th id="summ-str_defect"></th>
                <th id="summ-el1_inspected"></th>
                <th id="summ-el1_defect"></th>

                <th id="summ-be_inspected"></th>
                <th id="summ-be_defect"></th>
                <th id="summ-be_class_b"></th>
                <th id="summ-be_class_c"></th>

                <th id="summ-man"></th>
                <th id="summ-mac"></th>
                <th id="summ-mat"></th>
                <th id="summ-met"></th>
                <th id="summ-env"></th>

                <th id="summ-el2_class_a"></th>
                <th>0</th>
                <th id="summ-el2_defect"></th>
                <th id="summ-el2_class_b"></th>
                <th id="summ-el2_class_c"></th>
                <th id="summ-el2_low_power"></th>

                <th id="summ-build">-</th>
                <th id="summ-target">-</th>
            </tr>
            
            <tr>
                <td class="table-primary"><strong>Year</strong></td>
                <td class="table-primary"><strong>Quarter</strong></td>
                <td class="table-primary"><strong>WW</strong></td>
                <td class="table-primary"><strong>WWD</strong></td>
                <td class="table-primary"><strong>Date</strong></td>
                <td class="table-primary"><strong>Line</strong></td>

                <td class="table-default"><strong>PY</strong></td>
                <td class="table-default"><strong>EY</strong></td>
                <td class="table-default"><strong>SRR</strong></td>
                <td class="table-default"><strong>MRR</strong></td>

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
            </tr>
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
            <h5 class="modal-title">Yield Details for <span id="yield-date"></span> <span id="prod-line"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="overflow:auto;">
            <table class="table table-condensed table-hover table-sm" style="width: 100%;">
                <thead class="thead-dark" style="font-size: 0.7em;">
                    <td class="table-default data-edit"></td>

                    <td class="table-default"><strong>Team</strong></td>
                    <td class="table-primary"><strong>Date Start</strong></td>
                    <td class="table-primary"><strong>Date End</strong></td>
                    <td class="table-default"><strong>Trx Date</strong></td>
                    <td class="table-default"><strong>Shift</strong></td>
        
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
        var table = $('#yield-list').DataTable({
            "scrollX": true,
            "stateSave": true,
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
                { data: 'production_line' },
                { data: 'py' },
                { data: 'ey' },
                { data: 'srr' },
                { data: 'mrr' },
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
            ],
            createdRow: function (row, data, index) {
                //
                // if the second column cell is blank apply special formatting
                //
                if (parseFloat(data.py) < parseFloat(data.target)) {
                    $(row).addClass('text-danger');
                }
            },
        });

        table.on( 'search.dt', function () {
            //number of filtered rows
            console.log(table.rows( { filter : 'applied'} ).nodes().length);
            //filtered rows data as arrays
            $filtered = table.rows( { filter : 'applied'} ).data();  
            
            var input_cell = 0;
            var input_mod = 0;

            var py = 0.00;
            var ey = 0.00;
            var srr = 0.00;
            var mrr = 0.00;

            var inprocess_cell = 0;
            var ccd_cell = 0;
            var visualdefect_cell = 0;

            var cell_defect = 0;
            var cell_class_b = 0;
            var cell_class_c = 0;

            var str_produced = 0;
            var str_defect = 0;
            var el1_inspected = 0;
            var el1_defect = 0;

            var be_inspected = 0;
            var be_defect = 0;
            var be_class_b = 0;
            var be_class_c = 0;

            var man = 0;
            var mac = 0;
            var mat = 0;
            var met = 0;
            var env = 0;

            var el2_class_a = 0;
            var el2_defect = 0;
            var el2_class_b = 0;
            var el2_class_c = 0;
            var el2_low_power = 0;

            $.each($filtered, function( index, value ) {
                input_cell += parseInt(value.input_cell);
                input_mod += parseInt(value.input_mod);
                
                py += parseFloat(value.py);
                ey += parseFloat(value.ey);
                srr += parseFloat(value.srr);
                mrr += parseFloat(value.mrr);

                inprocess_cell += parseInt(value.inprocess_cell);
                ccd_cell += parseInt(value.ccd_cell);
                visualdefect_cell += parseInt(value.visualdefect_cell);

                cell_defect += parseInt(value.cell_defect);
                cell_class_b += parseInt(value.cell_class_b);
                cell_class_c += parseInt(value.cell_class_c);

                str_produced += parseInt(value.str_produced);
                str_defect += parseInt(value.str_defect);
                el1_inspected += parseInt(value.el1_inspected);
                el1_defect += parseInt(value.el1_defect);

                be_inspected += parseInt(value.be_inspected);
                be_defect += parseInt(value.be_defect);
                be_class_b += parseInt(value.be_class_b);
                be_class_c += parseInt(value.be_class_c);

                man += parseInt(value.man);
                mac += parseInt(value.mac);
                mat += parseInt(value.mat);
                met += parseInt(value.met);
                env += parseInt(value.env);

                el2_class_a += parseInt(value.el2_class_a);
                el2_defect += parseInt(value.el2_defect);
                el2_class_b += parseInt(value.el2_class_b);
                el2_class_c += parseInt(value.el2_class_c);
                el2_low_power += parseInt(value.el2_low_power);
            });

            $("#summ-input_cell").html(input_cell); 
            $("#summ-input_mod").html(input_mod);
            
            $("#summ-py").html( (py / $filtered.length).toFixed(2) );
            $("#summ-ey").html( (ey / $filtered.length).toFixed(2) );
            $("#summ-srr").html( (srr / $filtered.length).toFixed(2) );
            $("#summ-mrr").html( (mrr / $filtered.length).toFixed(2) );

            $("#summ-inprocess_cell").html(inprocess_cell);
            $("#summ-ccd_cell").html(ccd_cell);
            $("#summ-visualdefect_cell").html(visualdefect_cell);

            $("#summ-cell_defect").html(cell_defect);
            $("#summ-cell_class_b").html(cell_class_b);
            $("#summ-cell_class_c").html(cell_class_c);

            $("#summ-str_produced").html(str_produced);
            $("#summ-str_defect").html(str_defect);
            $("#summ-el1_inspected").html(el1_inspected);
            $("#summ-el1_defect").html(el1_defect);

            $("#summ-be_inspected").html(be_inspected);
            $("#summ-be_defect").html(be_defect);
            $("#summ-be_class_b").html(be_class_b);
            $("#summ-be_class_c").html(be_class_c);

            $("#summ-man").html(man);
            $("#summ-mac").html(mac);
            $("#summ-mat").html(mat);
            $("#summ-met").html(met);
            $("#summ-env").html(env);

            $("#summ-el2_class_a").html(el2_class_a);
            $("#summ-el2_defect").html(el2_defect);
            $("#summ-el2_class_b").html(el2_class_b);
            $("#summ-el2_class_c").html(el2_class_c);
            $("#summ-el2_low_power").html(el2_low_power);
        } );

        $('#yield-list tbody').on( 'click', 'tr', function () {
            var myDate = this.cells[4].innerHTML;
            var prodLine = this.cells[5].innerHTML;
            var d = new Date(myDate);
            $("#yield-date").html(d.toString().substring(0,15));
            $("#prod-line").html();

            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('date', myDate);
            formData.append('prodline', prodLine);
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
                                    disabled = "{{ Auth::user()->sysadmin == 1 ? "" : " disabled"}}";
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
                        if ("SUPV" == "{!! Auth::user()->yield_role !!}" || "ADMIN" == "{!! Auth::user()->yield_role !!}" || 1 == {!! Auth::user()->sysadmin !!}) {
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