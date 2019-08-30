<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\Item;
use Response;

class ItemClassesController extends Controller
{
    //
    public function selectValues() {
        $classes = Item::selectRaw("DISTINCT item_class AS value, item_class AS caption")
                                    ->orderBy("item_class","ASC")
                                    ->get();

        return Response::json(["data" => $classes]);
    }
}
