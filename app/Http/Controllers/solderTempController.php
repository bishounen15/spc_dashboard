<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\SolderTemp;
class solderTempController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = SolderTemp::get(); //DB::select('SELECT * FROM solder_temps');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
          return view('backEnd.solderTemp')->with('tempLogs',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.solderTempCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new SolderTemp;
        $post->transID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->tempBefAdj = $request->input('tempBefAdj');
        $post->tempAftAdj = $request->input('tempAftAdj');
        $post->remarks = $request->input('remarks');
        $post->jBox = $request->input('jboxName');
       // $post->crossSection = $request->input('crossSection');
        $post->save();

        return redirect('/SolderTemp')->with('success','Record was successfully added!');
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
