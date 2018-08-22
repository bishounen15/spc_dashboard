@extends('layouts.app')
@section('content')
<form method="POST" action="{{route('store_email_yield')}}" id="EmailForm">
    @csrf 
    <div class="container">
        <h3>Email Distribution</h3>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">Add Email Address</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Enter Email Address</label>
                            <input type="email" class="form-control form-control-sm" name="email" id="email" value="{{ old('email') ? old('email') : $email }}" autofocus>
                            <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <input type="submit" class="btn btn-success" name="add" id="add" value="Add Email Address" style="width: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">Email Distribution List</div>
                    <div class="card-body">
                        <table class="table table-sm table-hover" id="email-list" style="width: 100%;">
                            <thead class="thead-dark" style="font-size: 0.7em;">
                                <th width="75%">Email Address</th>
                                <th width="25%">Actions</th>
                            </thead>
                            <tbody class="tbody-light">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection

@include('layouts.modal')
@push('jscript')
<script>
    var table;
    
    $(document).ready(function() {
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $("#descr").html($(e.relatedTarget).attr('id'));
            $(this).find('.btn-yes').attr('href', $(e.relatedTarget).data('href'));
        });

        // $(".remove-record").click(function (e) {
        //     e.preventDefault();
        //     $.post( $(this).attr("href") );
        // });

        table = $('#email-list').DataTable({
            // "scrollX": true,
            "order": [],
            ajax: '{!! route('email_yield_data') !!}',
            dom: 'Blfrtip',
            buttons: [
                // "print",
                {
                    extend:     'excel',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'Excel',
                    filename: "email_list_excel"
                },
                {
                    extend:     'csv',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    text:       'CSV',
                    filename: "email_list_csv"
                },
                // {
                //     extend:     'pdf',
                //     text:       'PDF',
                //     filename: "os_categories_pdf"
                // },
            ],
            columns: [
                { data: 'email' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<a href="#" data-href="/yield/email/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete" id="'+full.email+'" style="width: 100%;">Remove</a>';
                }},
            ],
        });
    });
</script>
@endpush