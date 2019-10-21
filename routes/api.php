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
Route::post('portal/dataset/edit','WebPortal\DatasetController@edit');
Route::post('portal/dataset','WebPortal\DatasetController@store');
Route::put('portal/dataset','WebPortal\DatasetController@update');
Route::delete('portal/dataset','WebPortal\DatasetController@destroy');

Route::post('portal/dataset/template',[
    'as' => 'spreadsheet.download', 
    'uses' => 'WebPortal\DatasetController@downloadTemplate'
 ]);

 Route::post('portal/dataset/upload','WebPortal\DatasetController@upload');
 
 Route::post('trina/module/lookup','ModulesController@trinaLookup');

 Route::post('prodline/lookup','WebPortal\ProductionLinesController@selectValues');
 Route::post('prodline/withsched/{production_date?}','WebPortal\ProductionLinesController@withSchedule');
 Route::post('prodline/schedule/{date}/{line}','WebPortal\ProductionLinesController@loadSchedule');

 Route::post('prodtype/lookup','WebPortal\ProductTypesController@selectValues');
 Route::post('prodtype/details/{prodtype}','WebPortal\ProductTypesController@getDetails');

 Route::post('itemclass/lookup/{category?}','WebPortal\ItemClassesController@selectValues');
 Route::post('item/lookup/{item_class}/{category}/{prodtype?}/{filter?}','Planning\ItemsController@getItemList');

 Route::post('portal/wo/generate/{date?}/{category?}','WebPortal\WorkOrdersController@generateControl');

 Route::get('myip','PagesController@myip');

 Route::post('mes/cabinet/pallet/check/{pallet_no}','WebPortal\CabinetsController@checkPallet');
 Route::post('mes/cabinet/list','WebPortal\CabinetsController@listCabinets');
 Route::post('mes/cabinet/save','WebPortal\CabinetsController@saveCabinet');
 Route::put('mes/cabinet/ship','WebPortal\CabinetsController@shipCabinet');

 Route::post('planning/bom/details/{prodtype}','Planning\BOMController@getBOM');
 Route::post('planning/bom/add','Planning\BOMController@store');
 Route::post('planning/bom/check/{product_type}/{item_code}','Planning\BOMController@checkBOMItem');

 Route::post('mes/issuance/list','WebPortal\WarehouseIssuanceController@list');
 Route::post('mes/issuance','WebPortal\WarehouseIssuanceController@store');
 Route::post('mes/issuance/submit/{id}','WebPortal\WarehouseIssuanceController@submitTransaction');
 Route::delete('mes/issuance/delete/{id}','WebPortal\WarehouseIssuanceController@deleteTransaction');
 Route::get('mes/issuance/edit/{id}','WebPortal\WarehouseIssuanceController@edit');
 Route::get('mes/issuance/view/{id}','WebPortal\WarehouseIssuanceController@show');
 Route::put('mes/issuance','WebPortal\WarehouseIssuanceController@update');

 Route::get('mes/lot/info/{lot}','WebPortal\LotAssignController@getDetails');
 Route::post('mes/lot/assign/{parent}/{child}/{qty}','WebPortal\LotAssignController@addChild');
 Route::delete('mes/lot/delete/{lot}','WebPortal\LotAssignController@removeChild');

 Route::get('mes/lot/check/{lot}','WebPortal\LotTransactionsController@checkLot');

 Route::post('mes/stringer', 'WebPortal\LotTransactionsController@store');
 Route::get('mes/stringer/trx/{station}/{machine}', 'WebPortal\LotTransactionsController@list');