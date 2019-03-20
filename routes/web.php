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
    Route::group(['middleware'=>['web','auth','revalidate']], function() {

        Route::get('/Apps','PagesController@apps')->name('apps');

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

    });
// }); 

Auth::routes();

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('google_login');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');
