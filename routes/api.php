<?php

use Illuminate\Http\Request;
use App\Models\Planning\ProductionSchedule;
use App\Models\Planning\ProductionScheduleProduct;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('prodtypes/{date}/{line}', function($date, $line) {
    $sched_id = ProductionSchedule::where("production_date",$date)->first()->id;
    $products = ProductionScheduleProduct::select("model_name")->where([
        ["schedule_id",$sched_id],
        ["production_line",$line],
    ])->get();

    $prod = "";
    foreach($products as $product) {
        $prod .= ($prod == "" ? "" : "|") . $product->model_name;
    }

    return $prod;
});

Route::get('prodlines/{date}', function($date) {
    $sched_id = ProductionSchedule::where("production_date",$date)->first()->id;
    $lines = ProductionScheduleProduct::select("production_line")->distinct()->where("schedule_id",$sched_id)->orderBy("production_line","ASC")->get();

    $prodline = "";
    foreach($lines as $line) {
        $prodline .= ($prodline == "" ? "" : "|") . "Line " . $line->production_line;
    }

    return $prodline;
});
