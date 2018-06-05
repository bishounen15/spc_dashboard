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

Route::group(['middleware'=>['auth','revalidate']], function() {

Route::get('/Summary', 'PagesController@Summary');
Route::get('/pulltest', 'PagesController@pulltest');

Route::resource('lam', 'LamController');
Route::resource('laytec', 'LaytecController');
Route::resource('pulltest', 'PulltestController');
Route::resource('pulltestEG', 'PulltestEGController');
Route::resource('stringer', 'StringerController');
Route::resource('flash', 'FlashController');

Route::resource('matrixpulltest', 'MatrixPullTestsController');
Route::resource('matsolder', 'MatSolderingPostsController');
// Route::resource('pulltest', 'MatrixpulltestController');

Route::resource('Potting','PottingController');
Route::resource('Curing','CuringController');
Route::resource('SolderTemp','solderTempController');
Route::resource('JBox','JBoxController');
Route::resource('Frame','FrameController');
Route::resource('Framming','SqBwController');
Route::resource('MixRatio','MixRatioController');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
