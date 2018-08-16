<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\CostCenter;

use DataTables;

class DepartmentController extends Controller
{
    //


    public function list() {
        return view('system.departments.list');
    }

    public function load()
    {
        $depts = Department::selectRaw("departments.id, departments.description, departments.abbrv, CONCAT(cost_centers.code,' - ',cost_centers.description) as cost_center, departments.head, departments.head_email")
        ->join("cost_centers","departments.cost_center_id","=","cost_centers.id")
        ->orderByRaw("departments.description ASC");

        return Datatables::of($depts)->make(true);
    }

    public function create(Request $request) {
        $data = [];

        $data['description'] = $request->input('description');
        $data['abbrv'] = $request->input('abbrv');
        $data['cost_center_id'] = $request->input('cost_center_id');
        $data['head'] = $request->input('head');
        $data['head_email'] = $request->input('head_email');

        if ($request->isMethod('post')) {
            // dd($request);

            $this->validate($request, [
                'description' => 'required|max:50|unique:departments',
                'abbrv' => 'required|max:15|unique:departments',
                'cost_center_id' => 'required',
                'head' => 'string|nullable|max:50',
                'head_email' => 'email|nullable|max:50|unique:departments',
            ]);

            // dd($data);

            Department::create($data);
            return redirect('dept/list')->with("success","Department [".$data["description"]."] successfully added.");
        }

        $data['modify'] = 0;
        $data['cost_centers'] = CostCenter::orderBy("code","ASC")->get();
        return view('system.departments.form', $data);
    }

    public function show($id){
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $dept = Department::find($id);

        $data['description'] = $dept->description;
        $data['abbrv'] = $dept->abbrv;
        $data['cost_center_id'] = $dept->cost_center_id;
        $data['head'] = $dept->head;
        $data['head_email'] = $dept->head_email;

        $data['cost_centers'] = CostCenter::orderBy("code","ASC")->get();
        return view('system.departments.form', $data);
    }

    public function modify(Request $request, $id)
    {
        $data = [];

        $data['description'] = $request->input('description');
        $data['abbrv'] = $request->input('abbrv');
        $data['cost_center_id'] = $request->input('cost_center_id');
        $data['head'] = $request->input('head');
        $data['head_email'] = $request->input('head_email');
        
        if ($request->isMethod('post')) {
            $dept = Department::find($id);
            
            $this->validate($request, [
                'description' => 'required|max:50|unique:departments,description,'.$dept->id,
                'abbrv' => 'required|max:15|unique:departments,abbrv,'.$dept->id,
                'cost_center_id' => 'required',
                'head' => 'string|nullable|max:50',
                'head_email' => 'email|nullable|max:50|unique:departments,head_email,'.$dept->id,
            ]);

            $dept->description = $data['description'];
            $dept->abbrv = $data['abbrv'];
            $dept->cost_center_id = $data['cost_center_id'];
            $dept->head = $data['head'];
            $dept->head_email = $data['head_email'];
            
            $dept->save();
            return redirect('cost_center/list')->with("success","Category [".$data["description"]."] successfully updated.");
        }

        $data['modify'] = 1;
        $data['cost_centers'] = CostCenter::orderBy("code","ASC")->get();
        return view('system.departments.form', $data);
    }
}
