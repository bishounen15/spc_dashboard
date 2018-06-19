@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Link Account from Web Portal</h3>
    <div class="container">
        <div class="alert alert-danger text-center" id="alert-msg" style="display: none;"></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Web Portal Authentication</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm">
                            <label for="USERID">Employee Number</label>
                            <input type="text" class="form-control" name="USERID" id="USERID" placeholder="Enter your Employee Number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm">
                            <label for="PASSWORD">Password</label>
                            <input type="password" class="form-control" name="PASSWORD" id="PASSWORD" placeholder="Enter password from Web Portal">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card">
                        {{-- <input type="submit" class="btn btn-success" value="Authenticate User"> --}}
                        <a href="#" role="button" class="btn btn-success" onclick="Authenticate()">Authenticate Account</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <form action="{{route('link_account')}}" id="link-form" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">Web Portal Account Details</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" readonly>
                            <input type="hidden" name="uid" id="uid">
                            <input type="hidden" name="pwd" id="pwd">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm">
                            <label for="dept">Department</label>
                            <input type="text" name="dept" id="dept" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card">
                        <a href="#" id="link-acct" role="button" class="btn btn-info disabled" onclick="LinkAccount()">Link Account</a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    function LinkAccount() {
        $("#link-form").submit();
    }

    function Authenticate() {
        var token = $('input[name=_token]');

        var formData = new FormData();
        formData.append('USERID', $("#USERID").val());
        formData.append('PASSWORD', $("#PASSWORD").val());
        
        $.ajax({
            url: "{{route('check_account')}}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (user) {
                if (user != null) {
                    row = user;

                    if (row.USERNAME != null) {
                        $("#name").val(row.USERNAME);
                        $("#dept").val(row.DEPDESC);
                        $("#uid").val($("#USERID").val());
                        $("#pwd").val($("#PASSWORD").val());
                        
                        if (row.EXISTING == 1) {
                            $("#link-acct").addClass("disabled");
                            $("#alert-msg").removeClass('alert-success').addClass('alert-danger');
                            $("#alert-msg").html('This account is already registered in the system.');
                            $("#alert-msg").show();
                        } else {
                            $("#link-acct").removeClass("disabled");
                            $("#alert-msg").removeClass('alert-danger').addClass('alert-success');
                            $("#alert-msg").html('Authentication Successfull. Click Link Account Button to Link your Account from Web Portal.');
                            $("#alert-msg").show();
                        }
                    } else {
                        $("#name").val("");
                        $("#dept").val("");
                        $("#uid").val("");
                        $("#pwd").val("");

                        $("#link-acct").addClass("disabled");
                        $("#alert-msg").removeClass('alert-success').addClass('alert-danger');
                        $("#alert-msg").html('This account is not found in the web portal. Check Employee Number / Password.');
                        $("#alert-msg").show();
                    }
                } else {
                    $("#name").val("");
                    $("#dept").val("");
                    $("#uid").val("");
                    $("#pwd").val("");

                    $("#link-acct").addClass("disabled");
                    $("#alert-msg").removeClass('alert-success').addClass('alert-danger');
                    $("#alert-msg").html('This account is not found in the web portal. Check Employee Number / Password.');
                    $("#alert-msg").show();
                }
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    }
</script>
@endpush