<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfficeSupplies;

use App\OSCategory;
use App\OSUofM;

Use DataTables;

class OSController extends Controller
{
    //
    public function __construct( OSCategory $category, OSUofM $uofm, OfficeSupplies $office_supply )
    {
        $this->category = $category->all();
        $this->uofm = $uofm->all();
        $this->office_supply = $office_supply->all();
    }

    public function list() {
        return view('osi.inventory.list');
    }

    public function load()
    {
        $items = OfficeSupplies::selectRaw("office_supplies.id, office_supplies.code, office_supplies.description, categories.description as category, uofms.description as uofm, current_stock")
        ->join("categories","office_supplies.category_id","=","categories.id")
        ->join("uofms","office_supplies.uofm_id","=","uofms.id")
        ->orderByRaw("category ASC, description ASC");

        return Datatables::of($items)->make(true);
    }

    public function create(Request $request) {
        $data = [];

        $data['code'] = OfficeSupplies::GenerateCode();
        $data['description'] = $request->input('description');
        $data['category_id'] = $request->input('category_id');
        $data['uofm_id'] = $request->input('uofm_id');
        $data['unit_cost'] = $request->input('unit_cost') ? $request->input('unit_cost') : 0;
        $data['stock_limit'] = $request->input('stock_limit') ? $request->input('stock_limit') : 0;
        $data['current_stock'] = 0;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:osi.office_supplies',
                'description' => 'required|max:50|unique:osi.office_supplies',
                'category_id' => 'required',
                'uofm_id' => 'required',
                'unit_cost' => 'required',
                'stock_limit' => 'required',
            ]);

            OfficeSupplies::create($data);
            return redirect('os/item/list')->with("success","Item [".$data["description"]."] successfully added.");
        }

        $data['categories'] = OSCategory::orderBy("code","asc")->get();
        $data['uofms'] = OSUofM::orderBy("description","asc")->get();
        $data['modify'] = 0;
        return view('osi.inventory.form', $data);
    }

    public function show($id){
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $office_supply = $this->office_supply->find($id);

        $data['code'] = $office_supply->code;
        $data['description'] = $office_supply->description;
        $data['category_id'] = $office_supply->category_id;
        $data['uofm_id'] = $office_supply->uofm_id;
        $data['unit_cost'] = $office_supply->unit_cost;
        $data['stock_limit'] = $office_supply->stock_limit;
        
        $data['categories'] = OSCategory::orderBy("code","asc")->get();
        $data['uofms'] = OSUofM::orderBy("description","asc")->get();

        return view('osi.inventory.form', $data);
    }

    public function modify(Request $request, $id)
    {
        $data = [];

        $data['description'] = $request->input('description');
        $data['category_id'] = $request->input('category_id');
        $data['uofm_id'] = $request->input('uofm_id');
        $data['unit_cost'] = $request->input('unit_cost') ? $request->input('unit_cost') : 0;
        $data['stock_limit'] = $request->input('stock_limit') ? $request->input('stock_limit') : 0;
        
        if ($request->isMethod('post')) {
            $office_supply = $this->office_supply->find($id);
            
            $this->validate($request, [
                'description' => 'required|max:50|unique:osi.office_supplies,description,'.$office_supply->id,
                'category_id' => 'required',
                'uofm_id' => 'required',
                'unit_cost' => 'required',
                'stock_limit' => 'required',
            ]);

            $office_supply->description = $data['description'];
            $office_supply->category_id = $data['category_id'];
            $office_supply->uofm_id = $data['uofm_id'];
            $office_supply->unit_cost = $data['unit_cost'];
            $office_supply->stock_limit = $data['stock_limit'];
            
            $office_supply->save();
            return redirect('os/item/list')->with("success","Item [".$data["description"]."] successfully updated.");
        }

        $data['modify'] = 0;
        return view('osi.category.form', $data);
    }
}
