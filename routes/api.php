<?php

use Illuminate\Http\Request;
use App\Models\Planning\ProductionSchedule;
use App\Models\Planning\ProductionScheduleProduct;
use App\Models\WebPortal\ProductionLine;

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

Route::get('prodtypes/{date}/{line}', "WebPortal\ProductTypesController@listProducts");

Route::get('prodlines/{date}', function($date) {
    $sched_id = ProductionSchedule::where("production_date",$date)->first()->id;
    $lines = ProductionScheduleProduct::select("production_line")->distinct()->where("schedule_id",$sched_id)->orderBy("production_line","ASC")->get();

    $prodline = "";
    foreach($lines as $line) {
        $prodline .= ($prodline == "" ? "" : "|") . ProductionLine::where("LINCODE",$line->production_line)->first()->LINDESC;
    }

    return $prodline;
});

Route::post('asset/update', 'AssetsController@saveAsset');
Route::post('asset/network', 'AssetsController@saveNetwork');
Route::post('asset/disks', 'AssetsController@saveDisks');
Route::post('asset/apps', 'AssetsController@saveApps');
Route::post('asset/delete/network', 'AssetsController@deleteNetwork');
Route::post('asset/delete/disks', 'AssetsController@deleteDisks');
Route::post('asset/delete/apps', 'AssetsController@deleteApps');

// Vue Routes
Route::post('dataset/list','TRINA\DatasetController@getList');
Route::post('dataset','TRINA\DatasetController@store');
Route::delete('dataset','TRINA\DatasetController@destroy');
Route::post('dataset/template',[
    'as' => 'spreadsheet.download', 
    'uses' => 'TRINA\DatasetController@downloadTemplate'
 ]);
Route::post('dataset/upload','TRINA\DatasetController@upload');

Route::post('portal/dataset/list','WebPortal\DatasetController@getList');
Route::post('portal/dataset','WebPortal\DatasetController@store');
Route::delete('portal/dataset','WebPortal\DatasetController@destroy');

Route::post('portal/dataset/template',[
    'as' => 'spreadsheet.download', 
    'uses' => 'WebPortal\DatasetController@downloadTemplate'
 ]);

 Route::post('portal/dataset/upload','WebPortal\DatasetController@upload');
 
 Route::post('trina/module/lookup','ModulesController@trinaLookup');

 Route::post('prodtype/lookup','WebPortal\ProductTypesController@selectValues');

 Route::post('portal/wo/generate/{date?}/{category?}','WebPortal\WorkOrdersController@generateControl');

 Route::get('myip','PagesController@myip');