@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Yield Dashboard</h3>
    <a href="{{route('create_yield')}}" role="button" class="btn btn-primary">Add Yield Record</a>

    <table class="table table-condensed table-striped table-sm" id="yield-list" style="width: 100%;">
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
@endsection

@push('jscript')
<script>
    $(document).ready(function() {
        $('#yield-list').DataTable({
            "scrollX": true,
            "order": [],
            ajax: '{!! route('yield_data') !!}',
            // dom: 'Bfrtip',
            // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
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
    });
</script>
@endpush