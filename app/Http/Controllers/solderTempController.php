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
      //  $posts = DB::select('SELECT * FROM solder_temps');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
        //  return view('backEnd.solderTemp')->with('tempLogs',$posts);

//new ave
/*
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
*/
$tempAftAve = DB::table('solder_temps')
->select('tempAftAdjAve AS tempAve')
->where('tempAftAdjAve','!=','0');

$tempBefAve = DB::table('solder_temps')
->select('tempBefAdjAve AS tempAve')
->where('tempAftAdjAve','0')
->unionAll($tempAftAve)
->whereBetween('date', [date('Y-m-d',strtotime("-30 days")), date('Y-m-d')])
->get();

$tempAve = number_format($tempBefAve->avg('tempAve'),2);



//stdInd

$tempBefAveSTD = DB::table(DB::raw("((SELECT tempAftAdjAve as tempAve,date FROM `solder_temps` WHERE tempAftAdjAve != 0) UNION ALL (SELECT tempBefAdjAve as tempAve,date FROM `solder_temps` WHERE tempAftAdjAve = 0) ) as temp"))
->select(DB::raw('STDDEV(tempAve) as  tempAve','date'))
->whereBetween('date', [date('Y-m-d',strtotime("-30 days")), date('Y-m-d')])
->get();
$tempBefAveSTD = number_format($tempBefAveSTD[0]->tempAve,2);


/*
$stdfront = DB::table('solder_temps')
->select(DB::raw('STDDEV(tempBefAdjAve) as tempBefAdjAve'))
->whereBetween('date', [date('Y-m-d',strtotime("-30 days")), date('Y-m-d')])
->get();
$stdfront = number_format($stdfront[0]->tempBefAdjAve,2);

*/
$xbbfront = DB::table('solder_temps')
->select(DB::raw('AVG(tempBefAdjAve) as tempBefAdjAve'))
->whereBetween('date', [date('Y-m-d',strtotime("-30 days")), date('Y-m-d')])
->groupBy('date')
->get();
$xbbfront = number_format($xbbfront->avg('tempBefAdjAve'),2);
//$xbbfront = number_format($xbbfront,2);


$stdavg = DB::table(DB::raw("(SELECT AVG(tempBefAdjAve) as tempBefAdjAve FROM solder_temps WHERE date BETWEEN '".date('Y-m-d',strtotime("-30 days"))."' AND '".date('Y-m-d')."' GROUP BY date) as temp"))
//date BETWEEN from AND to
->select(DB::raw('STDDEV(tempBefAdjAve) as tempBefAdjAve'))
->get();
$stdavg = number_format($stdavg->avg('tempBefAdjAve'),2);

$median = DB::table('solder_temps')
->select(DB::raw('AVG(tempBefAdjAve) as tempBefAdjAve'))
->whereBetween('date', [date('Y-m-d',strtotime("-30 days")), date('Y-m-d')])
->groupBy('date')
->get();


$median = number_format($median->median('tempBefAdjAve'),2);

//$aveback1 = (DB::table('stringers')->where('side','=','Back')->whereBetween('Date',['$start','$end'])->avg('PeelTest'));
//$posts = Post::orderBy('created_at','desc')->paginate(2);
return view('backEnd.solderTempSum') 
->with('avefront',$tempAve)
->with('stdfront',$tempBefAveSTD)
->with('xbbfront',$xbbfront)
->with('stdavg',$stdavg)
->with('median',$median);
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
        $this->validate($request, [ 
            'AdjBeftTmp1' => 'required',
            'AdjBeftTmp2' => 'required',
            'AdjBeftTmp3' => 'required',

            'AdjAftTmp1' => 'required',
            'AdjAftTmp2' => 'required',
            'AdjAftTmp3' => 'required',
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
