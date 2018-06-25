@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Office Supplies Inventory</h3>
    <a href="{{route('create_item')}}" role="button" class="btn btn-primary">Create Item</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="item-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <th>Item Code</th>
            <th>Description</th>
            <th>Category</th>
            <th>U of M</th>
            <th>Stock</th>
            <th>Actions</th>
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
        $('#item-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('item_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'Excel',
                    filename: "os_categories_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:       'CSV',
                    filename: "os_categories_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                // { data: 'id' },
                { data: 'code' },
                { data: 'description' },
                { data: 'category' },
                { data: 'uofm' },
                { data: 'current_stock' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/os/item/'+full.id+'" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/os/item/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });
    });
</script>
@endpush