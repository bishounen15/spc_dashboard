<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CostCenter;

use DataTables;

class CostCenterController extends Controller
{
    //
    public function list() {
        return view('system.cost_centers.list');
    }

    public function load()
    {
        $cost_centers = CostCenter::selectRaw("id, code, description, owner, designation")
        ->orderByRaw("code ASC");

        return Datatables::of($cost_centers)->make(true);
    }

    public function create(Request $request) {
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');
        $data['owner'] = $request->input('owner');
        $data['designation'] = $request->input('designation');
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'owner' => 'required|max:15|unique:departments',
                'description' => 'required|max:50|unique:departments',
                'owner' => 'required|max:50',
                'designation' => 'required|max:50',
            ]);

            // dd($data);

            CostCenter::create($data);
            return redirect('cost_center/list')->with("success","Cost Center [".$data["description"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('system.cost_centers.form', $data);
    }

    public function show($id){
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $cost_center = CostCenter::find($id);

        $data['description'] = $cost_center->description;
        $data['code'] = $cost_center->code;
        $data['owner'] = $cost_center->owner;
        $data['designation'] = $cost_center->designation;
        
        return view('system.cost_centers.form', $data);
    }

    public function modify(Request $request, $id)
    {
        $data = [];

        $data['description'] = $request->input('description');
        $data['code'] = $request->input('code');
        $data['owner'] = $request->input('owner');
        $data['designation'] = $request->input('designation');
        
        if ($request->isMethod('post')) {
            $cost_center = CostCenter::find($id);
            
            $this->validate($request, [
                'description' => 'required|max:50|unique:departments,description,'.$cost_center->id,
                'code' => 'required|max:15|unique:cost_centers,code,'.$cost_center->id,
                'owner' => 'required|max:50',
                'designation' => 'required|max:50',
            ]);

            $cost_center->description = $data['description'];
            $cost_center->code = $data['code'];
            $cost_center->owner = $data['owner'];
            $cost_center->designation = $data['designation'];
            
            $cost_center->save();
            return redirect('cost_center/list')->with("success","Cost Center [".$data["description"]."] successfully updated.");
        }

        $data['modify'] = 1;
        return view('system.cost_centers.form', $data);
    }
}
