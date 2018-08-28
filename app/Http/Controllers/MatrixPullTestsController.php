<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\MatrixPullTest;
//use DB;


class MatrixPullTestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
       // $post = MatrixPullTest::all();
        $posts = DB::select('SELECT * FROM rtobpulltest ORDER BY id DESC');
        return view('matrix.matrixpulltest')->with('rtobpulltest', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()
    {
        return view('matrix.creatematrixpulltest');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
              

           if( $request->input('process')=='Rework'){
            $this->validate($request,[   
                'botpulltest1' => 'required',
                'botpulltest2' => 'required',
                'botpulltest3' => 'required',
                'botaverage' => 'required',
                'remarks' => 'required',
                'employeeid' => 'required|numeric',
              
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required'
             
            ]);

           
    
            
           
$EmployeeID = $request->input('employeeid');
$Location = $request->input('process');
$Shift = $request->input('shift');
$Node = $request->input('node');
$Supplier = $request->input('supplier');
$Site1 =0;
$Site2 = 0;
$Site3 = 0;
$bAverage = 0;
$twoSite1 = 0;
$twoSite2 = 0;
$twoSite3 = 0;
$twoAverage = 0;
$botSite1 = $request->input('botpulltest1');
$botSite2 = $request->input('botpulltest2');
$botSite3 = $request->input('botpulltest3');
$botAverage =  $request->input('botaverage');
$Remarks = $request->input('remarks');

$post = new MatrixPullTest;
$post->EmployeeID = $EmployeeID;
$post->Location = $Location;
$post->Shift = $Shift;
$post->Node = $Node;
$post->Supplier = $Supplier;
$post->site1 = $Site1;
$post->site2 = $Site2;
$post->site3 = $Site3;
$post->Average = $bAverage;
$post->twosite1 = $twoSite1;
$post->twosite2 = $twoSite2;
$post->twosite3 = $twoSite3;
$post->twoAverage = $twoAverage;
$post->botsite1 = $botSite1;
$post->botsite2 = $botSite2;
$post->botsite3 = $botSite3;
$post->botAverage = $botAverage;
$post->Remarks = $Remarks;
$post->save ();
return redirect('/rtobpulltest')->with('success', 'Record successfully added.');

           }else{

            $this->validate($request,[       
                'employeeid' => 'required|numeric',
                //'location' => '',
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required',
                'pulltest1' => 'required',
                'pulltest2' => 'required',
                'pulltest3' => 'required',
                'average' => 'required',
                'twopulltest1' => 'required',
                'twopulltest2' => 'required',
                'twopulltest3' => 'required',
                'twoAverage' => 'required',
                'remarks' => 'required'
             
            ]);

            $EmployeeID = $request->input('employeeid');
            $Location = $request->input('process');
            $Shift = $request->input('shift');
            $Node = $request->input('node');
            $Supplier = $request->input('supplier');
            $Site1 = $request->input('pulltest1');
            $Site2 = $request->input('pulltest2');
            $Site3 = $request->input('pulltest3');
            $bAverage = $request->input('average');
            $twoSite1 = $request->input('twopulltest1');
            $twoSite2 = $request->input('twopulltest2');
            $twoSite3 = $request->input('twopulltest3');
            $twoAverage = $request->input('twoAverage');
            $botSite1 = 0;
            $botSite2 = 0;
            $botSite3 = 0;
            $botAverage = 0;
            $Remarks = $request->input('remarks');

            $post = new MatrixPullTest;
            $post->EmployeeID = $EmployeeID;
            $post->Location = $Location;
            $post->Shift = $Shift;
            $post->Node = $Node;
            $post->Supplier = $Supplier;
            $post->site1 = $Site1;
            $post->site2 = $Site2;
            $post->site3 = $Site3;
            $post->Average = $bAverage;
            $post->twosite1 = $twoSite1;
            $post->twosite2 = $twoSite2;
            $post->twosite3 = $twoSite3;
            $post->twoAverage = $twoAverage;
            $post->botsite1 = $botSite1;
            $post->botsite2 = $botSite2;
            $post->botsite3 = $botSite3;
            $post->botAverage = $botAverage;
            $post->Remarks = $Remarks;
            $post->save ();
            return redirect('/rtobpulltest')->with('success', 'Record successfully added.');
           }
           
/*
          $EmployeeID = $request->input('employeeid');
          $Location = $request->input('process');
          $Shift = $request->input('shift');
          $Node = $request->input('node');
          $Supplier = $request->input('supplier');
          $Site1 =0;
          $Site2 = 0;
          $Site3 = 0;
          $bAverage = 0;
          $twoSite1 = 0;
          $twoSite2 = 0;
          $twoSite3 = 0;
          $twoAverage = 0;
          $botSite1 = $request->input('botpulltest1');
          $botSite2 = $request->input('botpulltest2');
          $botSite3 = $request->input('botpulltest3');
          $botAverage =  $request->input('botaverage');
          $Remarks = $request->input('remarks');
          */

        //Create Post
        //$post = $request->post;
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //return redirect('/posts/create')->with('success', 'Data Created');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = MatrixPullTest::find($id);
        return view('pages.show')->with('post', $post);
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
        $post = MatrixPullTest::find($id);
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
        return redirect('/matrix/create')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = MatrixPullTest::find($id);
        $post->delete();
        return redirect('/matrix')->with('success', 'Data Deleted');
    }
}