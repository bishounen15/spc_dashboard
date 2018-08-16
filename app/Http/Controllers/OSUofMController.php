<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OSUofM;

use DataTables;

class OSUofMController extends Controller
{
    //
    public function __construct( OSUofM $uofm )
    {
        $this->uofm = $uofm->all();
    }

    public function list() {
        return view('osi.uofm.list');
    }

    public function load()
    {
        $uofm = OSUofM::selectRaw("id, code, description")
        ->orderByRaw("description ASC");

        return Datatables::of($uofm)->make(true);
    }

    public function create(Request $request) {
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:osi.uofms',
                'description' => 'required|max:50|unique:osi.uofms',
            ]);

            OSUofM::create($data);
            return redirect('os/uofm/list')->with("success","U of M [".$data["description"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('osi.uofm.form', $data);
    }

    public function show($id){
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $uofm = $this->uofm->find($id);

        $data['code'] = $uofm->code;
        $data['description'] = $uofm->description;
                
        return view('osi.uofm.form', $data);
    }

    public function modify(Request $request, $id)
    {
        $data = [];

        $data['description'] = $request->input('description');
        
        if ($request->isMethod('post')) {
            $uofm = $this->uofm->find($id);
            
            $this->validate($request, [
                'description' => 'required|max:50|unique:osi.uofms,description,'.$uofm->id,
            ]);

            $uofm->description = $data['description'];
            
            $uofm->save();
            return redirect('os/uofm/list')->with("success","U of M [".$data["description"]."] successfully updated.");
        }

        $data['modify'] = 0;
        return view('osi.uofm.form', $data);
    }
}
