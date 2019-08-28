<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\ItemClass;
use Response;

class ItemClassesController extends Controller
{
    //
    public function selectValues() {
        $classes = ItemClass::select("CLSCODE AS value","CLSDESC AS caption")
                                    ->orderBy("CLSDESC","ASC")
                                    ->get();

        return Response::json(["data" => $classes]);
    }
}
