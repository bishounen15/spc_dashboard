@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h3 class="mb-4">
        <i class="fas fa-check-double"></i> JBOX Code Registration
    </h3>
    <div class="row">
        <div class="col-sm-5">
            <div class="card">
                <div class="card-header">Enter JBOX Registration Details</div>
                <div class="card-body">
                    <div class="form-row mb-2">
                        <div class="col-sm-4">
                            <label for="Module_ID">Module ID</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Module_ID" id="Module_ID">
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col-sm-4">
                            <label for="jCode">JBOX Code</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="jCode" id="jCode">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info btn-block" onclick="VerifyJBOX()"><i class="far fa-check-square"></i> Verify JBOX Code</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">JBOX Code Details</div>
                <div class="card-body">
                    <form id="register-form">

                    <div class="form-row mb-2">
                        <div class="col-sm-4">
                            <label for="Jbox_Suppliers">Supplier</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Jbox_Suppliers" id="Jbox_Suppliers" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col-sm-4">
                            <label for="jbox_Code">JBOX Code</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="jbox_Code" id="jbox_Code" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col-sm-4">
                            <label for="Jbox_MID">JBOX Material ID</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Jbox_MID" id="Jbox_MID" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col-sm-4">
                            <label for="length">Code Length</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="length" id="length" readonly>
                        </div>
                    </div>

                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" id="register-button" class="btn btn-success btn-block" onclick="registerJBOX()"><i class="far fa-check-square"></i> Register JBOX Code</button>
                </div>
            </div>
        </div>

        <div class="col-sm-7">
            <div class="card">
                <div class="card-header">JBOX Code List</div>
                <div class="card-body">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead class="table-dark">
                            <th>Supplier</th>
                            <th>Code</th>
                            <th>Material ID</th>
                            <th>Length</th>
                        </thead>
                        <tbody id="code-list">

                        </tbody>
                    </table>

                    <div class="jumbotron p-3 text-center text-white" style="display: none;">
                        <h3 class="display-6" id="warn-msg"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jscript')
<script>
    function VerifyJBOX() {
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('Module_ID', $("#Module_ID").val());
        formData.append('JBOX_Code', $("#jCode").val());

        $.ajax({
            url: '/trina/jbox/verify',
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (dt) {
                $.each(dt[0][0], function(i, v) {
                    $("#" + i).val(v);
                });

                r = "";
                c = 0;
                reg = 0;

                $.each(dt[1], function(i) {
                    rg = 0;

                    $.each(this, function(i,v) {
                        if ($("#" + i).val() == v) {
                            rg++;
                        }
                    });

                    console.log(rg);
                    if (rg == 4) {
                        reg++;
                    }

                    r += "<tr><td>"+this.Jbox_Suppliers+"</td><td>"+this.jbox_Code+"</td><td>"+this.Jbox_MID+"</td><td>"+this.length+"</td></tr>";
                    c++;
                });
                $("#code-list").html(r);

                if (c > 0) {
                    msg = "";
                    if (reg > 0) {
                        msg = "The code is already regitered";
                        $(".jumbotron").removeClass("bg-danger").addClass("bg-success");
                        $("#register-button").attr("disabled",true);
                    } else {
                        msg = "The listed JBOX Codes will be deleted upon registration of the new JBOX Code.";
                        $(".jumbotron").addClass("bg-danger").removeClass("bg-success");
                        $("#register-button").attr("disabled",false);
                    }
                    $("#warn-msg").html(msg);
                    $(".jumbotron").show();
                } else {
                    $("#warn-msg").html("");
                    $(".jumbotron").hide();
                }
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    }

    function registerJBOX() {
        var token = $('input[name=_token]');
        var formData = new FormData();
        formData.append('Jbox_Suppliers', $("#Jbox_Suppliers").val());
        formData.append('jbox_Code', $("#jbox_Code").val());
        formData.append('Jbox_MID', $("#Jbox_MID").val());
        formData.append('length', $("#length").val());

        $.ajax({
            url: '/trina/jbox/register',
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            success: function (dt) {
                alert("JBOX Registration Successful!" + (dt[1] > 0 ? " " + dt[1] + " code/s were removed from the system." : ""));

                $(".form-control").val("");
                $(".jumbotron").hide();
                $("#code-list").html("");
            },
            error: function(xhr, textStatus, errorThrown){
                alert (errorThrown);
            }	
        });
    }
    
    $(document).ready(function () {
        $("#Module_ID").focus();

        $("#Module_ID").on('keypress',function(e) {
            if(e.which == 13) {
                $("#jCode").focus();
            }
        });
    });
</script>
@endpush