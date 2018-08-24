<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\frameSqBw;

class SqBwController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $posts = DB::select('SELECT * FROM frame_sq_bws');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);

        

        $LdiffAve = DB::table(DB::select("SELECT AVG(LDiff) as aveWt FROM (SELECT LDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview"));
        $lfAve = number_format($LdiffAve ->from[0]->aveWt,6);
        $SdiffAve = DB::table(DB::select("SELECT AVG(SDiff) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview"));
        $sfAve = number_format($SdiffAve ->from[0]->aveWt,6);
        $DdiffAve = DB::table(DB::select("SELECT AVG(DDiff) as aveWt FROM (SELECT DDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview"));
        $dfAve = number_format($DdiffAve ->from[0]->aveWt,6);
        $LdiffStd = DB::table(DB::select("SELECT STDDEV_SAMP(LDiff) as aveWt FROM (SELECT LDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview"));
        $lfStd = number_format($LdiffStd ->from[0]->aveWt,6);
        $SdiffStd = DB::table(DB::select("SELECT STDDEV_SAMP(SDiff) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview"));
        $sfStd = number_format($SdiffStd ->from[0]->aveWt,6);
        $DdiffStd = DB::table(DB::select("SELECT STDDEV_SAMP(DDiff) as aveWt FROM (SELECT DDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview"));
        $dfStd = number_format($DdiffStd ->from[0]->aveWt,6);
        $LdiffAveOfAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM (SELECT AVG(LDiff) as aveWt FROM (SELECT LDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date) as tbl_avgOfAvg"));
        $LFAveOfAve = number_format($LdiffAveOfAve->from[0]->aveOfAve,6);
        $SdiffAveOfAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM (SELECT AVG(SDiff) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date) as tbl_avgOfAvg"));
        $SFAveOfAve = number_format($LdiffAveOfAve->from[0]->aveOfAve,6);
        $DdiffAveOfAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM (SELECT AVG(DDiff) as aveWt FROM (SELECT DDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date) as tbl_avgOfAvg"));
        $DFAveOfAve = number_format($LdiffAveOfAve->from[0]->aveOfAve,6);
        $LdiffStdOfStd = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM (SELECT AVG(LDiff) as aveWt FROM (SELECT LDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date) as tbl_avgOfAvg"));
        $LFStdOfStd = number_format($LdiffStdOfStd->from[0]->stdOfStd,6);
        $SdiffStdOfStd = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM (SELECT AVG(SDiff) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date) as tbl_avgOfAvg"));
        $SFStdOfStd = number_format($LdiffStdOfStd->from[0]->stdOfStd,6);
        $DdiffStdOfStd = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM (SELECT AVG(DDiff) as aveWt FROM (SELECT DDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date) as tbl_avgOfAvg"));
        $DFStdOfStd = number_format($LdiffStdOfStd->from[0]->stdOfStd,6);

        $medianSqlL = "SELECT ROUND(AVG(LDiff),6) as aveWt FROM (SELECT LDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview GROUP BY date ORDER BY aveWt ASC";
        $medianCountL = "SELECT COUNT(aveWt) as aveCount FROM (SELECT ROUND(AVG(LDiff),6) as aveWt FROM (SELECT LDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date ORDER BY aveWt ASC) as tblcnt" ;
        $medianLDiff = $this->getMedian($medianSqlL,$medianCountL);
        $medianSqlS = "SELECT ROUND(AVG(SDiff),6) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview GROUP BY date ORDER BY aveWt ASC";
        $medianCountS = "SELECT COUNT(aveWt) as aveCount FROM (SELECT ROUND(AVG(SDiff),6) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date ORDER BY aveWt ASC) as tblcnt" ;
        $medianSDiff = $this->getMedian($medianSqlS,$medianCountS);
        $medianSqlD = "SELECT ROUND(AVG(DDiff),6) as aveWt FROM (SELECT DDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) )as tblview GROUP BY date ORDER BY aveWt ASC";
        $medianCountD = "SELECT COUNT(aveWt) as aveCount FROM (SELECT ROUND(AVG(DDiff),6) as aveWt FROM (SELECT DDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw)  )as tblview GROUP BY date ORDER BY aveWt ASC) as tblcnt" ;
        $medianDDiff = $this->getMedian($medianSqlD,$medianCountD);

        $listLFsql ="SELECT AVG(LDiff) as aveWt FROM (SELECT LDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) ) as aveWt GROUP BY date";
        $listLF1 = $this->getList4percentile($listLFsql,0.00135,$medianCountL);
        $listLF2= $this->getList4percentile($listLFsql,0.99865,$medianCountL);
        $listSsql = "SELECT date, AVG(SDiff) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) ) as aveWt GROUP BY date";
        $listSF1 = $this->getList4percentile($listSsql,0.00135,$medianCountS);
        $listSF2 = $this->getList4percentile($listSsql,0.99865,$medianCountS);
        $listSsql = "SELECT date, AVG(SDiff) as aveWt FROM (SELECT SDiff,date FROM frame_sq_bws WHERE date IN (SELECT * FROM view_framesqbw) ) as aveWt GROUP BY date";
        $listDF1 = $this->getList4percentile($listSsql,0.00135,$medianCountD);
        $listDF2 = $this->getList4percentile($listSsql,0.99865,$medianCountD);


        $UCL_S = 0.99;
        $LCL_S = (-1.36);
        $UCL_L = 0.93;
        $LCL_L = (-2.08);
        $UCL_D = 2.01;
        $LCL_D = (-1.28);
        $target = 0; 


        $CL_L = ($UCL_L-$LCL_L)/2+$LCL_L;
        $CL_S = ($UCL_S-$LCL_S)/2+$LCL_S;
        $CL_D = ($UCL_D-$LCL_D)/2+$LCL_D;

        $USL_L = $target + 1.5;
        $USL_S = $target + 1.5;
        $USL_D = $target + 3;
        $LSL_L = $target - 1.5;
        $LSL_S = $target - 1.5;
        $LSL_D = $target - 0;

        $CpL_L = ABS(number_format($this->divideByZeroExempt(($LFAveOfAve -$LCL_L),(3*$LFStdOfStd)),4));
        $CpL_S = ABS(number_format($this->divideByZeroExempt(($SFAveOfAve -$LCL_S),(3*$SFStdOfStd)),4));
        $CpL_D = ABS(number_format($this->divideByZeroExempt(($DFAveOfAve -$LCL_D),(3*$DFStdOfStd)),4));

        $CpU_L = ABS(number_format($this->divideByZeroExempt(($UCL_L-$LFAveOfAve),(3*$LFStdOfStd)),4));
        $CpU_S = ABS(number_format($this->divideByZeroExempt(($UCL_S-$SFAveOfAve),(3*$SFStdOfStd)),4));
        $CpU_D = ABS(number_format($this->divideByZeroExempt(($UCL_D-$DFAveOfAve),(3*$DFStdOfStd)),4));
        $arrValForCpk_L = array($CpU_L,$CpL_L);
        $arrValForCpk_S = array($CpU_S,$CpL_S);
        $arrValForCpk_D = array($CpU_S,$CpL_D);
        $Cpk_L = min($arrValForCpk_L);
        $Cpk_S = min($arrValForCpk_S);
        $Cpk_D = min($arrValForCpk_D);


        $CpnU_L = $this->divideByZeroExempt(($USL_L - $medianLDiff),($listLF2 - $medianLDiff));
        $CpnU_S = $this->divideByZeroExempt(($USL_S - $medianSDiff),($listSF2 - $medianSDiff));
        $CpnU_D = $this->divideByZeroExempt(($USL_D - $medianDDiff),($listLF2 - $medianDDiff));

        $CpnL_L =$this->divideByZeroExempt(( $medianLDiff - $LSL_L),( $medianLDiff - $listLF1));
        $CpnL_S =$this->divideByZeroExempt(( $medianSDiff - $LSL_S),( $medianSDiff - $listSF1));
        $CpnL_D =$this->divideByZeroExempt(( $medianDDiff - $LSL_D),( $medianDDiff - $listDF1));
       
        $arrValForCpn_L = array($CpnU_L,$CpnL_L);
        $arrValForCpn_S = array($CpnU_S,$CpnL_S);
        $arrValForCpn_D = array($CpnU_D,$CpnL_D);
        $Cpn_L = min($arrValForCpn_L);
        $Cpn_S = min($arrValForCpn_S);
        $Cpn_D = min($arrValForCpn_D);

        $zValue_L = ABS(number_format($this->divideByZeroExempt(($LFAveOfAve-$CL_L),$LFStdOfStd),4));
        $zValue_S = ABS(number_format($this->divideByZeroExempt(($SFAveOfAve-$CL_S),$SFStdOfStd),4));
        $zValue_D = ABS(number_format($this->divideByZeroExempt(($DFAveOfAve-$CL_D),$DFStdOfStd),4));
        //$CL = number_format($UCL-$LCL,4);
      /* 
       $CL = ($UCL-$LCL)/2+$LCL;
       $target = 13;
       $USL = $target + 2;
       $LSL = $target - 2;
       $CpL = ABS(number_format(($wtAveOfAve-$LCL)/(3*$wtStdOfStd),4));
       $CpU = ABS(number_format(($UCL-$wtAveOfAve)/(3*$wtStdOfStd),4));
       $arrValForCpk = array($CpU,$CpL);
       $Cpk = min($arrValForCpk);
       $CpnU = ($USL - $medianAve)/($percentile2 - $medianAve);
       $CpnL = ($medianAve - $LSL)/($medianAve - $percentile);
       $arrValForCpn = array($CpnU,$CpnL);
       $Cpn = min($arrValForCpn);
       $zValue = ABS(number_format(($wtAveOfAve-$CL)/$wtStdOfStd,4)); */

          return view('backEnd.frameSqBwSum')
          ->with('aveLF',$lfAve)
          ->with('aveSF',$sfAve)
          ->with('aveSq',$dfAve)
          ->with('sqLF',$lfStd)
          ->with('sqSF',$sfStd)
          ->with('sqSq',$dfStd)
          ->with('LFAveOfAve',$LFAveOfAve)
          ->with('SFAveOfAve',$SFAveOfAve)
          ->with('DFAveOfAve',$DFAveOfAve)
          ->with('LFStdOfStd',$LFStdOfStd)
          ->with('SFStdOfStd',$SFStdOfStd)
          ->with('DFStdOfStd',$DFStdOfStd)
          ->with('medianLDiff', $medianLDiff)
          ->with('medianSDiff', $medianSDiff)
          ->with('medianDDiff', $medianDDiff)
          ->with('listLF1',$listLF1)
          ->with('listLF2',$listLF2)
          ->with('listSF1',$listSF1)
          ->with('listSF2',$listSF2)
          ->with('listDF1',$listDF1)
          ->with('listDF2',$listDF2)
          ->with('UCL_S',$UCL_S)
          ->with('UCL_L',$UCL_L)
          ->with('UCL_D',$UCL_D)
          ->with('LCL_D',$LCL_D)
          ->with('LCL_S',$LCL_S)
          ->with('LCL_L',$LCL_L)
          ->with('USL_L',$USL_L)
          ->with('USL_S',$USL_S)
          ->with('USL_D',$USL_D)
          ->with('target_L',$target)
          ->with('target_S',$target)
          ->with('target_D',$target)
          ->with('Z_L',$zValue_L)
          ->with('Z_S',$zValue_S)
          ->with('Z_D',$zValue_D)
          ->with('CpU_L',$CpU_L)
          ->with('CpU_S',$CpU_S)
          ->with('CpU_D',$CpU_D)
          ->with('CpL_L',$CpL_L)
          ->with('CpL_S',$CpL_S)
          ->with('CpL_D',$CpL_D)
          ->with('Cpk_L',$Cpk_L)
          ->with('Cpk_S',$Cpk_S)
          ->with('Cpk_D',$Cpk_D)
          ->with('LCL_S',$LCL_S)
          ->with('LCL_L',$LCL_L)
          ->with('LCL_D',$LCL_D)
          ->with('UCL_S',$UCL_S)
          ->with('UCL_L',$UCL_L)
          ->with('UCL_D',$UCL_D)
          ->with('CL_S',$CL_S)
          ->with('CL_L',$CL_L)
          ->with('CL_D',$CL_D)
          ->with('USL_L',$USL_L)
          ->with('USL_S',$USL_S)
          ->with('USL_D',$USL_D)
          ->with('LSL_L',$LSL_L)
          ->with('LSL_S',$LSL_S)
          ->with('LSL_D',$LSL_D)
          ->with('Cpn_L',$Cpn_L)
          ->with('Cpn_S',$Cpn_S)
          ->with('Cpn_D',$Cpn_D)
          ->with('CpnU_L',$CpnU_L)
          ->with('CpnU_S',$CpnU_S)
          ->with('CpnU_D',$CpnU_D)
          ->with('CpnL_L',$CpnL_L)
          ->with('CpnL_S',$CpnL_S)
          ->with('CpnL_D',$CpnL_D);


         
         


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // return view('backEnd.frameSqBwCreate');

        $posts = DB::select('SELECT * FROM frame_sq_bws ORDER BY ID DESC LIMIT 1');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
       return view('backEnd.frameSqBwCreate')->with('frameSBLogs',$posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 
          'serialNoTxt' => 'required',
          'qualTime' => 'required',
          'L1txt' => 'required',
          'L2txt' => 'required',
          'L3txt' => 'required',
          'S1txt' => 'required',
          'S2txt' => 'required',
          'S3txt' => 'required',
           'D1txt' => 'required',
           'D2txt' => 'required' 
             ]); 

        $post = new frameSqBw;
        $post->qualTransID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->moduleID = $request->input('serialNoTxt');
        $post->qualTime = $request->input('qualTime');
        $post->cellCount = $request->input('cellType');
            $post->L1= $request ->input('L1txt');
            $post->L2= $request ->input('L2txt');
            $post->L3= $request ->input('L3txt');
            $post->S1= $request ->input('S1txt');
            $post->S2= $request ->input('S2txt');
            $post->S3= $request ->input('S3txt');
            $post->D1= $request ->input('D1txt');
            $post->D2= $request ->input('D2txt');
            $post->LDiff= $request ->input('LDiff');
            $post->SDiff= $request ->input('SDiff');
            $post->qualRes= $request ->input('qualRes');
            $post->target= $request ->input('target');
            $post->DDiff= $request ->input('DDiff');
            $post->remarks= $request ->input('remarkstxt');
       // $post->crossSection = $request->input('crossSection');
        $post->save();

        return redirect('/Framming')->with('success','Record was successfully added!');
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
    public function getMedian($medianSql, $medianCount)
    {
        $median = DB::table(DB::select($medianSql));
        $medianCount = DB::table(DB::select($medianCount));

        $medianCountVal = $medianCount->from[0]->aveCount;
        $medianMod = $medianCountVal%2;
        if($medianMod == 0){
        $midval1 = ($medianCountVal/2);
        $midval2 = $midval1 - 1;
        $medianVal1 = number_format($median->from[$midval1]->aveWt,6);  
        $medianVal2 = number_format($median->from[$midval2]->aveWt,6);
        $medianAve =number_format((($medianVal1 + $medianVal2)/2),6);
        return $medianAve;
        }else{
        $midval1 = number_format(($medianCountVal/2),2);
        $midval2 = round($midval1,1);
        $medianVal = number_format($median->from[$midval2]->aveWt,6);
        $medianAve = number_format($medianVal,6);
        return $medianAve;

}
     }
     public function getList4percentile($qry,$percentdec,$medianCountVal){
        $medianCount = DB::table(DB::select($medianCountVal));
        $wtAveList = DB::table(DB::select($qry));
        $medianCountValue = $medianCount->from[0]->aveCount;
        //dd($median);
        $arrAve = array();
        
        $arrVal= "";
        for($i=0;$i<$medianCountValue ;$i++){
          //  $arrVal= $arrVal.$wtAveList->from[$i]->aveWt.',';
            array_push($arrAve,$wtAveList->from[$i]->aveWt);
        }

        $percentile = $this->mypercentile($arrAve,$percentdec);
        return $percentile;
      
     }
     public function getCL($UCL,$LCL){
        $CL = ($UCL-$LCL)/2+$LCL;
        return $CL;
        $target = 13;
        $USL = $target + 2;
        $LSL = $target - 2;
        $CpL = ABS(number_format(($wtAveOfAve-$LCL)/(3*$wtStdOfStd),4));
        $CpU = ABS(number_format(($UCL-$wtAveOfAve)/(3*$wtStdOfStd),4));
        $arrValForCpk = array($CpU,$CpL);
        $Cpk = min($arrValForCpk);
        $CpnU = ($USL - $medianAve)/($percentile2 - $medianAve);
        $CpnL = ($medianAve - $LSL)/($medianAve - $percentile);
        $arrValForCpn = array($CpnU,$CpnL);
        $Cpn = min($arrValForCpn);
        $zValue = ABS(number_format(($wtAveOfAve-$CL)/$wtStdOfStd,4));
     }
     public function divideByZeroExempt($val1,$val2){

        if($val2  == 0){
          return strval($val1). "/".strval($val2);
        }else{
          return ($val1)/($val2);
        }
     }

    
}
