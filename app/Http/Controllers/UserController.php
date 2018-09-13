<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Department;
Use App\OSIRoles;
use App\UserRoles;
use App\ITRoles;

use DataTables;

class UserController extends Controller
{
    //
    protected $name = 'user_id';

    public function __construct( OSIRoles $osi_roles, UserRoles $user_roles, ITRoles $it_roles )
    {
        $this->oroles = $osi_roles->all();
        $this->uroles = $user_roles->all();
        $this->itroles = $it_roles->all();
    }

    public function list() {
        return view('system.users.list');
    }

    public function load()
    {
        $users = User::selectRaw("users.id, CONCAT(users.user_id,CASE sysadmin WHEN 1 THEN '***' ELSE '' END) AS user_id, users.name, departments.description, users.email, CASE users.osi_access WHEN 1 THEN users.osi_role ELSE 'no access' END AS osi_access, CASE users.yield_access WHEN 1 THEN users.yield_role ELSE 'no access' END AS yield_access, CASE users.assets_access WHEN 1 THEN users.assets_role ELSE 'no access' END AS assets_access")
                        ->leftJoin("departments","users.dept_id","=","departments.id")
                        ->orderByRaw("users.user_id ASC");

        return Datatables::of($users)->make(true);
    }

    public function show($id){
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $user = User::find($id);

        $data['user_id'] = $user->user_id;
        $data['name'] = $user->name;
        $data['dept_id'] = $user->dept_id;
        $data['email'] = $user->email;
        $data['sysadmin'] = $user->sysadmin;
        $data['osi_access'] = $user->osi_access;
        $data['osi_role'] = $user->osi_role;
        $data['yield_access'] = $user->yield_access;
        $data['yield_role'] = $user->yield_role;
        $data['assets_access'] = $user->assets_access;
        $data['assets_role'] = $user->assets_role;
        // $data['head_email'] = $user->head_email;

        $data['depts'] = Department::orderBy("description","ASC")->get();
        $data['o_roles'] = $this->oroles;
        $data['y_roles'] = $this->uroles;
        $data['it_roles'] = $this->itroles;
        return view('system.users.form', $data);
    }

    public function modify(Request $request, $id)
    {
        // dd($id);
        $data = [];

        $data['user_id'] = $request->input('user_id');
        $data['name'] = $request->input('name');
        $data['dept_id'] = $request->input('dept_id');
        $data['email'] = $request->input('email');
        $data['sysadmin'] = $request->has('sysadmin');
        $data['osi_access'] = $request->has('osi_access');
        $data['osi_role'] = $request->input('osi_role');
        $data['yield_access'] = $request->has('yield_access');
        $data['yield_role'] = $request->input('yield_role');
        $data['assets_access'] = $request->has('assets_access');
        $data['assets_role'] = $request->input('assets_role');
        
        if ($request->isMethod('post')) {
            $user = User::find($id);
            
            $this->validate($request, [
                'user_id' => 'required|unique:users,user_id,'.$user->id,
                'name' => 'required|max:50|unique:users,name,'.$user->id,
                'dept_id' => 'required',
                'email' => 'email|nullable|max:50|unique:departments,head_email,'.$user->id,'email' => 'email|nullable|max:50',
            ]);

            $user->user_id = $data['user_id'];
            $user->name = $data['name'];
            $user->dept_id = $data['dept_id'];
            $user->email = $data['email'];
            $user->sysadmin = $data['sysadmin'];
            $user->osi_access = $data['osi_access'];
            $user->osi_role = $data['osi_role'];
            $user->yield_access = $data['yield_access'];
            $user->yield_role = $data['yield_role'];
            $user->assets_access = $data['assets_access'];
            $user->assets_role = $data['assets_role'];
            
            $user->save();
            return redirect('user/list')->with("success","User [".$data["user_id"]." - ".$data["name"]."] successfully updated.");
        }

        $data['modify'] = 1;
        return view('system.users.form', $data);
    }
}
