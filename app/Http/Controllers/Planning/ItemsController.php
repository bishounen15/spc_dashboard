<?php

namespace App\Http\Controllers\Planning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\Item;
use DB;
use Response;

class ItemsController extends Controller
{
    //
    public function index() {
        return view('planning.item.index');
    }

    public function getItemList($item_class, $category, $prodtype = "", $filter = "") {
        $items = Item::selectRaw("item_code AS value, item_desc AS caption")
                                    ->where("item_class",$item_class)
                                    ->where(function($q) use ($filter) {
                                        $q->where('item_code', "LIKE", "%".$filter."%")
                                          ->orWhere('item_desc', "LIKE", "%".$filter."%");
                                    })
                                    ->whereNotExists(function($query) use ($item_class,$category,$prodtype) {
                                        $query->select(DB::raw(1))
                                            ->from('bm01')
                                            ->join("bm02", "bm01.id", "bm02.bom_id")
                                            ->whereRaw('bm01.product_type = ? AND bm01.category = ? AND bm01.item_class = ? AND im01.item_code = bm02.item_code',[$prodtype,$category,$item_class]);
                                    })
                                    ->orderBy("item_code","ASC")
                                    ->get();

        return Response::json(["data" => $items]);
    }
}
