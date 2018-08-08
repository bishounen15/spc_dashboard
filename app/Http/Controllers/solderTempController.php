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
      
$tempAveInd = DB::table(DB::select("SELECT AVG(tempAve) AS AveInd FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps)"));
$AveInd = number_format($tempAveInd->from[0]->AveInd,2);
      
$StdAveInd = DB::table(DB::select("SELECT STDDEV(tempAve) AS StdInd FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps)"));
$StdInd = number_format($StdAveInd->from[0]->StdInd,2);
return view('backEnd.solderTempSum')
->with('aveInd',$AveInd)
->with('stdInd',$StdInd);
//->with('stdavg',$stdavg)
//->with('median',$median);
//->with('aveback',$aveback)
//->with('aveback1',$aveback1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('backEnd.curingTestCreate');
       $posts = DB::select('SELECT * FROM solder_temps ORDER BY ID DESC LIMIT 1');                                        
       //$posts  = Post::orderBy('created_at','desc')->paginate(2);
         return view('backEnd.solderTempCreate')->with('tempLogs',$posts);
        //return view('backEnd.solderTempCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [ 
            'AdjBeftTmp1' => 'required',
            'AdjBeftTmp2' => 'required',
            'AdjBeftTmp3' => 'required',

            'AdjAftTmp1' => 'required|numeric|min:0',
            'AdjAftTmp2' =>  'required|numeric|min:0',
            'AdjAftTmp3' => 'required|numeric|min:0',
            'qualTime' => 'required'
        ]);

   
        $post = new SolderTemp;
        $post->transID = $request->input('qualTransID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->qualTime = $request->input('qualTime');
        $post->tempBefAdj1 = $request->input('AdjBeftTmp1');
        $post->tempBefAdj2 = $request->input('AdjBeftTmp2');
        $post->tempBefAdj3 = $request->input('AdjBeftTmp3');
        $post->tempAftAdj1 = $request->input('AdjAftTmp1');
        $post->tempAftAdj2 = $request->input('AdjAftTmp2');
        $post->tempAftAdj3 = $request->input('AdjAftTmp3');
        $post->tempAftAdjAve = $request->input('AdjAftAve');
        $post->tempBefAdjAve = $request->input('AdjBeftAve');
        $post->target = $request->input('target');
        $post->result = $request->input('qualRes');
        $post->remarks = $request->input('remarks');
        $post->jBox = $request->input('jBoxName');
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
