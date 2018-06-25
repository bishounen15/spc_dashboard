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
    public function list() {
        return view('osi.inventory.list');
    }

    public function load()
    {
        $items = OfficeSupplies::selectRaw("office_supplies.id, office_supplies.code, office_supplies.description, categories.description as category, uofms.description as uofm, current_stock")
        ->join("categories","office_supplies.category_id","=","categories.id")
        ->join("uofms","office_supplies.uofm_id","=","uofms.id")
        ->orderByRaw("description ASC");

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
                'code' => 'required|max:15|unique:osi.categories',
                'description' => 'required|max:50|unique:osi.categories',
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

    public function store(Request $request) {

    }
}
