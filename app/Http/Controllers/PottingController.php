<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\DB;
use App\POttingQual;

class PottingController extends Controller
{
    /**
     * Display a listing of the resource.
     *ss
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       // $title = "Back End";
     //   return view('backEnd.pottingQual');
        $posts = POttingQual::get(); //DB::select('SELECT * FROM potting_quals');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
          return view('backEnd.pottingQual')->with('potLogs',$posts);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //  $this->validate($request,[
           // 'title' =>'required',
            //'body' => 'required'
      //  ]);
       
            //create Post
            $post = new POttingQual;
            $post->shift = $request->input('shift');
            $post->time = $request->input('fixture_date');
            $post->pottantName = $request->input('pottantName');
            $post->jBoxName = $request->input('jboxName');
            $post->pottantWeight = $request->input('pottantWt');
            $post->snapTime = $request->input('snapTime');
            $post->crossSection = $request->input('crossSection');
            $post->save();

            return redirect('/Potting')->with('success','Record was successfully added!');
            
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
         $post = POttingQual::find($id);
       //$posts = DB::select('SELECT * FROM potting_quals');   
       $post->delete();
        return redirect('/Potting')->with('success','Post '.$id.' Removed');
    }
}
