@extends('layouts.app')
@section('content')
<form method="POST" action="{{route('modify_user',[$id])}}" id="UserForm">
    @csrf 
    <div class="container">
        <h3>Update User</h3>
        <div class="card">
            <div class="card-header">User Information</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="description">Employee ID</label>
                    <input type="text" class="form-control form-control-sm" name="user_id" id="user_id" placeholder="User ID" value="{{ old('user_id') ? old('user_id') : $user_id }}" readonly>
                    <small class="form-text text-danger">{{ $errors->first('user_id') }}</small>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="User Name" value="{{ old('name') ? old('name') : $name }}">
                    <small class="form-text text-danger">{{ $errors->first('name') }}</small>
                </div>
                <div class="form-group">
                    <label for="dept_id">Department</label>
                    <select class="form-control form-control-sm" name="dept_id" id="dept_id">
                        <option readonly selected value> -- select an option -- </option>
                        @foreach($depts as $dept)
                        <option value="{{$dept['id']}}"
                        @if ($dept->id == old('dept_id', $dept_id))
                            selected="selected"
                        @endif
                        >{{$dept['description']}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('dept_id') }}</small>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email Address" value="{{ old('email') ? old('email') : $email }}">
                    <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sysadmin" id="sysadmin" {{old('sysadmin', $sysadmin) == 1 ? "checked" : ""}}>
                    <label class="form-check-label" for="defaultCheck1">
                        Check this is the user is a System Administrator
                    </label>
                </div>
                <br>
                <table class="table">
                    <tr>
                        <th colspan="4" class="table-dark text-center">User Access</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="table-light">Office Supplies Inventory</th>
                    </tr>
                    <tr>
                        <td width="20%">With Access</td>
                        <td width="20%" class="text-center">
                            <input type="checkbox" name="osi_access" id="osi_access" {{old('osi_access', $osi_access) == 1 ? "checked" : ""}}>    
                        </td>
                        <td width="20%">User Role</td>
                        <td width="40%">
                                <select class="form-control form-control-sm" name="osi_role" id="osi_role" {{old('yield_access', $yield_access) == 1 ? "" : "disabled"}}>
                                    <option readonly selected value> -- select an option -- </option>
                                    @foreach($o_roles as $orole)
                                    <option value="{{$orole['code']}}" 
                                    @if ($orole['code'] == old('osi_role', $osi_role))
                                        selected="selected"
                                    @endif    
                                    >{{$orole['description']}}</option>
                                    @endforeach
                                </select>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="4" class="table-light">Yield Dashboard</th>
                    </tr>
                    <tr>
                        <td width="20%">With Access</td>
                        <td width="20%" class="text-center">
                            <input type="checkbox" name="yield_access" id="yield_access" {{old('yield_access', $yield_access) == 1 ? "checked" : ""}}>    
                        </td>
                        <td width="20%">User Role</td>
                        <td width="40%">
                                <select class="form-control form-control-sm" name="yield_role" id="yield_role" {{old('yield_access', $yield_access) == 1 ? "" : "disabled"}}>
                                        <option readonly selected value> -- select an option -- </option>
                                        @foreach($y_roles as $yrole)
                                        <option value="{{$yrole['code']}}" 
                                        @if ($yrole['code'] == old('yield_role', $yield_role))
                                            selected="selected"
                                        @endif    
                                        >{{$yrole['description']}}</option>
                                        @endforeach
                                </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="Save Changes" style="width: 200px;">
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <a href="{{route('list_users')}}" role="button" class="btn btn-danger" style="width: 200px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection

@push('jscript')
    <script>
        $(document).ready(function() {
            $("#osi_access").click(function () {
                var el = $("#osi_role");
                el.removeAttr("disabled");

                if(!$(this).is(":checked")) {
                    el.attr("disabled", "disabled");
                }
            });

            $("#yield_access").click(function () {
                var el = $("#yield_role");
                el.removeAttr("disabled");

                if(!$(this).is(":checked")) {
                    el.attr("disabled", "disabled");
                }
            });
        });
    </script>
@endpush