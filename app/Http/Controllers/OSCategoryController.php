<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OSCategory;

use DataTables;

class OSCategoryController extends Controller
{
    //
    public function __construct( OSCategory $category )
    {
        $this->category = $category->all();
    }

    public function list() {
        return view('osi.category.list');
    }

    public function load()
    {
        $categories = OSCategory::selectRaw("id, code, description")
        ->orderByRaw("description ASC");

        return Datatables::of($categories)->make(true);
    }

    public function create(Request $request) {
        $data = [];

        $data['code'] = OSCategory::GenerateCode();
        $data['description'] = $request->input('description');

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:osi.categories',
                'description' => 'required|max:50|unique:osi.categories',
            ]);

            // dd($data);

            OSCategory::create($data);
            return redirect('os/category/list')->with("success","Category [".$data["description"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('osi.category.form', $data);
    }

    public function show($id){
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $category = $this->category->find($id);

        $data['code'] = $category->code;
        $data['description'] = $category->description;
                
        return view('osi.category.form', $data);
    }

    public function modify(Request $request, $id)
    {
        $data = [];

        $data['description'] = $request->input('description');
        
        if ($request->isMethod('post')) {
            $category = $this->category->find($id);
            
            $this->validate($request, [
                'description' => 'required|max:50|unique:osi.categories,description,'.$category->id,
            ]);

            $category->description = $data['description'];
            
            $category->save();
            return redirect('os/category/list')->with("success","Category [".$data["description"]."] successfully updated.");
        }

        $data['modify'] = 0;
        return view('osi.category.form', $data);
    }
}
