<?php

namespace App\Http\Controllers\Planning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\ProductType;

use DataTables;

class ProductTypesController extends Controller
{
    //
    public function index() {
        return view('planning.product.list');
    }

    public function load() {
        $products = ProductType::orderBy("PRODTYPE","ASC")->get();
        return Datatables::of($products)->make(true);
    }
}
