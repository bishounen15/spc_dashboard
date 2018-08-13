<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use DataTables;

class UserController extends Controller
{
    //
    public function list() {
        return view('system.users.list');
    }

    public function load()
    {
        $users = User::selectRaw("users.id, users.user_id, users.name, departments.description, users.email, CASE users.osi_access WHEN 1 THEN users.osi_role ELSE 'no access' END AS osi_access, CASE users.yield_access WHEN 1 THEN users.yield_role ELSE 'no access' END AS yield_access")
                        ->leftJoin("departments","users.dept_id","=","departments.id")
                        ->orderByRaw("users.user_id ASC");

        return Datatables::of($users)->make(true);
    }
}
