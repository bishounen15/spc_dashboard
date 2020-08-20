@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3>Pack Outs for Backflush</h3>
    <div class="card">
        <div class="card-body">
            
                <div class="form-inline">
                    <label class="my-1 mr-2" for="start">Production Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="start" id="start" value="{{ date('Y-m-d') }}">
                    
                    <button type="submit" class="btn btn-primary my-1" id="RefreshButton">Refresh Report</button>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-striped table-sm" id="test-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>NS WO</th>
            <th>Part No.</th>
            <th>Product</th>
            <th>BOM</th>
            <th>Total Outs</th>
            <th>06</th>
            <th>07</th>
            <th>08</th>
            <th>09</th>
            <th>09</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>13</th>
            <th>15</th>
            <th>16</th>
            <th>17</th>
            <th>18</th>
            <th>19</th>
            <th>20</th>
            <th>21</th>
            <th>22</th>
            <th>23</th>
            <th>00</th>
            <th>01</th>
            <th>02</th>
            <th>03</th>
            <th>04</th>
            <th>05</th>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>
</div>
@endsection

@include('layouts.modal')
@push('jscript')
<script>
    $(document).ready(function() {
        $("#RefreshButton").click(function() {
            table.ajax.url( '/output/test/' + $('#start').val() ).load();
        });

        var table = $('#test-list').DataTable({
            processing: true,
            "scrollX": true,
            "stateSave": true,
            "order": [],
            ajax: '/output/test/' + $('#start').val(),
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28 ]
                    },
                    text:       'Excel',
                    filename: "test_outs_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28 ]
                    },
                    text:       'CSV',
                    filename: "test_outs_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { sortable: false, data: 'NSWO' },
                { sortable: false, data: 'PARTNO' },
                { sortable: false, data: 'MODEL' },
                { sortable: false, data: 'BOM' },
                { sortable: false, data: 'TOTAL' },
                { sortable: false, data: '06' },
                { sortable: false, data: '07' },
                { sortable: false, data: '08' },
                { sortable: false, data: '09' },
                { sortable: false, data: '09' },
                { sortable: false, data: '10' },
                { sortable: false, data: '11' },
                { sortable: false, data: '12' },
                { sortable: false, data: '13' },
                { sortable: false, data: '15' },
                { sortable: false, data: '16' },
                { sortable: false, data: '17' },
                { sortable: false, data: '18' },
                { sortable: false, data: '19' },
                { sortable: false, data: '20' },
                { sortable: false, data: '21' },
                { sortable: false, data: '22' },
                { sortable: false, data: '23' },
                { sortable: false, data: '00' },
                { sortable: false, data: '01' },
                { sortable: false, data: '02' },
                { sortable: false, data: '03' },
                { sortable: false, data: '04' },
                { sortable: false, data: '05' },
            ],
        });
    });
</script>
@endpush