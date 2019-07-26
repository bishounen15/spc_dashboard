<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebPortal\ProductType;

use Response;

class ProductTypesController extends Controller
{
    //
    public function selectValues() {
        $prodtypes = ProductType::select("PRODTYPE AS value","PRODTYPE AS caption")
                                    ->where("CUSTOMER","<>","TRINA")
                                    ->orderBy("PRODTYPE","ASC")
                                    ->get();

        return Response::json(["data" => $prodtypes]);
    }
}
