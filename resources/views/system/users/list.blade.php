@extends('layouts.app')
@section('content')
{{-- <div class="container"> --}}
    <h3>User Master</h3>
    <a href="#" role="button" class="btn btn-primary" data-toggle="modal" data-target="#UserCreate">Create User Account</a>
    <br><br>
    <table class="table table-condensed table-striped table-sm" id="user-list" style="width: 100%;">
        <thead class="thead-dark" style="font-size: 0.7em;">
            {{-- <th>#</th> --}}
            <tr class="text-center">
                <th rowspan="2" width="10%">ID Number</th>
                <th rowspan="2" width="25%">Name</th>
                <th rowspan="2" width="15%">Department</th>
                <th rowspan="2" width="15%">Email</th>
                <th colspan="4">User Role</th>
                <th rowspan="2" width="25%">Actions</th>
            </tr>
            <tr class="text-center">
                <th width="5%">OSI</th>
                <th width="5%">YIELD</th>
                <th width="5%">PRODDT</th>
                <th width="5%">ITM</th>
            </tr>
        </thead>
        <tbody class="tbody-light" style="font-size: 0.75em;">
            
        </tbody>
    </table>

    <div class="modal fade" id="UserCreate" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" name="user_id" id="user_id">
                    <small class="form-text text-danger err-msg" id="err_user_id"></small>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name">
                    <small class="form-text text-danger err-msg" id="err_name"></small>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email">
                    <small class="form-text text-danger err-msg" id="err_email"></small>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                    <small class="form-text text-danger err-msg" id="err_password"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="SaveButton">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection

@include('layouts.modal')
@push('jscript')
<script>
    $(document).ready(function() {
        var table = $('#user-list').DataTable({
            "scrollX": true,
            "order": [],
            ajax: '{!! route('user_data') !!}',
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
                { data: 'user_id' },
                { data: 'name' },
                { data: 'description' },
                { data: 'email' },
                { sortable: false, data: 'osi_access' },
                { sortable: false, data: 'yield_access' },
                { sortable: false, data: 'proddt_access' },
                { sortable: false, data: 'assets_access' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm-6"><a href="/user/'+full.id+'" role="button" class="btn btn-sm btn-success" style="width: 100%;">Edit</a></div>' +
                           '<div class="col-sm-6"><a href="#" data-href="/user/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger disabled" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'" style="width: 100%;">Remove</a></div></div>';
                }},
            ],
        });

        $("#SaveButton").click(function () {
            AddUser();
        });

        function AddUser() {
            var token = $('input[name=_token]');
            var formData = new FormData();
            formData.append('user_id', $("#user_id").val());
            formData.append('name', $("#name").val());
            formData.append('email', $("#email").val());
            formData.append('password', $("#password").val());

            $.ajax({
                url: "{!! route('store_user') !!}",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                success: function (dt) {
                    if (dt.user_id == undefined) {
                        $('#sys-messages').html('<div class="alert alert-success" id="success-msg">User [' + $('#user_id').val() + ' - ' + $('#name').val() + '] successfully created.</div>')

                        $("#UserCreate").modal('toggle');
                        $(".form-control").val("");
                        $(".err-msg").html("");

                        table.ajax.reload();
                    } else {
                        $.each(dt, function( index, value ) {
                            $("#err_" + index).html(value[0]);
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    alert (errorThrown);
                }	
            });
        }
    });
</script>
@endpush