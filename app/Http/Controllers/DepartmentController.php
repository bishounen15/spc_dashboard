<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

use DataTables;

class DepartmentController extends Controller
{
    //
    public function list() {
        return view('system.departments.list');
    }

    public function load()
    {
        $depts = Department::selectRaw("id, description, abbrv, cost_center, head, head_email")
        ->orderByRaw("cost_center ASC");

        return Datatables::of($depts)->make(true);
    }

    public function create(Request $request) {
        $data = [];

        $data['description'] = $request->input('description');
        $data['abbrv'] = $request->input('abbrv');
        $data['cost_center'] = $request->input('cost_center');
        $data['head'] = $request->input('head');
        $data['head_email'] = $request->input('head_email');

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'description' => 'required|max:50|unique:departments',
                'abbrv' => 'required|max:15|unique:departments',
                'cost_center' => 'required|max:15|unique:departments',
                'head' => 'string|nullable|max:50',
                'head_email' => 'email|nullable|max:50|unique:departments',
            ]);

            // dd($data);

            Department::create($data);
            return redirect('dept/list')->with("success","Department [".$data["description"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('system.departments.form', $data);
    }

    public function show($id){
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $dept = Department::find($id);

        $data['description'] = $dept->description;
        $data['abbrv'] = $dept->abbrv;
        $data['cost_center'] = $dept->cost_center;
        $data['head'] = $dept->head;
        $data['head_email'] = $dept->head_email;

        return view('system.departments.form', $data);
    }

    public function modify(Request $request, $id)
    {
        $data = [];

        $data['description'] = $request->input('description');
        $data['abbrv'] = $request->input('abbrv');
        $data['cost_center'] = $request->input('cost_center');
        $data['head'] = $request->input('head');
        $data['head_email'] = $request->input('head_email');
        
        if ($request->isMethod('post')) {
            $dept = Department::find($id);
            
            $this->validate($request, [
                'description' => 'required|max:50|unique:departments,description,'.$dept->id,
                'abbrv' => 'required|max:15|unique:departments,abbrv,'.$dept->id,
                'cost_center' => 'required|max:15|unique:departments,cost_center,'.$dept->id,
                'head' => 'string|nullable|max:50',
                'head_email' => 'email|nullable|max:50|unique:departments,head_email,'.$dept->id,
            ]);

            $dept->description = $data['description'];
            $dept->abbrv = $data['abbrv'];
            $dept->cost_center = $data['cost_center'];
            $dept->head = $data['head'];
            $dept->head_email = $data['head_email'];
            
            $dept->save();
            return redirect('dept/list')->with("success","Category [".$data["description"]."] successfully updated.");
        }

        $data['modify'] = 1;
        return view('osi.category.form', $data);
    }
}
