<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\OfflineBtoBPullTestPost;


class OfflineBtoBPullTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$post = Post::all();
        //$posts = DB::select('SELECT * FROM btobpulltest ORDER BY id DESC');
        //return view('matrix.btobpulltest')->with('btobpulltest', $posts);

        $avefront = DB::table(DB::raw("(SELECT SUM(pulltest1 + pulltest2 +pulltest3) as pulltest FROM btobpulltest) as temp"))
        //date BETWEEN from AND to
        ->select(DB::raw('AVG(pulltest/3) as pulltest'))
        ->get();
        $avefront = number_format($avefront->avg('pulltest'),2);

        $pulltests1 = DB::table('btobpulltest')
            ->select('pulltest1 AS pulltest');
        $pulltests2 = DB::table('btobpulltest')
            ->select('pulltest2 AS pulltest');

        $pulltests3 = DB::table('btobpulltest')
            ->select('pulltest3 AS pulltest')
            ->unionAll($pulltests1)
            ->unionAll($pulltests2)
          // ->STDDEV('pulltest AS pulltest')
            ->get();

       
        
      //  $stdave = number_format($stdave->avg('pulltest'),2);
      $stdave = number_format($pulltests3->avg('pulltest'),2);
        return view('matrix.btobpulltest') 
        ->with('avefront',$avefront)
        ->with('stdave',$stdave);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matrix.createofflinebtobpulltest');
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
                'employeeid' => 'required|numeric',       
                'location' => 'required',
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required',  
                'site1' => 'required',
                'pulltest1' => 'required|numeric',
                'site2' => 'required',
                'pulltest2' => 'required|numeric',
                'site3' => 'required',
                'pulltest3' => 'required|numeric',
                'remarks' => 'required',
                'average' => 'required',
            ]);

        //Create Post
        //$post = $request->post;
        $post = new OfflineBtoBPullTestPost;
        $post->EmployeeID = $request->input('employeeid');
        $post->Location = $request->input('location');
        $post->Shift = $request->input('shift');
        $post->Node = $request->input('node');
        $post->Supplier = $request->input('supplier');
        $post->Site1 = $request->input('site1');
        $post->PullTest1 = $request->input('pulltest1');
        $post->Site2 = $request->input('site2');
        $post->PullTest2 = $request->input('pulltest2');
        $post->Site3 = $request->input('site3');
        $post->PullTest3 = $request->input('pulltest3');
        $post->Remarks = $request->input('remarks');
        $post->Average = $request->input('average');
        $post->created_at = $request->input('date');
        $post->save ();
        return redirect('/offlinebtob')->with('success', 'Data Created');
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
        $post = OfflineBtoBPullTestPost::find($id);
        return view('pages.about')->with('offlinebtobpulltest', $post);
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
        $post = OfflineBtoBPullTest::find($id);
        $post->string = $request->input('location');
        $post->string = $request->input('station');
        $post->string = $request->input('shift');
        $post->string = $request->input('node');
        $post->string = $request->input('site1');
        $post->string = $request->input('pulltest1');
        $post->string = $request->input('site2');
        $post->string = $request->input('pulltest2');
        $post->string = $request->input('site3');
        $post->string = $request->input('pulltest3');
        $post->string = $request->input('average');
        $post->string = $request->input('remarks');
        $post->save();
        return redirect('/offlinebtobpulltest')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = OfflineBtoBPullTest::find($id);
        $post->delete();
        return redirect('/offlinebtobpulltest')->with('success', 'Data Deleted');
    }
}