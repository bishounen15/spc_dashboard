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

 Route::get('/FrameQualRecords', function () {
        $posts = DB::select('SELECT * FROM frame_quals ORDER BY id DESC');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
       return view('backEnd.frameQual')->with('frameLogs',$posts);
 });

 Route::get('/solderTemp', function () {
    $posts = DB::select('SELECT * FROM solder_temps ORDER BY id DESC');                                        
       //$posts  = Post::orderBy('created_at','desc')->paginate(2);
        return view('backEnd.solderTemp')->with('tempLogs',$posts);
});
Route::get('/JBoxDispense', function () {
      $posts = DB::select('SELECT * FROM jbox_dis_wt_quals ORDER BY id DESC');                                        
         //$posts  = Post::orderBy('created_at','desc')->paginate(2);
          return view('backEnd.jBoxDispense')->with('disLogs',$posts);
  });

  Route::get('/mixRatio', function () {
        $posts = DB::select('SELECT * FROM  pottant_quals ORDER BY id DESC');                                        
           //$posts  = Post::orderBy('created_at','desc')->paginate(2);
            return view('backEnd.potMixingRatio')->with('MixLogs',$posts);
    });

    Route::get('/SqBw', function () {
        $posts = DB::select('SELECT * FROM  frame_sq_bws ORDER BY id DESC');                                        
           //$posts  = Post::orderBy('created_at','desc')->paginate(2);
            return view('backEnd.frameSqBw')->with('frameSBLogs',$posts);
    });

    Route::get('/rtobpulltest', function () {
        $posts = DB::select('SELECT * FROM rtobpulltest ORDER BY id DESC');
        return view('matrix.summatrixpulltest')->with('rtobpulltest', $posts);
    });

    Route::get('/matsoldertemp', function () {
        $posts = DB::select('SELECT * FROM mat_solderings ORDER BY id DESC');
        return view('matrix.summatsoldering')->with('matsolderingtemp', $posts);
    });

    Route::get('/btobpulltest', function () {
        $posts = DB::select('SELECT * FROM`btobpulltest` ORDER BY id DESC');
        return view('matrix.sumbtobpulltest')->with('btobpulltest', $posts);
    });


    
    Route::get('/offmatsoldering', function () {
        $posts = DB::select('SELECT * FROM offlinematsoldering ORDER BY id DESC');
    return view('matrix.sumofflinematsoldering')->with('offlinematsolderingtemp', $posts);
    });

    Route::get('/lamdata_view', function () {
   $posts = DB::select('SELECT * FROM Lams ORDER BY ID DESC');   
      return view('pages.lamdata')  
                    ->with('alldata',$posts);
    });

    Route::get('/pulltest_view', function () {
        $posts = DB::select('SELECT * FROM pull_tests ORDER BY ID DESC');   
           return view('pages.pulltestdata')  
                         ->with('alldata',$posts);
         });
         Route::get('/stringer_view', function () {
            $posts = DB::select('SELECT * FROM stringers ORDER BY ID DESC');   
               return view('pages.stringerdata')  
                             ->with('alldata',$posts);
             });

             Route::get('/ftd_view', function () {
                $posts = DB::select('SELECT * FROM flashes ORDER BY ID DESC');   
                   return view('pages.ftd')  
                                 ->with('alldata',$posts);
                 });
     


Route::get('/', 'PagesController@index');
//Route::get('/solder', 'solderTempController@index');
Route::get('/link','PagesController@link')->name('portal_link');

// Route::group(['middleware'=>['auth','revalidate']], function() {

Route::get('/Apps','PagesController@apps')->name('apps');
Route::post('offlinebtob_sum','OfflineBtoBPullTestController@store_Sum')->name('offlinebtob.store_Sum');
Route::get('/Summary', 'PagesController@Summary');
Route::get('/Setup', 'PagesController@Setup');
Route::get('/pulltest', 'PagesController@pulltest');
//Route::get('/create', 'FrameController@store');

Route::resource('lam', 'LamController');
Route::resource('laytec', 'LaytecController');
//Route::resource('pulltest', 'PulltestController');
Route::resource('pulltestEG', 'PulltestEGController');
Route::resource('stringer', 'StringerController');
Route::resource('flash', 'FlashController');
Route::resource('pulltestdata', 'PulltestController');
Route::resource('lamdata', 'LamController');
Route::resource('stringerdata', 'StringerController');
Route::resource('ftd', 'FlashController');

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

Route::resource('process','processController');
Route::resource('bom','BOMtypeController');
Route::resource('product','productTypeController');
Route::resource('subprocess','subProcessController');
Route::resource('parameter','parameterController');
Route::resource('prodSelect','prodSelectionController');
Route::resource('flashsetup','flashsetupController');


Route::get('datatable', 'StringerController@datatable');
Route::get('datatable/getdata', 'StringerController@getPosts')->Name('datatable/getdata');
Route::resource('ELTest','ELTestController');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



