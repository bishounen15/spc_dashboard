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
        Route::get('/mes/transactions/{date}/{shift}/{station}', 'MESController@transactions')->name('mes_trx');
        Route::get('/mes/output/{date?}', 'MESController@dailyOutput')->name('mes_output');
        Route::post('/mes/validate', 'MESController@serialValidation')->name('mes_validate');
        Route::get('/mes','MESController@index')->name('mes_daily');
        Route::get('/mescreate/{station}','MESController@create')->name('add_mes_trx');
        Route::post('/mescreate/{station}','MESController@store')->name('save_mes_trx');
        Route::get('/mes/ftd', 'MESController@ftd')->name('mes_ftd');
        Route::post('/mes/ftdreport', 'MESController@ftdReport')->name('mes_ftdreport');
        Route::post('/mes/resetpower/{serial}/{rowid}', 'MESController@resetPower')->name('mes_resetpower');
        // Route::resource('/mes','MESController');
        Route::get('/trina/ftdreport', 'TRINA\ReportsController@ftdReport')->name('trina_ftd_report');
        Route::get('/trina/ftd/{start}/{end}', 'TRINA\ReportsController@ftd')->name('trina_ftd');

        Route::get('/trina/lotreport', 'TRINA\ReportsController@lotReport')->name('trina_lot_report');
        Route::get('/trina/lot', 'TRINA\ReportsController@LotNumbers')->name('trina_ftd');
        
        Route::post('/modules/inquire','ModulesController@inquire')->name('module_inquiry');
        Route::get('/modules/ftd/{serial}','ModulesController@ftd')->name('ftd_data');
        Route::get('/modules/mes/{serial}','ModulesController@mes')->name('mod_mes');
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
    });
// }); 

Auth::routes();

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('google_login');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');
