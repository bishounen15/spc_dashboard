<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PagesController@index');
Route::get('/link','LinkAccountController@index')->name('portal_link');
Route::post('/check','LinkAccountController@check')->name('check_account');
Route::post('/link/account','LinkAccountController@link')->name('link_account');

// Route::group(['middleware' => 'web'], function() {
    Route::group(['middleware'=>['web','auth','revalidate']], function() {

        Route::get('/Apps','PagesController@apps')->name('apps');

        Route::get('/Summary', 'PagesController@Summary')->name('spc_entry');
        Route::get('/pulltest', 'PagesController@pulltest');
        Route::get('/lamdata', 'PagesController@lamdata');
        //Route::get('/create', 'FrameController@store');

        Route::resource('lam', 'LamController');
        Route::resource('laytec', 'LaytecController');
        Route::resource('pulltest', 'PulltestController');
        Route::resource('pulltestEG', 'PulltestEGController');
        Route::resource('stringer', 'StringerController');
        Route::resource('flash', 'FlashController');
        Route::resource('pulltestdata', 'PulltestController');
        Route::resource('lamdata', 'LamController');

        Route::resource('matrixpulltest', 'MatrixPullTestsController');
        Route::resource('matsolder', 'MatSolderingPostsController');
        Route::resource('offlinebtob', 'OfflineBtoBPullTestController');
        Route::resource('offlinematsolder', 'OfflineMatSolderingPostsController');

        Route::resource('Potting','PottingController');
        Route::resource('Curing','CuringController');
        Route::resource('SolderTemp','solderTempController');
        Route::resource('JBox','JBoxController');
        Route::resource('Frame','FrameController');
        Route::resource('Framming','SqBwController');
        Route::resource('MixRatio','MixRatioController');

        // Route::resource('Yield','yieldController');
        Route::get('/yield/setup/product_types/data', 'ProductTypeController@load')->name('product_type_data');
        Route::post('/yield/setup/product_types/get', 'ProductTypeController@getTarget')->name('product_type_target');
        Route::resource('/yield/setup/product_types','ProductTypeController');        

        Route::get('/yield/email/data','YieldEmailsController@load')->name('email_yield_data');
        Route::get('/yield/email','YieldEmailsController@list')->name('list_email_yield');
        Route::post('/yield/email/store','YieldEmailsController@store')->name('store_email_yield');
        Route::get('/yield/email/remove/{id}','YieldEmailsController@destroy')->name('remove_email_yield');

        Route::post('/yield/date','yieldController@getYieldPerDate')->name('yield_per_date');

        Route::post('/yield/list/data', 'yieldController@getShiftOutput')->name('refresh_yield_data');
        Route::get('/yield/list/data', 'yieldController@load')->name('yield_data');
        Route::get('/Yield/list','yieldController@list')->name('list_yield');
        Route::get('/Yield/create','yieldController@create')->name('create_yield');
        Route::get('/Yield/edit/{id}','yieldController@create')->name('edit_yield');
        Route::post('/Yield/edit/{id}','yieldController@modify')->name('modify_yield');
        Route::post('/Yield/store','yieldController@store')->name('store_yield');

        Route::get('/os/category/list/data', 'OSCategoryController@load')->name('category_data');
        Route::get('/os/category/list','OSCategoryController@list')->name('list_categories');
        Route::get('/os/category/create','OSCategoryController@create')->name('create_category');
        Route::post('/os/category/create','OSCategoryController@create')->name('store_category');
        Route::get('/os/category/{id}','OSCategoryController@show')->name('show_category');
        Route::post('/os/category/{id}','OSCategoryController@modify')->name('modify_category');
        Route::post('/os/category/remove/{id}','OSCategoryController@destroy')->name('remove_category');

        Route::get('/os/uofm/list/data', 'OSUofMController@load')->name('uofm_data');
        Route::get('/os/uofm/list','OSUofMController@list')->name('list_uofm');
        Route::get('/os/uofm/create','OSUofMController@create')->name('create_uofm');
        Route::post('/os/uofm/create','OSUofMController@create')->name('store_uofm');
        Route::get('/os/uofm/{id}','OSUofMController@show')->name('show_uofm');
        Route::post('/os/uofm/{id}','OSUofMController@modify')->name('modify_uofm');
        Route::post('/os/uofm/remove/{id}','OSUofMController@destroy')->name('remove_uofm');

        Route::get('/os/item/list/data', 'OSController@load')->name('item_data');
        Route::get('/os/item/list','OSController@list')->name('list_items');
        Route::get('/os/item/create','OSController@create')->name('create_item');
        Route::post('/os/item/create','OSController@create')->name('store_item');
        Route::get('/os/item/{id}','OSController@show')->name('show_item');
        Route::post('/os/item/{id}','OSController@modify')->name('modify_item');
        Route::post('/os/item/remove/{id}','OSController@destroy')->name('remove_item');

        Route::post('/item_list','OSTransactionController@GetItems')->name('get_item_list');
        Route::post('/item_details','OSTransactionController@GetItemDetails')->name('get_item_details');
        Route::post('/trx_info','OSTransactionController@GetTrxInfo')->name('get_trx_info');
        Route::post('/os_status','OSTransactionController@updateStatus')->name('os_status');

        Route::get('/os/transaction/list/data', 'OSTransactionController@load')->name('trx_data');
        Route::get('/os/transaction/list','OSTransactionController@list')->name('list_trx');
        Route::get('/os/transaction/create/{tid}','OSTransactionController@create')->name('create_trx');
        Route::post('/os/transaction/create/{tid}','OSTransactionController@create')->name('store_trx');
        Route::get('/os/transaction/edit/{id}','OSTransactionController@show')->name('show_trx');
        Route::post('/os/transaction/edit/{id}','OSTransactionController@modify')->name('modify_trx');
        Route::post('/os/transaction/remove/{id}','OSTransactionController@destroy')->name('remove_trx');

        Route::get('/cost_center/list/data', 'CostCenterController@load')->name('cost_center_data');
        Route::get('/cost_center/list','CostCenterController@list')->name('list_cost_centers');
        Route::get('/cost_center/create','CostCenterController@create')->name('create_cost_center');
        Route::post('/cost_center/create','CostCenterController@create')->name('store_cost_center');
        Route::get('/cost_center/{id}','CostCenterController@show')->name('show_cost_center');
        Route::post('/cost_center/{id}','CostCenterController@modify')->name('modify_cost_center');
        Route::post('/cost_center/remove/{id}','CostCenterController@destroy')->name('remove_cost_center');

        Route::get('/dept/list/data', 'DepartmentController@load')->name('dept_data');
        Route::get('/dept/list','DepartmentController@list')->name('list_depts');
        Route::get('/dept/create','DepartmentController@create')->name('create_dept');
        Route::post('/dept/create','DepartmentController@create')->name('store_dept');
        Route::get('/dept/{id}','DepartmentController@show')->name('show_dept');
        Route::post('/dept/{id}','DepartmentController@modify')->name('modify_dept');
        Route::post('/dept/remove/{id}','DepartmentController@destroy')->name('remove_dept');

        Route::get('/user/list/data', 'UserController@load')->name('user_data');
        Route::get('/user/list','UserController@list')->name('list_users');
        Route::get('/user/create','UserController@create')->name('create_user');
        Route::post('/user/create','UserController@store')->name('store_user');
        Route::get('/user/{id}','UserController@show')->name('show_user');
        Route::post('/user/{id}','UserController@modify')->name('modify_user');
        Route::post('/user/remove/{id}','UserController@destroy')->name('remove_user');

        Route::get('/assets/general/data', 'AssetsController@load')->name('asset_data');
        Route::get('/assets/software/{id}', 'AssetsController@load_software')->name('sw_data');
        Route::resource('/assets/general','AssetsController');
        Route::resource('/assets/dashboard/general','AssetDashboardController');
        Route::get('/assets/create','AssetsController@create');
        Route::get('/assets/edit/{id}','AssetsController@edit');

        Route::get('/proddt/setup/machine/data', 'MachinesController@load')->name('machine_data');
        Route::resource('/proddt/setup/machine','MachinesController');

        Route::get('/proddt/setup/station/data', 'StationsController@load')->name('station_data');
        Route::resource('/proddt/setup/station','StationsController');

        Route::get('/proddt/setup/category/data', 'DTCategoriesController@load')->name('dtcategory_data');
        Route::resource('/proddt/setup/category','DTCategoriesController');

        Route::get('/proddt/setup/downtime/data/{machine_id}/{category_id}', 'DTTypesController@load')->name('dtdowntime_data');
        Route::resource('/proddt/setup/machine/{machine_id}/downtime','DTTypesController');

        Route::post('/proddt/category_id','DTLogSheetsController@getCategory')->name('get_dtcategory');
        Route::post('/proddt/issue_list','DTLogSheetsController@listIssues')->name('get_dtissue_list');
        Route::get('/proddt/logsheet/data', 'DTLogSheetsController@load')->name('logsheet_data');
        Route::get('/proddt/dashboard/data/{date}/{shift}/{station_id}','DTLogSheetsController@dashdata')->name('dt_dashboard_data');
        Route::get('proddt/dashboard','DTLogSheetsController@dashboard')->name('dt_dashboard');
        Route::resource('/proddt/logsheet','DTLogSheetsController');

        Route::get('/mes/data/{start}/{end}', 'MESController@load')->name('mes_data');
        Route::get('/mes/transactions/{date}/{shift}/{station}/{line?}', 'MESController@transactions')->name('mes_trx');
        Route::get('/mes/output/{date?}', 'MESController@dailyOutput')->name('mes_output');
        Route::post('/mes/validate/{line?}', 'MESController@serialValidation')->name('mes_validate');
        Route::get('/mes','MESController@index')->name('mes_daily'); // Disable this if slow transactions
        Route::get('/mescreate/{station}/{line?}','MESController@create')->name('add_mes_trx');
        Route::post('/mescreate/{station}/{line?}','MESController@store')->name('save_mes_trx');
        Route::get('/mes/ftd', 'MESController@ftd')->name('mes_ftd'); // Disable this if slow transactions
        Route::post('/mes/ftdreport', 'MESController@ftdReport')->name('mes_ftdreport');
        Route::post('/mes/resetpower/{serial}/{rowid}', 'MESController@resetPower')->name('mes_resetpower');
        // Route::resource('/mes','MESController');
        Route::get('/trina/ftdreport', 'TRINA\ReportsController@ftdReport')->name('trina_ftd_report');
        Route::get('/trina/ftd/{start}/{end}/{pack?}/{shipped?}', 'TRINA\ReportsController@ftd')->name('trina_ftd');

        Route::get('/trina/moduleinfo', 'TRINA\ReportsController@modInfo')->name('trina_module_info');
        Route::get('/trina/modinfo/{start}/{end}', 'TRINA\ReportsController@moduleInfo')->name('trina_mod_info');

        Route::get('/trina/lotreport', 'TRINA\ReportsController@lotReport')->name('trina_lot_report');
        Route::get('/trina/lot', 'TRINA\ReportsController@LotNumbers')->name('trina_ftd');

        Route::get('/trina/inquiry', 'TRINA\ReportsController@moduleInquiry')->name('trina_mod_inquiry');
        Route::post('/trina/inquire', 'TRINA\ReportsController@Inquire')->name('trina_inquire');
        Route::post('/trina/updateEL', 'TRINA\ModuleController@updateELGrade')->name('trina_updateEL');

        Route::post('/trina/oba', 'TRINA\OBAController@saveOBA')->name('trina_oba');

        Route::get('/trina/workorder', 'TRINA\WorkOrderController@index')->name('trina_wo');
        Route::get('/trina/workorder/{id}/{version}', 'TRINA\WorkOrderController@show');
        Route::get('/trina/wo/load', 'TRINA\WorkOrderController@load')->name('trina_wo_load');
        Route::post('/trina/wo/toggle/{id}/{version}', 'TRINA\WorkOrderController@toggle')->name('trina_wo_toggle');

        Route::get('/trina/shipment', 'TRINA\ShipmentController@index')->name('trina_shipment');
        Route::get('/trina/shipment/{container_no}', 'TRINA\ShipmentController@show');
        Route::get('/trina/ship/load', 'TRINA\ShipmentController@load')->name('trina_ship_load');
        Route::post('/trina/markshipment/{shipment_date}/{cipl_no}/{pl_no}', 'TRINA\ShipmentController@markShipment')->name('trina_mark_ship');

        Route::get('/trina/jbox/register', 'TRINA\JBOXCodeController@index')->name('trina_jbox_reg');
        Route::post('/trina/jbox/verify', 'TRINA\JBOXCodeController@verify')->name('trina_jbox_verify');
        Route::post('/trina/jbox/register', 'TRINA\JBOXCodeController@register')->name('trina_jbox_register');

        Route::get('/trina/flashtest', 'TRINA\FlashTestController@index')->name('trina_flash_test');
        Route::post('/trina/loadtest/{ModuleID}', 'TRINA\FlashTestController@load')->name('trina_ft_load');
        Route::get('/trina/testresults/{ModuleID}', 'TRINA\FlashTestController@testResults')->name('trina_test_results');
        Route::post('/trina/resetpower/{WorkOrder_ID}/{Module_ID}/{TEST_DATETIME}', 'TRINA\FlashTestController@resetPower')->name('trina_test_results');

        Route::get('/trina/containerinfo', 'TRINA\ReportsController@containerReport')->name('trina_cont_report');
        Route::get('/trina/container/{start}/{end}/{shipped?}', 'TRINA\ReportsController@containerInfo')->name('trina_cont');

        Route::get('/trina/moduleupdate', 'TRINA\ModuleController@ModuleUpdate')->name('trina_modupd');
        Route::post('/trina/listmodules', 'TRINA\ModuleController@ListModules')->name('trina_listmods');
        Route::post('/trina/moduleupdate', 'TRINA\ModuleController@UpdateModules')->name('trina_updmod');
        
        Route::post('/modules/inquire','ModulesController@inquire')->name('module_inquiry');
        Route::get('/modules/ftd/{serial}','ModulesController@ftd')->name('ftd_data');
        Route::get('/modules/mes/{serial}','ModulesController@mes')->name('mod_mes');
        Route::get('/modules/lot/{serial}','ModulesController@lot')->name('lot_mes');
        Route::get('/modules/add/{serial}','ModulesController@add')->name('add_mes');
        Route::resource('/modules','ModulesController');

        //Planning
        Route::get('/planning/setup/shift/data', 'Planning\ShiftsController@load')->name('shift_data');
        Route::resource('/planning/setup/shift','Planning\ShiftsController');

        Route::get('/planning/schedule/data', 'Planning\ProductionSchedulesController@load')->name('sched_data');
        Route::resource('/planning/schedule','Planning\ProductionSchedulesController');

        Route::resource('mes/setup/custom','mesCustomFieldController');

        Route::get('/mes/packaging/data/{start}/{end}', 'Packaging\PackingListController@load')->name('packaging_data');
        Route::post('/mes/packaging/trx_info','Packaging\PackingListController@GetTrxInfo')->name('packing_trx_info');
        Route::post('/mes/packaging/validate', 'Packaging\PackingListController@serialValidation')->name('packaging_validate');
        Route::get('/mes/packaging/export/{id}', 'Packaging\PackingListController@export')->name('packaging_export');
        Route::resource('mes/packaging','Packaging\PackingListController');

        Route::post('/planning/wo/getprod','WebPortal\WorkOrdersController@getProduct')->name('get_wo_prodtype');

        Route::get('/trina/module/color', function() {
            return view('mes.trina.admin.modcolor');
        });

        Route::get('/trina/module/power', function() {
            return view('mes.trina.admin.modpower');
        });

        Route::get('/trina/po', function() {
            return view('mes.trina.admin.podata');
        });

        Route::get('/trina/module/sync', function() {
            return view('mes.trina.admin.sync');
        });

        Route::get('/trina/module/missing/{date?}', function() {
            return view('mes.trina.missing');
        });

        Route::get('/planning/wo', function() {
            return view('planning.workorder.index');
        });

        Route::get('/planning/item', 'Planning\ItemsController@index');
        Route::get('/planning/bom', 'Planning\BOMController@index');

        Route::get('/mes/materials', function() {
            return view('mes.materials.podata');
        });

        Route::get('/mes/lot', 'WebPortal\LotRecordsController@index');
        Route::get('/mes/cabinet', 'WebPortal\CabinetsController@index');
        Route::get('/planning/item', 'Planning\ItemsController@index');
        Route::get('/planning/bom', 'Planning\BOMController@index');

        Route::get('/mes/issuance', 'WebPortal\WarehouseIssuanceController@index');
        Route::get('/mes/assign/lot', 'WebPortal\LotAssignController@index');

        // Route::get('/mes/stringer', 'WebPortal\LotTransactionsController@index');

        Route::get('/mes/duplicates', 'MESController@mesDups')->name('mes_dups');
        Route::get('/mes/duplicates/{start}/{end}/{location}', 'MESController@loadDups')->name('mes_duplicates');

        Route::get('/planning/products/data', 'Planning\ProductTypesController@load')->name('prodtypes_data');
        Route::resource('/planning/products','Planning\ProductTypesController');

        Route::get('/report/test', function() {
            return view('mes.reports.test');
        });
        Route::get('/output/test/{date?}', 'MESController@testOuts')->name('testouts_data');
    });
// }); 

Auth::routes();

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('google_login');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');
