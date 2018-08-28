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
        //$post = Post::all();
        $posts = DB::select('SELECT * FROM mat_solderings ORDER BY id DESC');
        return view('matrix.matsolderingtemp')->with('matsolderingtemp', $posts);
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
                //'station' => 'required', //added
                'employeeid' => 'required',       
                //'' => 'required',
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required',
                'temp1' => 'required|numeric',
                'temp2' => 'required|numeric',
                'temp3' => 'required|numeric',
                'average' => 'required', 
                'bottemp1' => 'required|numeric',
                'bottemp2' => 'required|numeric',
                'bottemp3' => 'required|numeric', 
                'botaverage' => 'required',               
                'remarks' => 'required',
                
            ]);

        //Create Post
        //$post = $request->post;
        $post = new MatSolderingPost;
        $post->EmployeeID = $request->input('employeeid');
        $post->Location = $request->input('process');
        $post->Shift = $request->input('shift');
        $post->Node = $request->input('node');
        $post->Supplier = $request->input('supplier');
        $post->temp1 = $request->input('temp1');
        $post->temp2 = $request->input('temp2');
        $post->temp3 = $request->input('temp3');
        $post->Average = $request->input('average');
        $post->bottemp1 = $request->input('bottemp1');
        $post->bottemp2 = $request->input('bottemp2');
        $post->bottemp3 = $request->input('bottemp3');
        $post->botAverage = $request->input('botaverage');
        $post->Remarks = $request->input('remarks');
        $post->created_at = $request->input('date');
        $post->save ();
        return redirect('/matsoldertemp')->with('success', 'Record successfully added.');
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
        return view('pages.about')->with('matsolderingposts', $post);
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
        $post->string = $request->input('process');
        $post->string = $request->input('station');
        $post->string = $request->input('shift');
        $post->string = $request->input('node');
        $post->string = $request->input('remarks');
        $post->string = $request->input('supplier');
        $post->string = $request->input('temp1');
        $post->string = $request->input('temp2');
        $post->string = $request->input('temp3');
        $post->float = $request->input('average');
        $post->string = $request->input('date');
        $post->save();
        return redirect('/matsoldertemp')->with('success', 'Record successfully added.');
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