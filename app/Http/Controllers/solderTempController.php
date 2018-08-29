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
      
$tempAveInd = DB::table(DB::connection('spc')->select("SELECT AVG(tempAve) AS AveInd FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps)"));
$AveInd = number_format($tempAveInd->from[0]->AveInd,6);
      
$StdAveInd = DB::table(DB::connection('spc')->select("SELECT STDDEV_SAMP(tempAve) AS StdInd FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps)"));
$StdInd = number_format($StdAveInd->from[0]->StdInd,6);

$weightAveOfAve = DB::table(DB::connection('spc')->select("SELECT AVG(aveTemp) as aveOfAve FROM (SELECT date, AVG(tempAve) as aveTemp FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps) GROUP BY date) as tblaveOfAve"));
$wtAveOfAve = number_format($weightAveOfAve->from[0]->aveOfAve,6);


$weightStdOfStd = DB::table(DB::connection('spc')->select("SELECT STDDEV_SAMP(stdTemp) as stdOfStd FROM (SELECT date, AVG(tempAve) as stdTemp FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps) GROUP BY date) as tblStdOfStd"));
$wtStdOfStd = number_format($weightStdOfStd->from[0]->stdOfStd,6);


$median = DB::table(DB::connection('spc')->select("SELECT date, AVG(tempAve) as aveTemp FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps) GROUP BY date ORDER BY aveTemp ASC"));
$medianCount = DB::table(DB::connection('spc')->select("SELECT COUNT(aveTemp) as aveCount FROM (SELECT date, AVG(tempAve) as aveTemp FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps) GROUP BY date ORDER BY aveTemp ASC)as tblcnt"));

$medianCountVal = $medianCount->from[0]->aveCount;
$medianMod = $medianCountVal%2;
// $wtAve = 0;

if($medianMod == 0){
    $midval1 = ($medianCountVal/2);
   $midval2 = $midval1 - 1;
  $medianVal1 = number_format($median->from[$midval1]->aveTemp,6);  
$medianVal2 = number_format($median->from[$midval2]->aveTemp,6);
$medianAve =number_format((($medianVal1 + $medianVal2)/2),6);
//$medianAve = $medianMod;
}else{
    $midval1 = number_format(($medianCountVal/2),2);
 $midval2 = round($midval1,1);
 $medianVal = number_format($median->from[$midval2]->avTemp,6);
   $medianAve = number_format($medianVal,6);
 // $medianAve = $medianMod;
}

$wtAveList = DB::table(DB::connection('spc')->select("SELECT date, AVG(tempAve) as aveWt FROM (SELECT date,tempAftAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve != 0 UNION SELECT date,tempBefAdjAve AS tempAve FROM `solder_temps` WHERE tempAftAdjAve = 0)as tblview WHERE date IN (SELECT * FROM view_soldertemps) GROUP BY date"));
//dd($median);
$arrAve = array();




$arrVal= "";
for($i=0;$i<$medianCountVal ;$i++){
  //  $arrVal= $arrVal.$wtAveList->from[$i]->aveWt.',';
    array_push($arrAve,$wtAveList->from[$i]->aveWt);
}


$percentile = $this->mypercentile($arrAve,0.00135);
$percentile2 = $this->mypercentile($arrAve,0.99865);

     //$tempBefAveSTD = 0;
     $UCL=372;
     $LCL=390;
     $CL = (($UCL-$LCL)/2)+$LCL;
     $target = 380;
     $USL = $target + 10;
     $LSL = $target - 10; 
$CpL = ABS(number_format(($wtAveOfAve-$LCL)/(3*$wtStdOfStd),4));
$CpU = ABS(number_format(($UCL-$wtAveOfAve)/(3*$wtStdOfStd),4));
$arrValForCpk = array($CpU,$CpL);
$Cpk = min($arrValForCpk);
$CpnU = ($USL - $medianAve)/($percentile2 - $medianAve);
$CpnL = ($medianAve - $LSL)/($medianAve - $percentile);
$arrValForCpn = array($CpnU,$CpnL);
$Cpn = min($arrValForCpn);
$zValue = ABS(number_format(($wtAveOfAve-$CL)/$wtStdOfStd,4));
return view('spc.backend.solder_temp.summary')
->with('aveInd',$AveInd)
->with('stdInd',$StdInd)
->with('avgOfAvg',$wtAveOfAve)
->with('stdOfStd',$wtStdOfStd)
->with('median',$medianAve)
->with('percentile',$percentile)
->with('percentile2',$percentile2)
->with('zValue',$zValue)
->with('UCL',$UCL)
->with('LCL',$LCL)
->with('CL',$CL)
->with('target',$target)
->with('USL',$USL)
->with('LSL',$LSL)
->with('CpL',number_format($CpL,2))
->with('CpU',number_format($CpU,2))
->with('Cpk',number_format($Cpk,2))
->with('Cpn',number_format($Cpn,2))
->with('CpnU',number_format($CpnU,2))
->with('CpnL',number_format($CpnL,2));
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
       $posts = SolderTemp::orderBy("id","DESC")->get(); //DB::connection('spc')->select('SELECT * FROM solder_temps ORDER BY ID DESC LIMIT 1');                                        
       return view('spc.backend.solder_temp.form')->with('tempLogs',$posts);
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
            'qualTime' => 'required|date_format:H:i'
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

    public function mypercentile($data,$percentile){ 
        if( 0 < $percentile && $percentile < 1 ) { 
            $p = $percentile; 
        }else if( 1 < $percentile && $percentile <= 100 ) { 
            $p = $percentile * .01; 
        }else { 
            return ""; 
        } 
        $count = count($data); 
        $allindex = ($count-1)*$p; 
        $intvalindex = intval($allindex); 
        $floatval = $allindex - $intvalindex; 
        sort($data); 
        if(!is_float($floatval)){ 
            $result = $data[$intvalindex]; 
        }else { 
            if($count > $intvalindex+1) 
                $result = number_format(($floatval*($data[$intvalindex+1] - $data[$intvalindex]) + $data[$intvalindex]),4); 
            else 
                $result = $data[$intvalindex]; 
        } 
        return $result; 
    } 

   
}
