<?php

namespace App\Http\Controllers\Planning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\Item;
use Response;

class ItemsController extends Controller
{
    //
    public function index() {
        return view('planning.item.index');
    }

    public function getItemList($item_class, $filter = null) {
        $items = Item::selectRaw("item_code AS value, item_desc AS caption")
                                    ->where("item_class",$item_class)
                                    ->where(function($q) use ($filter) {
                                        $q->where('item_code', "LIKE", "%".$filter."%")
                                          ->orWhere('item_desc', "LIKE", "%".$filter."%");
                                    })
                                    ->orderBy("item_code","ASC")
                                    ->get();

        return Response::json(["data" => $items]);
    }
}
