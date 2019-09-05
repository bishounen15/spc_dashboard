<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\Item;
use Response;

class ItemClassesController extends Controller
{
    //
    public function selectValues($category = null) {
        $cond = [];

        if ($category != null) {
            array_push($cond,["item_category",$category]);
        }

        $classes = Item::selectRaw("DISTINCT item_class AS value, item_class AS caption")
                                    ->where($cond)
                                    ->orderBy("item_class","ASC")
                                    ->get();

        return Response::json(["data" => $classes]);
    }
}
