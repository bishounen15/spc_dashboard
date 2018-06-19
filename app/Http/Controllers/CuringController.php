<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\DB;
use App\CuringTest;

use Illuminate\Http\Request;

class CuringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('SELECT * FROM curing_tests');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
          return view('backEnd.curingTest')->with('curLogs',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.curingTestCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new CuringTest;
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->serialNo = $request->input('serialNo');
        $post->snapTime = $request->input('snapTime');
        $post->pottingTime = $request->input('pottingTime');
        $post->condition = $request->input('condition');
        $post->remarks = $request->input('remarks');
       // $post->crossSection = $request->input('crossSection');
        $post->save();

        return redirect('/Curing')->with('success','Record was successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
