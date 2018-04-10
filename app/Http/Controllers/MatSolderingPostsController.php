<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\MatSolderingPost;


class MatSolderingPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();
        $matsolderingposts = DB::select('SELECT * FROM matsolderingposts');
        return view('matsolderingposts.about')->with('matsolderingposts', $post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matrix.creatematsoldering');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate
            $this->validate($request, [  
                'station' => 'required',       
                'location' => 'required',
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required',
                'site1' => 'required',
                'temp1' => 'required',
                'site2' => 'required',
                'temp2' => 'required',
                'site3' => 'required',
                'temp3' => 'required',
                'remarks' => 'required',
                'average' => 'required',
            ]);

        //Create Post
        //$post = $request->post;
        $post = new MatSolderingPost;
        $post->Station = $request->input('station');
        $post->Location = $request->input('location');
        $post->Shift = $request->input('shift');
        $post->Node = $request->input('node');
        $post->Supplier = $request->input('supplier');
        $post->Site1 = $request->input('site1');
        $post->Temp1 = $request->input('temp1');
        $post->Site2 = $request->input('site2');
        $post->Temp2 = $request->input('temp2');
        $post->Site3 = $request->input('site3');
        $post->Temp3 = $request->input('temp3');
        $post->Remarks = $request->input('remarks');
        $post->Average = $request->input('average');
        $post->created_at = $request->input('date');
        $post->save ();
        return redirect('/matsolder/create')->with('success', 'Data Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return redirect('/posts/creatematsoldering')->with('success', 'Data Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = MatSolderingPost::find($id);
        return view('pages.about')->with('matsolderingpost', $post);
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
        //Validate
        
        //Create Post
        $post = MatSolderingPost::find($id);
        $post->string = $request->input('location');
        $post->string = $request->input('station');
        $post->string = $request->input('shift');
        $post->string = $request->input('node');
        $post->string = $request->input('site');
        $post->string = $request->input('temp');
        $post->string = $request->input('remarks');
        $post->float = $request->input('average');
        $post->string = $request->input('date');
        $post->save();
        return redirect('/matsolderingposts')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = MatSolderingPost::find($id);
        $post->delete();
        return redirect('/matsolderingposts')->with('success', 'Data Deleted');
    }
}