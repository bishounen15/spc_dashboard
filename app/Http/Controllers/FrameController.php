<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\frameQual;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('SELECT * FROM frame_quals');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
        return view('backEnd.frameQual')->with('frameLogs',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.frameCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new frameQual;
        $post->qualTransID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->qualTime = $request->input('fixture_date');
        $post->serialNo = $request->input('serialNo');
            $post->L1woSealantWt= $request ->input('L1woSealant');
            $post->L1wSealantWt= $request ->input('L1wSealant');
            $post->L2woSealantWt= $request ->input('L2woSealant');
            $post->L2wSealantWt= $request ->input('L2wSealant');
            $post->S1woSealantWt= $request ->input('S1woSealant');
            $post->S1wSealantWt= $request ->input('S1wSealant');
            $post->S2woSealantWt= $request ->input('S2woSealant');
            $post->S2wSealantWt= $request ->input('S2wSealant');
            $post->L1diff= $request ->input('L1diff');
            $post->L2diff= $request ->input('L2diff');
            $post->S1diff= $request ->input('S1diff');
            $post->S2diff= $request ->input('S2diff');
            $post->weight= $request ->input('sum');
            $post->beadScale= $request ->input('beadScale');
            $post->facilitySupply= $request ->input('facilitySupply');
            $post->mainPressure= $request ->input('mainPressure');
            $post->paramID= $request ->input('');
            $post->TargetParam= $request ->input('');
            $post->remarks= $request ->input('remarks');
       // $post->crossSection = $request->input('crossSection');
        $post->save();

        return redirect('/Frame')->with('success','Record was successfully added!');
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
