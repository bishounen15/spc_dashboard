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

Route::group(['middleware'=>['auth','revalidate']], function() {

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
Route::post('/user/create','UserController@create')->name('store_user');
Route::get('/user/{id}','UserController@show')->name('show_user');
Route::post('/user/{id}','UserController@modify')->name('modify_user');
Route::post('/user/remove/{id}','UserController@destroy')->name('remove_user');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
