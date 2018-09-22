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
       
       $getLastProd = DB::select("SELECT * FROM prodselect JOIN producttype ON prodselect.productName = producttype.prodName WHERE ProcessName ='Matrix Assembly' ORDER BY prodselect.created_at DESC LIMIT 1"); 
                      
        if(count($getLastProd) > 0)
        {
            foreach($getLastProd as $field)   
            {
                $prod =  $field->productName;
             $bom = $field->bomType;
            }

        }else{
            $prod = "Not Set";
        }

        
        if (strpos($prod, '5BB') ) {
            $bbno = "5bb";
        }else{
            $bbno = "4bb";
        }
                
                  
                 
        $node="Ribbon-to-BB Pull Strength";
        $aveIndBus1Top1 = $this->getAveInd('Top1','Bussing1',$prod);
        $aveIndBus1Top2 = $this->getAveInd('Top2','Bussing1',$prod);
        $aveIndBus1Bot = $this->getAveInd('Bottom','Bussing1',$prod);
        $aveIndBus2Top1 = $this->getAveInd('Top1','Bussing2',$prod);
        $aveIndBus2Top2 = $this->getAveInd('Top2','Bussing2',$prod);
        $aveIndBus2Bot =  $this->getAveInd('Bottom','Bussing2',$prod);
        $aveIndReWTop = $this->getAveInd('Top','Rework',$prod);
        $aveIndReWBot = $this->getAveInd('Bottom','Rework',$prod);

        $stdIndBus1Top1 = $this->getStdInd('Top1','Bussing1',$prod);
        $stdIndBus1Top2 = $this->getStdInd('Top2','Bussing1',$prod);
        $stdIndBus1Bot = $this->getStdInd('Bottom','Bussing1',$prod);
        $stdIndBus2Top1 = $this->getStdInd('Top1','Bussing2',$prod);
        $stdIndBus2Top2 = $this->getStdInd('Top2','Bussing2',$prod);
        $stdIndBus2Bot =  $this->getStdInd('Bottom','Bussing2',$prod);
        $stdIndReWTop = $this->getStdInd('Top','Rework',$prod);
        $stdIndReWBot = $this->getStdInd('Bottom','Rework',$prod);

        $aveOfAveBus1Top1 = $this->getAveOfAve('Top1','Bussing1',$prod);
        $aveOfAveBus1Top2 = $this->getAveOfAve('Top2','Bussing1',$prod);
        $aveOfAveBus1Bot = $this->getAveOfAve('Bottom','Bussing1',$prod);
        $aveOfAveBus2Top1 = $this->getAveOfAve('Top1','Bussing2',$prod);
        $aveOfAveBus2Top2 = $this->getAveOfAve('Top2','Bussing2',$prod);
        $aveOfAveBus2Bot =  $this->getAveOfAve('Bottom','Bussing2',$prod);
        $aveOfAveReWTop = $this->getAveOfAve('Top','Rework',$prod);
        $aveOfAveReWBot = $this->getAveOfAve('Bottom','Rework',$prod);

        $stdOfStdBus1Top1 = $this->getStdOfStd('Top1','Bussing1',$prod);
        $stdOfStdBus1Top2 = $this->getStdOfStd('Top2','Bussing1',$prod);
        $stdOfStdBus1Bot = $this->getStdOfStd('Bottom','Bussing1',$prod);
        $stdOfStdBus2Top1 = $this->getStdOfStd('Top1','Bussing2',$prod);
        $stdOfStdBus2Top2 = $this->getStdOfStd('Top2','Bussing2',$prod);
        $stdOfStdBus2Bot =  $this->getStdOfStd('Bottom','Bussing2',$prod);
        $stdOfStdReWTop = $this->getStdOfStd('Top','Rework',$prod);
        $stdOfStdReWBot = $this->getStdOfStd('Bottom','Rework',$prod);

        $medianBus1Top1 = $this->getMedian('Top1','Bussing1',$prod);
        $medianBus1Top2 = $this->getMedian('Top2','Bussing1',$prod);
        $medianBus1Bot = $this->getMedian('Bottom','Bussing1',$prod);
        $medianBus2Top1 = $this->getMedian('Top1','Bussing2',$prod);
        $medianBus2Top2 = $this->getMedian('Top2','Bussing2',$prod);
        $medianBus2Bot =  $this->getMedian('Bottom','Bussing2',$prod);
        $medianReWTop = $this->getMedian('Top','Rework',$prod);
        $medianReWBot = $this->getMedian('Bottom','Rework',$prod);
        
        $perc1Bus1Top1 = $this->getList4percentile('Top1','Bussing1',$prod,0.00135);
        $perc1Bus1Top2 = $this->getList4percentile('Top2','Bussing1',$prod,0.00135);
        $perc1Bus1Bot = $this->getList4percentile('Bottom','Bussing1',$prod,0.00135);
        $perc1Bus2Top1 = $this->getList4percentile('Top1','Bussing2',$prod,0.00135);
        $perc1Bus2Top2 = $this->getList4percentile('Top2','Bussing2',$prod,0.00135);
        $perc1Bus2Bot =  $this->getList4percentile('Bottom','Bussing2',$prod,0.00135);
        $perc1ReWTop = $this->getList4percentile('Top','Rework',$prod,0.00135);
        $perc1ReWBot = $this->getList4percentile('Bottom','Rework',$prod,0.00135);

        $perc2Bus1Top1 = $this->getList4percentile('Top1','Bussing1',$prod,0.99865);
        $perc2Bus1Top2 = $this->getList4percentile('Top2','Bussing1',$prod,0.99865);
        $perc2Bus1Bot = $this->getList4percentile('Bottom','Bussing1',$prod,0.99865);
        $perc2Bus2Top1 = $this->getList4percentile('Top1','Bussing2',$prod,0.99865);
        $perc2Bus2Top2 = $this->getList4percentile('Top2','Bussing2',$prod,0.99865);
        $perc2Bus2Bot =  $this->getList4percentile('Bottom','Bussing2',$prod,0.99865);
        $perc2ReWTop = $this->getList4percentile('Top','Rework',$prod,0.99865);
        $perc2ReWBot = $this->getList4percentile('Bottom','Rework',$prod,0.99865);
        
        $USL = $this->getSpecsULVal($prod,$node,$bbno);
        $LSL = $this->getSpecsLLVal($prod,$node,$bbno);
        $target = $this->getSpecsLimitTarget($prod,$node,$bbno);
        $UCL=15.65;
        $LCL=1.68;


        $CL = (($UCL-$LCL)/2)+$LCL;
        $zBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$CL),$stdOfStdBus1Top1));
        $zBus1Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top2-$CL),$stdOfStdBus1Top2));
        $zBus1Bot = ABS($this->divideByZeroExempt(($aveOfAveBus1Bot - $CL),$stdOfStdBus1Bot));
        $zBus2Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top1-$CL),$stdOfStdBus2Top1));
        $zBus2Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top2 -$CL), $stdOfStdBus2Top2));
        $zBus2Bot = ABS($this->divideByZeroExempt(($aveOfAveBus2Bot -$CL),$stdOfStdBus2Bot));
        $zBusReWBot = ABS($this->divideByZeroExempt(($aveOfAveReWBot -$CL),$stdOfStdReWBot));
        $zBusReWTop = ABS($this->divideByZeroExempt(($aveOfAveReWTop -$CL),$stdOfStdReWTop));

        $CpLBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$LCL),(3*$stdOfStdBus1Top1) ));
        $CpLBus1Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top2-$LCL),(3*$stdOfStdBus1Top2) ));
        $CpLBus1Bot = ABS($this->divideByZeroExempt(($aveOfAveBus1Bot-$LCL),(3*$stdOfStdBus1Bot) ));
        $CpLBus2Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top1-$LCL),(3*$stdOfStdBus2Top1) ));
        $CpLBus2Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top2-$LCL),(3*$stdOfStdBus2Top2) ));
        $CpLBus2Bot = ABS($this->divideByZeroExempt(($aveOfAveBus2Bot-$LCL),(3*$stdOfStdBus2Bot) ));
        $CpLBusReWBot = ABS($this->divideByZeroExempt(($aveOfAveReWBot-$LCL),(3*$stdOfStdReWBot) ));
        $CpLBusReWTop = ABS($this->divideByZeroExempt(($aveOfAveReWTop-$LCL),(3*$stdOfStdReWTop) ));

        $CpUBus1Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top1),(3*$stdOfStdBus1Top1) ));
        $CpUBus1Top2 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top2),(3*$stdOfStdBus1Top2) ));
        $CpUBus1Bot = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Bot),(3*$stdOfStdBus1Bot) ));
        $CpUBus2Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus2Top1),(3*$stdOfStdBus2Top1) ));
        $CpUBus2Top2 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus2Top2),(3*$stdOfStdBus2Top2) ));
        $CpUBus2Bot = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus2Bot),(3*$stdOfStdBus2Bot) ));
        $CpUBusReWBot = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveReWBot),(3*$stdOfStdReWBot) ));
        $CpUBusReWTop = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveReWTop),(3*$stdOfStdReWTop) ));

        $arrValForCpkB1T1 = array( $CpUBus1Top1,$CpLBus1Top1);
        $arrValForCpkB1T2 = array( $CpUBus1Top2,$CpLBus1Top2);
        $arrValForCpkB1B = array( $CpUBus1Bot,$CpLBus1Bot);
        $arrValForCpkB2T1 = array( $CpUBus2Top1,$CpLBus2Top1);
        $arrValForCpkB2T2 = array( $CpUBus2Top2,$CpLBus2Top2);
        $arrValForCpkB2B = array( $CpUBus2Bot,$CpLBus2Bot);
        $arrValForCpkRB = array( $CpUBusReWBot,$CpLBusReWBot);
        $arrValForCpkRT = array( $CpUBusReWTop,$CpLBusReWTop);

        $CpkB1T1 = min($arrValForCpkB1T1);
        $CpkB1T2 = min($arrValForCpkB1T2);
        $CpkB1B = min($arrValForCpkB1B);
        $CpkB2T1 = min($arrValForCpkB2T1);
        $CpkB2T2 = min($arrValForCpkB2T2);
        $CpkB2B = min($arrValForCpkB2B);
        $CpkRB = min($arrValForCpkRB);
        $CpkRT = min($arrValForCpkRT);

        $CpnUB1T1 =$this->divideByZeroExempt(($USL - $medianBus1Top1 ),( $perc2Bus1Top1 - $medianBus1Top1));
        $CpnUB1T2 = $this->divideByZeroExempt(($USL - $medianBus1Top2 ),( $perc2Bus1Top2 - $medianBus1Top2));
        $CpnUB1B = $this->divideByZeroExempt(($USL - $medianBus1Bot ),( $perc2Bus1Bot - $medianBus1Bot));
        $CpnUB2T1 = $this->divideByZeroExempt(($USL - $medianBus2Top1 ),( $perc2Bus2Top1 - $medianBus2Top1));
        $CpnUB2T2 = $this->divideByZeroExempt(($USL - $medianBus2Top2 ),( $perc2Bus2Top2 - $medianBus2Top2));
        $CpnUB2B = $this->divideByZeroExempt(($USL - $medianBus2Bot ),( $perc2Bus2Bot - $medianBus2Bot));
        $CpnURT = $this->divideByZeroExempt(($USL - $medianReWTop ),( $perc2Bus2Top2 - $medianBus2Top2));
        $CpnURB = $this->divideByZeroExempt(($USL - $medianReWBot ),($perc2ReWBot - $medianReWBot));

        $CpnLB1T1 = $this->divideByZeroExempt(($medianBus1Top1  - $LSL),( $medianBus1Top1 -  $perc1Bus1Top1));
        $CpnLB1T2 = $this->divideByZeroExempt(($medianBus1Top2  - $LSL),( $medianBus1Top2 -  $perc1Bus1Top2));
        $CpnLB1B = $this->divideByZeroExempt(($medianBus1Bot  - $LSL),( $medianBus1Bot -  $perc1Bus1Bot));
        $CpnLB2T1 =$this->divideByZeroExempt( ($medianBus2Top1  - $LSL),( $medianBus2Top1 -  $perc1Bus2Top1));
        $CpnLB2T2 =$this->divideByZeroExempt( ($medianBus2Top2  - $LSL),( $medianBus2Top2 -  $perc1Bus2Top2));
        $CpnLB2B = $this->divideByZeroExempt(($medianBus2Bot  - $LSL),( $medianBus2Bot -  $perc1Bus2Bot));
        $CpnLRB = $this->divideByZeroExempt(($medianReWBot  - $LSL),( $medianReWBot -  $perc1ReWBot));
        $CpnLRT =$this->divideByZeroExempt( ($medianReWTop  - $LSL),( $medianReWTop -  $perc1ReWTop));

        $arrValForCpnB1T1 = array( $CpnUB1T1,  $CpnLB1T1);       
        $arrValForCpnB1T2 = array( $CpnUB1T2,  $CpnLB1T2);
        $arrValForCpnB1B = array( $CpnUB1B,  $CpnLB1B);
        $arrValForCpnB2T1 = array( $CpnUB1T1,  $CpnLB2T1);       
        $arrValForCpnB2T2 = array( $CpnUB1T2,  $CpnLB2T2);
        $arrValForCpnB2B = array( $CpnUB1B,  $CpnLB2B);
        $arrValForCpnRB = array( $CpnURB,  $CpnLRB);
        $arrValForCpnRT = array( $CpnURT,  $CpnLRT);

        $CpnB1T1 = min($arrValForCpnB1T1);
        $CpnB1T2 = min($arrValForCpnB1T2);
        $CpnB1B = min($arrValForCpnB1B);
        $CpnB2T1 = min($arrValForCpnB2T1);
        $CpnB2T2 = min($arrValForCpnB2T2);
        $CpnB2B = min($arrValForCpnB2B);
        $CpnRT = min($arrValForCpnRT);
        $CpnRB = min($arrValForCpnRB);

      return view('matrix.matrixpulltest')
      ->with('aveIndB1T1', $aveIndBus1Top1)
      ->with('aveIndB1T2', $aveIndBus1Top2)
      ->with('aveIndB1B', $aveIndBus1Bot)
      ->with('aveIndB2T1', $aveIndBus2Top1)
      ->with('aveIndB2T2', $aveIndBus2Top2)
      ->with('aveIndB2B', $aveIndBus2Bot)
      ->with('aveIndRT', $aveIndReWTop )
      ->with('aveIndRB', $aveIndReWBot)

      ->with('stdIndB1T1', $stdIndBus1Top1)
      ->with('stdIndB1T2', $stdIndBus1Top2)
      ->with('stdIndB1B', $stdIndBus1Bot)
      ->with('stdIndB2T1', $stdIndBus2Top1)
      ->with('stdIndB2T2', $stdIndBus2Top2)
      ->with('stdIndB2B', $stdIndBus2Bot)
      ->with('stdIndRT', $stdIndReWTop )
      ->with('stdIndRB', $stdIndReWBot)
      
      ->with('aveOfAveB1T1', $aveOfAveBus1Top1)
      ->with('aveOfAveB1T2', $aveOfAveBus1Top2)
      ->with('aveOfAveB1B', $aveOfAveBus1Bot)
      ->with('aveOfAveB2T1', $aveOfAveBus2Top1)
      ->with('aveOfAveB2T2', $aveOfAveBus2Top2)
      ->with('aveOfAveB2B', $aveOfAveBus2Bot)
      ->with('aveOfAveRT', $aveOfAveReWTop )
      ->with('aveOfAveRB', $aveOfAveReWBot)

      ->with('stdOfStdB1T1', $stdOfStdBus1Top1)
      ->with('stdOfStdB1T2', $stdOfStdBus1Top2)
      ->with('stdOfStdB1B', $stdOfStdBus1Bot)
      ->with('stdOfStdB2T1', $stdOfStdBus2Top1)
      ->with('stdOfStdB2T2', $stdOfStdBus2Top2)
      ->with('stdOfStdB2B', $stdOfStdBus2Bot)
      ->with('stdOfStdRT', $stdOfStdReWTop )
      ->with('stdOfStdRB', $stdOfStdReWBot)

      ->with('medianB1T1', $medianBus1Top1)
      ->with('medianB1T2', $medianBus1Top2)
      ->with('medianB1B', $medianBus1Bot)
      ->with('medianB2T1', $medianBus2Top1)
      ->with('medianB2T2', $medianBus2Top2)
      ->with('medianB2B', $medianBus2Bot)
      ->with('medianRT', $medianReWTop )
      ->with('medianRB', $medianReWBot)

      ->with('perc1B1T1', $perc1Bus1Top1)
      ->with('perc1B1T2', $perc1Bus1Top2)
      ->with('perc1B1B', $perc1Bus1Bot)
      ->with('perc1B2T1', $perc1Bus2Top1)
      ->with('perc1B2T2', $perc1Bus2Top2)
      ->with('perc1B2B', $perc1Bus2Bot)
      ->with('perc1RT', $perc1ReWTop )
      ->with('perc1RB', $perc1ReWBot)

      ->with('perc2B1T1', $perc2Bus1Top1)
      ->with('perc2B1T2', $perc2Bus1Top2)
      ->with('perc2B1B', $perc2Bus1Bot)
      ->with('perc2B2T1', $perc2Bus2Top1)
      ->with('perc2B2T2', $perc2Bus2Top2)
      ->with('perc2B2B', $perc2Bus2Bot)
      ->with('perc2RT', $perc2ReWTop )
      ->with('perc2RB', $perc2ReWBot)
      ->with('dateRange',$this->getDateRangeForSPC())
      ->with('productBuilt',$prod)

      ->with('USL',$USL)
      ->with('LSL',$LSL)
      ->with('UCL',$UCL)
      ->with('LCL',$LCL)
      ->with('CL',$CL)
      ->with('target',$target)

      ->with('zBus1Top1',$zBus1Top1)
      ->with('zBus1Top2',$zBus1Top2)
      ->with('zBus1Bot',$zBus1Bot)
      ->with('zBus2Top1',$zBus2Top1)
      ->with('zBus2Top2',$zBus2Top2)
      ->with('zBus2Bot',$zBus2Bot)
      ->with('zRB',$zBusReWBot)
      ->with('zRT',$zBusReWTop)

      ->with('CpUB1T1',$CpUBus1Top1)
      ->with('CpUB1T2',$CpUBus1Top2)
      ->with('CpUB1B',$CpUBus1Bot)
      ->with('CpUB2T1',$CpUBus2Top1)
      ->with('CpUB2T2',$CpUBus2Top2)
      ->with('CpUB2B',$CpUBus2Bot)
      ->with('CpURB',$CpUBusReWBot)
      ->with('CpURT',$CpUBusReWTop)

      ->with('CpLB1T1',$CpLBus1Top1)
      ->with('CpLB1T2',$CpLBus1Top2)
      ->with('CpLB1B',$CpLBus1Bot)
      ->with('CpLB2T1',$CpLBus2Top1)
      ->with('CpLB2T2',$CpLBus2Top2)
      ->with('CpLB2B',$CpLBus2Bot)
      ->with('CpLRB',$CpLBusReWBot)
      ->with('CpLRT',$CpLBusReWTop)

      ->with('CpkB1T1',$CpkB1T1)
      ->with('CpkB1T2',$CpkB1T2)
      ->with('CpkB1B',$CpkB1B)
      ->with('CpkB2T1',$CpkB2T1)
      ->with('CpkB2T2',$CpkB2T2)
      ->with('CpkB2B',$CpkB2B)
      ->with('CpkRB',$CpkRB)
      ->with('CpkRT',$CpkRT)

      ->with('CpnB1T1',$CpnB1T1)
      ->with('CpnB1T2',$CpnB1T2)
      ->with('CpnB1B',$CpnB1B)
      ->with('CpnB2T1',$CpnB2T1)
      ->with('CpnB2T2',$CpnB2T2)
      ->with('CpnB2B',$CpnB2B)
      ->with('CpnRB',$CpnRB)
      ->with('CpnRT',$CpnRT)

      ->with('CpnUB1T1',$CpnUB1T1)
      ->with('CpnUB1T2',$CpnUB1T2)
      ->with('CpnUB1B',$CpnUB1B)
      ->with('CpnUB2T1',$CpnUB2T1)
      ->with('CpnUB2T2',$CpnUB2T2)
      ->with('CpnUB2B',$CpnUB2B)
      ->with('CpnURB',$CpnURB)
      ->with('CpnURT',$CpnURT)

      ->with('CpnLB1T1',$CpnLB1T1)
      ->with('CpnLB1T2',$CpnLB1T2)
      ->with('CpnLB1B',$CpnLB1B)
      ->with('CpnLB2T1',$CpnLB2T1)
      ->with('CpnLB2T2',$CpnLB2T2)
      ->with('CpnLB2B',$CpnLB2B)
      ->with('CpnLRB',$CpnLRB)
      ->with('CpnLRT',$CpnLRT);
 
        
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
              
        if($request->input('prodSel')!=''){
            $prod =  $request->input('prodSel');
            $node="Ribbon-to-BB Pull Strength";
            $getLastProd = DB::select("SELECT * FROM parameters JOIN producttype ON parameters.BOMType = producttype.bomType JOIN subprocess ON parameters.subProcessName = subprocess.subProcessName WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."'"); 
                      
        if(count($getLastProd) > 0)
        {
            foreach($getLastProd as $field)   
            {
               
             $bom = $field->bomType;
             $bbno = $field->BBno;
            }

        }else{
            $prod = "Not Set";
        }

        
       
                
                  
                 
        $node="Ribbon-to-BB Pull Strength";
        $aveIndBus1Top1 = $this->getAveInd('Top1','Bussing1',$prod);
        $aveIndBus1Top2 = $this->getAveInd('Top2','Bussing1',$prod);
        $aveIndBus1Bot = $this->getAveInd('Bottom','Bussing1',$prod);
        $aveIndBus2Top1 = $this->getAveInd('Top1','Bussing2',$prod);
        $aveIndBus2Top2 = $this->getAveInd('Top2','Bussing2',$prod);
        $aveIndBus2Bot =  $this->getAveInd('Bottom','Bussing2',$prod);
        $aveIndReWTop = $this->getAveInd('Top','Rework',$prod);
        $aveIndReWBot = $this->getAveInd('Bottom','Rework',$prod);

        $stdIndBus1Top1 = $this->getStdInd('Top1','Bussing1',$prod);
        $stdIndBus1Top2 = $this->getStdInd('Top2','Bussing1',$prod);
        $stdIndBus1Bot = $this->getStdInd('Bottom','Bussing1',$prod);
        $stdIndBus2Top1 = $this->getStdInd('Top1','Bussing2',$prod);
        $stdIndBus2Top2 = $this->getStdInd('Top2','Bussing2',$prod);
        $stdIndBus2Bot =  $this->getStdInd('Bottom','Bussing2',$prod);
        $stdIndReWTop = $this->getStdInd('Top','Rework',$prod);
        $stdIndReWBot = $this->getStdInd('Bottom','Rework',$prod);

        $aveOfAveBus1Top1 = $this->getAveOfAve('Top1','Bussing1',$prod);
        $aveOfAveBus1Top2 = $this->getAveOfAve('Top2','Bussing1',$prod);
        $aveOfAveBus1Bot = $this->getAveOfAve('Bottom','Bussing1',$prod);
        $aveOfAveBus2Top1 = $this->getAveOfAve('Top1','Bussing2',$prod);
        $aveOfAveBus2Top2 = $this->getAveOfAve('Top2','Bussing2',$prod);
        $aveOfAveBus2Bot =  $this->getAveOfAve('Bottom','Bussing2',$prod);
        $aveOfAveReWTop = $this->getAveOfAve('Top','Rework',$prod);
        $aveOfAveReWBot = $this->getAveOfAve('Bottom','Rework',$prod);

        $stdOfStdBus1Top1 = $this->getStdOfStd('Top1','Bussing1',$prod);
        $stdOfStdBus1Top2 = $this->getStdOfStd('Top2','Bussing1',$prod);
        $stdOfStdBus1Bot = $this->getStdOfStd('Bottom','Bussing1',$prod);
        $stdOfStdBus2Top1 = $this->getStdOfStd('Top1','Bussing2',$prod);
        $stdOfStdBus2Top2 = $this->getStdOfStd('Top2','Bussing2',$prod);
        $stdOfStdBus2Bot =  $this->getStdOfStd('Bottom','Bussing2',$prod);
        $stdOfStdReWTop = $this->getStdOfStd('Top','Rework',$prod);
        $stdOfStdReWBot = $this->getStdOfStd('Bottom','Rework',$prod);

        $medianBus1Top1 = $this->getMedian('Top1','Bussing1',$prod);
        $medianBus1Top2 = $this->getMedian('Top2','Bussing1',$prod);
        $medianBus1Bot = $this->getMedian('Bottom','Bussing1',$prod);
        $medianBus2Top1 = $this->getMedian('Top1','Bussing2',$prod);
        $medianBus2Top2 = $this->getMedian('Top2','Bussing2',$prod);
        $medianBus2Bot =  $this->getMedian('Bottom','Bussing2',$prod);
        $medianReWTop = $this->getMedian('Top','Rework',$prod);
        $medianReWBot = $this->getMedian('Bottom','Rework',$prod);
        
        $perc1Bus1Top1 = $this->getList4percentile('Top1','Bussing1',$prod,0.00135);
        $perc1Bus1Top2 = $this->getList4percentile('Top2','Bussing1',$prod,0.00135);
        $perc1Bus1Bot = $this->getList4percentile('Bottom','Bussing1',$prod,0.00135);
        $perc1Bus2Top1 = $this->getList4percentile('Top1','Bussing2',$prod,0.00135);
        $perc1Bus2Top2 = $this->getList4percentile('Top2','Bussing2',$prod,0.00135);
        $perc1Bus2Bot =  $this->getList4percentile('Bottom','Bussing2',$prod,0.00135);
        $perc1ReWTop = $this->getList4percentile('Top','Rework',$prod,0.00135);
        $perc1ReWBot = $this->getList4percentile('Bottom','Rework',$prod,0.00135);

        $perc2Bus1Top1 = $this->getList4percentile('Top1','Bussing1',$prod,0.99865);
        $perc2Bus1Top2 = $this->getList4percentile('Top2','Bussing1',$prod,0.99865);
        $perc2Bus1Bot = $this->getList4percentile('Bottom','Bussing1',$prod,0.99865);
        $perc2Bus2Top1 = $this->getList4percentile('Top1','Bussing2',$prod,0.99865);
        $perc2Bus2Top2 = $this->getList4percentile('Top2','Bussing2',$prod,0.99865);
        $perc2Bus2Bot =  $this->getList4percentile('Bottom','Bussing2',$prod,0.99865);
        $perc2ReWTop = $this->getList4percentile('Top','Rework',$prod,0.99865);
        $perc2ReWBot = $this->getList4percentile('Bottom','Rework',$prod,0.99865);
        
        $USL = $this->getSpecsULVal($prod,$node,$bbno);
        $LSL = $this->getSpecsLLVal($prod,$node,$bbno);
        $target = $this->getSpecsLimitTarget($prod,$node,$bbno);
        $UCL=15.65;
        $LCL=1.68;


        $CL = (($UCL-$LCL)/2)+$LCL;
        $zBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$CL),$stdOfStdBus1Top1));
        $zBus1Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top2-$CL),$stdOfStdBus1Top2));
        $zBus1Bot = ABS($this->divideByZeroExempt(($aveOfAveBus1Bot - $CL),$stdOfStdBus1Bot));
        $zBus2Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top1-$CL),$stdOfStdBus2Top1));
        $zBus2Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top2 -$CL), $stdOfStdBus2Top2));
        $zBus2Bot = ABS($this->divideByZeroExempt(($aveOfAveBus2Bot -$CL),$stdOfStdBus2Bot));
        $zBusReWBot = ABS($this->divideByZeroExempt(($aveOfAveReWBot -$CL),$stdOfStdReWBot));
        $zBusReWTop = ABS($this->divideByZeroExempt(($aveOfAveReWTop -$CL),$stdOfStdReWTop));

        $CpLBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$LCL),(3*$stdOfStdBus1Top1) ));
        $CpLBus1Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top2-$LCL),(3*$stdOfStdBus1Top2) ));
        $CpLBus1Bot = ABS($this->divideByZeroExempt(($aveOfAveBus1Bot-$LCL),(3*$stdOfStdBus1Bot) ));
        $CpLBus2Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top1-$LCL),(3*$stdOfStdBus2Top1) ));
        $CpLBus2Top2 = ABS($this->divideByZeroExempt(($aveOfAveBus2Top2-$LCL),(3*$stdOfStdBus2Top2) ));
        $CpLBus2Bot = ABS($this->divideByZeroExempt(($aveOfAveBus2Bot-$LCL),(3*$stdOfStdBus2Bot) ));
        $CpLBusReWBot = ABS($this->divideByZeroExempt(($aveOfAveReWBot-$LCL),(3*$stdOfStdReWBot) ));
        $CpLBusReWTop = ABS($this->divideByZeroExempt(($aveOfAveReWTop-$LCL),(3*$stdOfStdReWTop) ));

        $CpUBus1Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top1),(3*$stdOfStdBus1Top1) ));
        $CpUBus1Top2 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top2),(3*$stdOfStdBus1Top2) ));
        $CpUBus1Bot = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Bot),(3*$stdOfStdBus1Bot) ));
        $CpUBus2Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus2Top1),(3*$stdOfStdBus2Top1) ));
        $CpUBus2Top2 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus2Top2),(3*$stdOfStdBus2Top2) ));
        $CpUBus2Bot = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus2Bot),(3*$stdOfStdBus2Bot) ));
        $CpUBusReWBot = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveReWBot),(3*$stdOfStdReWBot) ));
        $CpUBusReWTop = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveReWTop),(3*$stdOfStdReWTop) ));

        $arrValForCpkB1T1 = array( $CpUBus1Top1,$CpLBus1Top1);
        $arrValForCpkB1T2 = array( $CpUBus1Top2,$CpLBus1Top2);
        $arrValForCpkB1B = array( $CpUBus1Bot,$CpLBus1Bot);
        $arrValForCpkB2T1 = array( $CpUBus2Top1,$CpLBus2Top1);
        $arrValForCpkB2T2 = array( $CpUBus2Top2,$CpLBus2Top2);
        $arrValForCpkB2B = array( $CpUBus2Bot,$CpLBus2Bot);
        $arrValForCpkRB = array( $CpUBusReWBot,$CpLBusReWBot);
        $arrValForCpkRT = array( $CpUBusReWTop,$CpLBusReWTop);

        $CpkB1T1 = min($arrValForCpkB1T1);
        $CpkB1T2 = min($arrValForCpkB1T2);
        $CpkB1B = min($arrValForCpkB1B);
        $CpkB2T1 = min($arrValForCpkB2T1);
        $CpkB2T2 = min($arrValForCpkB2T2);
        $CpkB2B = min($arrValForCpkB2B);
        $CpkRB = min($arrValForCpkRB);
        $CpkRT = min($arrValForCpkRT);

        $CpnUB1T1 =$this->divideByZeroExempt(($USL - $medianBus1Top1 ),( $perc2Bus1Top1 - $medianBus1Top1));
        $CpnUB1T2 = $this->divideByZeroExempt(($USL - $medianBus1Top2 ),( $perc2Bus1Top2 - $medianBus1Top2));
        $CpnUB1B = $this->divideByZeroExempt(($USL - $medianBus1Bot ),( $perc2Bus1Bot - $medianBus1Bot));
        $CpnUB2T1 = $this->divideByZeroExempt(($USL - $medianBus2Top1 ),( $perc2Bus2Top1 - $medianBus2Top1));
        $CpnUB2T2 = $this->divideByZeroExempt(($USL - $medianBus2Top2 ),( $perc2Bus2Top2 - $medianBus2Top2));
        $CpnUB2B = $this->divideByZeroExempt(($USL - $medianBus2Bot ),( $perc2Bus2Bot - $medianBus2Bot));
        $CpnURT = $this->divideByZeroExempt(($USL - $medianReWTop ),( $perc2Bus2Top2 - $medianBus2Top2));
        $CpnURB = $this->divideByZeroExempt(($USL - $medianReWBot ),($perc2ReWBot - $medianReWBot));

        $CpnLB1T1 = $this->divideByZeroExempt(($medianBus1Top1  - $LSL),( $medianBus1Top1 -  $perc1Bus1Top1));
        $CpnLB1T2 = $this->divideByZeroExempt(($medianBus1Top2  - $LSL),( $medianBus1Top2 -  $perc1Bus1Top2));
        $CpnLB1B = $this->divideByZeroExempt(($medianBus1Bot  - $LSL),( $medianBus1Bot -  $perc1Bus1Bot));
        $CpnLB2T1 =$this->divideByZeroExempt( ($medianBus2Top1  - $LSL),( $medianBus2Top1 -  $perc1Bus2Top1));
        $CpnLB2T2 =$this->divideByZeroExempt( ($medianBus2Top2  - $LSL),( $medianBus2Top2 -  $perc1Bus2Top2));
        $CpnLB2B = $this->divideByZeroExempt(($medianBus2Bot  - $LSL),( $medianBus2Bot -  $perc1Bus2Bot));
        $CpnLRB = $this->divideByZeroExempt(($medianReWBot  - $LSL),( $medianReWBot -  $perc1ReWBot));
        $CpnLRT =$this->divideByZeroExempt( ($medianReWTop  - $LSL),( $medianReWTop -  $perc1ReWTop));

        $arrValForCpnB1T1 = array( $CpnUB1T1,  $CpnLB1T1);       
        $arrValForCpnB1T2 = array( $CpnUB1T2,  $CpnLB1T2);
        $arrValForCpnB1B = array( $CpnUB1B,  $CpnLB1B);
        $arrValForCpnB2T1 = array( $CpnUB1T1,  $CpnLB2T1);       
        $arrValForCpnB2T2 = array( $CpnUB1T2,  $CpnLB2T2);
        $arrValForCpnB2B = array( $CpnUB1B,  $CpnLB2B);
        $arrValForCpnRB = array( $CpnURB,  $CpnLRB);
        $arrValForCpnRT = array( $CpnURT,  $CpnLRT);

        $CpnB1T1 = min($arrValForCpnB1T1);
        $CpnB1T2 = min($arrValForCpnB1T2);
        $CpnB1B = min($arrValForCpnB1B);
        $CpnB2T1 = min($arrValForCpnB2T1);
        $CpnB2T2 = min($arrValForCpnB2T2);
        $CpnB2B = min($arrValForCpnB2B);
        $CpnRT = min($arrValForCpnRT);
        $CpnRB = min($arrValForCpnRB);

      return view('matrix.matrixpulltest')
      ->with('aveIndB1T1', $aveIndBus1Top1)
      ->with('aveIndB1T2', $aveIndBus1Top2)
      ->with('aveIndB1B', $aveIndBus1Bot)
      ->with('aveIndB2T1', $aveIndBus2Top1)
      ->with('aveIndB2T2', $aveIndBus2Top2)
      ->with('aveIndB2B', $aveIndBus2Bot)
      ->with('aveIndRT', $aveIndReWTop )
      ->with('aveIndRB', $aveIndReWBot)

      ->with('stdIndB1T1', $stdIndBus1Top1)
      ->with('stdIndB1T2', $stdIndBus1Top2)
      ->with('stdIndB1B', $stdIndBus1Bot)
      ->with('stdIndB2T1', $stdIndBus2Top1)
      ->with('stdIndB2T2', $stdIndBus2Top2)
      ->with('stdIndB2B', $stdIndBus2Bot)
      ->with('stdIndRT', $stdIndReWTop )
      ->with('stdIndRB', $stdIndReWBot)
      
      ->with('aveOfAveB1T1', $aveOfAveBus1Top1)
      ->with('aveOfAveB1T2', $aveOfAveBus1Top2)
      ->with('aveOfAveB1B', $aveOfAveBus1Bot)
      ->with('aveOfAveB2T1', $aveOfAveBus2Top1)
      ->with('aveOfAveB2T2', $aveOfAveBus2Top2)
      ->with('aveOfAveB2B', $aveOfAveBus2Bot)
      ->with('aveOfAveRT', $aveOfAveReWTop )
      ->with('aveOfAveRB', $aveOfAveReWBot)

      ->with('stdOfStdB1T1', $stdOfStdBus1Top1)
      ->with('stdOfStdB1T2', $stdOfStdBus1Top2)
      ->with('stdOfStdB1B', $stdOfStdBus1Bot)
      ->with('stdOfStdB2T1', $stdOfStdBus2Top1)
      ->with('stdOfStdB2T2', $stdOfStdBus2Top2)
      ->with('stdOfStdB2B', $stdOfStdBus2Bot)
      ->with('stdOfStdRT', $stdOfStdReWTop )
      ->with('stdOfStdRB', $stdOfStdReWBot)

      ->with('medianB1T1', $medianBus1Top1)
      ->with('medianB1T2', $medianBus1Top2)
      ->with('medianB1B', $medianBus1Bot)
      ->with('medianB2T1', $medianBus2Top1)
      ->with('medianB2T2', $medianBus2Top2)
      ->with('medianB2B', $medianBus2Bot)
      ->with('medianRT', $medianReWTop )
      ->with('medianRB', $medianReWBot)

      ->with('perc1B1T1', $perc1Bus1Top1)
      ->with('perc1B1T2', $perc1Bus1Top2)
      ->with('perc1B1B', $perc1Bus1Bot)
      ->with('perc1B2T1', $perc1Bus2Top1)
      ->with('perc1B2T2', $perc1Bus2Top2)
      ->with('perc1B2B', $perc1Bus2Bot)
      ->with('perc1RT', $perc1ReWTop )
      ->with('perc1RB', $perc1ReWBot)

      ->with('perc2B1T1', $perc2Bus1Top1)
      ->with('perc2B1T2', $perc2Bus1Top2)
      ->with('perc2B1B', $perc2Bus1Bot)
      ->with('perc2B2T1', $perc2Bus2Top1)
      ->with('perc2B2T2', $perc2Bus2Top2)
      ->with('perc2B2B', $perc2Bus2Bot)
      ->with('perc2RT', $perc2ReWTop )
      ->with('perc2RB', $perc2ReWBot)
      ->with('dateRange',$this->getDateRangeForSPC())
      ->with('productBuilt',$prod)

      ->with('USL',$USL)
      ->with('LSL',$LSL)
      ->with('UCL',$UCL)
      ->with('LCL',$LCL)
      ->with('CL',$CL)
      ->with('target',$target)

      ->with('zBus1Top1',$zBus1Top1)
      ->with('zBus1Top2',$zBus1Top2)
      ->with('zBus1Bot',$zBus1Bot)
      ->with('zBus2Top1',$zBus2Top1)
      ->with('zBus2Top2',$zBus2Top2)
      ->with('zBus2Bot',$zBus2Bot)
      ->with('zRB',$zBusReWBot)
      ->with('zRT',$zBusReWTop)

      ->with('CpUB1T1',$CpUBus1Top1)
      ->with('CpUB1T2',$CpUBus1Top2)
      ->with('CpUB1B',$CpUBus1Bot)
      ->with('CpUB2T1',$CpUBus2Top1)
      ->with('CpUB2T2',$CpUBus2Top2)
      ->with('CpUB2B',$CpUBus2Bot)
      ->with('CpURB',$CpUBusReWBot)
      ->with('CpURT',$CpUBusReWTop)

      ->with('CpLB1T1',$CpLBus1Top1)
      ->with('CpLB1T2',$CpLBus1Top2)
      ->with('CpLB1B',$CpLBus1Bot)
      ->with('CpLB2T1',$CpLBus2Top1)
      ->with('CpLB2T2',$CpLBus2Top2)
      ->with('CpLB2B',$CpLBus2Bot)
      ->with('CpLRB',$CpLBusReWBot)
      ->with('CpLRT',$CpLBusReWTop)

      ->with('CpkB1T1',$CpkB1T1)
      ->with('CpkB1T2',$CpkB1T2)
      ->with('CpkB1B',$CpkB1B)
      ->with('CpkB2T1',$CpkB2T1)
      ->with('CpkB2T2',$CpkB2T2)
      ->with('CpkB2B',$CpkB2B)
      ->with('CpkRB',$CpkRB)
      ->with('CpkRT',$CpkRT)

      ->with('CpnB1T1',$CpnB1T1)
      ->with('CpnB1T2',$CpnB1T2)
      ->with('CpnB1B',$CpnB1B)
      ->with('CpnB2T1',$CpnB2T1)
      ->with('CpnB2T2',$CpnB2T2)
      ->with('CpnB2B',$CpnB2B)
      ->with('CpnRB',$CpnRB)
      ->with('CpnRT',$CpnRT)

      ->with('CpnUB1T1',$CpnUB1T1)
      ->with('CpnUB1T2',$CpnUB1T2)
      ->with('CpnUB1B',$CpnUB1B)
      ->with('CpnUB2T1',$CpnUB2T1)
      ->with('CpnUB2T2',$CpnUB2T2)
      ->with('CpnUB2B',$CpnUB2B)
      ->with('CpnURB',$CpnURB)
      ->with('CpnURT',$CpnURT)

      ->with('CpnLB1T1',$CpnLB1T1)
      ->with('CpnLB1T2',$CpnLB1T2)
      ->with('CpnLB1B',$CpnLB1B)
      ->with('CpnLB2T1',$CpnLB2T1)
      ->with('CpnLB2T2',$CpnLB2T2)
      ->with('CpnLB2B',$CpnLB2B)
      ->with('CpnLRB',$CpnLRB)
      ->with('CpnLRT',$CpnLRT);
 
        

        }


           if( $request->input('process')=='Rework'){
            $this->validate($request,[   
                'botpulltest1' => 'required',
                'botpulltest2' => 'required',
                'botpulltest3' => 'required',
                'botaverage' => 'required',
                'remarks' => 'required',
                'employeeid' => 'required|numeric',
                'prodBuilt' => 'required',
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required'
             
            ]);

           
    
            
           
$EmployeeID = $request->input('employeeid');
$process = $request->input('process');
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
$prodBuilt = $request->input('prodBuilt');
$botSite1 = $request->input('botpulltest1');
$botSite2 = $request->input('botpulltest2');
$botSite3 = $request->input('botpulltest3');
$botAverage =  $request->input('botaverage');
$topSite1 = $request->input('toppulltest1');
$topSite2 = $request->input('toppulltest2');
$topSite3 = $request->input('toppulltest3');
$topAverage =  $request->input('topaverage');
$Remarks = $request->input('remarks');
$loc1="Bottom";
$loc2="Top";

$post = new MatrixPullTest;
$post->employeeid = $EmployeeID;
$post->process = $process;
$post->Location = $loc1;
$post->shift = $Shift;
$post->node = $Node;
$post->supplier = $Supplier;
$post->productBuilt = $prodBuilt;
$post->site1 = $botSite1;
$post->site2 = $botSite2;
$post->site3 = $botSite3;
$post->average = $botAverage;
$post->remarks = $Remarks;
$post->date = $request->input('fixture_date');
$post->save ();

$post1 = new MatrixPullTest;
$post1->employeeid = $EmployeeID;
$post1->process = $process;
$post1->Location = $loc2;
$post1->shift = $Shift;
$post1->node = $Node;
$post1->supplier = $Supplier;
$post1->productBuilt = $prodBuilt;
$post1->site1 = $topSite1;
$post1->site2 = $topSite2;
$post1->site3 = $topSite3;
$post1->average = $topAverage;
$post1->remarks = $Remarks;
$post1->date = $request->input('fixture_date');
$post1->save ();
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
                'remarks' => 'required',
                'prodBuilt' => 'required',
                'buspulltest1' => 'required',
                'buspulltest2' => 'required',
                'buspulltest3' => 'required',
                'busaverage' => 'required'
            ]);

            $EmployeeID = $request->input('employeeid');
            $process = $request->input('process');
            $Shift = $request->input('shift');
            $Node = $request->input('node');
            $Supplier = $request->input('supplier');
            $prodBuilt = $request->input('prodBuilt');
            $Site1 = $request->input('pulltest1');
            $Site2 = $request->input('pulltest2');
            $Site3 = $request->input('pulltest3');
            $bAverage = $request->input('average');
            $twoSite1 = $request->input('twopulltest1');
            $twoSite2 = $request->input('twopulltest2');
            $twoSite3 = $request->input('twopulltest3');
            $twoAverage = $request->input('twoAverage');
            $busSite1 = $request->input('buspulltest1');
            $busSite2 = $request->input('buspulltest2');
            $busSite3 = $request->input('buspulltest3');
            $busAverage = $request->input('busaverage');
            $botSite1 = 0;
            $botSite2 = 0;
            $botSite3 = 0;
            $botAverage = 0;
            $topSite1 = 0;
            $topSite2 = 0;
            $topSite3 = 0;
            $topAverage =  0;
            $Remarks = $request->input('remarks');
            $loc1="Top1";
            $loc2="Top2";


            
$post = new MatrixPullTest;
$post->employeeid = $EmployeeID;
$post->process = $process;
$post->Location = $loc1;
$post->shift = $Shift;
$post->node = $Node;
$post->supplier = $Supplier;
$post->productBuilt = $prodBuilt;
$post->site1 = $Site1;
$post->site2 = $Site2;
$post->site3 = $Site3;
$post->average = $bAverage;
$post->remarks = $Remarks;
$post->date = $request->input('fixture_date');
$post->save ();

$post1 = new MatrixPullTest;
$post1->employeeid = $EmployeeID;
$post1->process = $process;
$post1->Location = "Bottom";
$post1->shift = $Shift;
$post1->node = $Node;
$post1->supplier = $Supplier;
$post1->productBuilt = $prodBuilt;
$post1->site1 = $busSite1;
$post1->site2 = $busSite2;
$post1->site3 = $busSite3;
$post1->average = $busAverage;
$post1->remarks = $Remarks;
$post1->date = $request->input('fixture_date');
$post1->save ();

$post2 = new MatrixPullTest;
$post2->employeeid = $EmployeeID;
$post2->process = $process;
$post2->Location = $loc2;
$post2->shift = $Shift;
$post2->node = $Node;
$post2->supplier = $Supplier;
$post2->productBuilt = $prodBuilt;
$post2->site1 = $twoSite1;
$post2->site2 = $twoSite2;
$post2->site3 = $twoSite3;
$post2->average = $twoAverage;
$post2->remarks = $Remarks;
$post2->date = $request->input('fixture_date');
$post2->save ();

return redirect('/rtobpulltest')->with('success', 'Record successfully added.');

                
           }
           

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

    public function getAveInd($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->aveWt,6);
        return $wtAve;
    }
    public function getStdInd($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(average) as StdWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->StdWt,6);
        return $wtAve;
    }
    public function getAveOfAve($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        return $wtAve;
    }
    public function getStdOfStd($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
        return $wtAve;
    }
    public function getMedian($location,$process,$product)
    {
        $median = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));

        $medianCountVal = $medianCount->from[0]->aveCount;

        if($medianCountVal == 0){
            return 0;
        }else{
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


    }

    public function getDateRangeForSPC()
    {
        $median = DB::table(DB::select("SELECT * FROM view_rtobpulltest"));
        $medianCount = DB::table(DB::select("SELECT COUNT(date) as aveCount FROM view_rtobpulltest "));

        $medianCountVal = $medianCount->from[0]->aveCount;
       
        if($medianCountVal == 0){
            return "no data.";
        }else{
            $enddate = $median->from[0]->date ;
            $startdate = $median->from[$medianCountVal-1]->date ;
            return $startdate."  to  ".$enddate;
        }
       
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
    public function getList4percentile($location,$process,$product,$percentdec){
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
        $wtAveList = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM rtobpulltest WHERE date IN (SELECT * FROM view_rtobpulltest) AND Location='".$location."' AND process ='".$process."' AND productBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        $medianCountValue = $medianCount->from[0]->aveCount;
        //dd($median);


        if( $medianCountValue !=0  ){
            $arrAve = array();
        
            $arrVal= "";
            for($i=0;$i<$medianCountValue ;$i++){
              //  $arrVal= $arrVal.$wtAveList->from[$i]->aveWt.',';
                array_push($arrAve,$wtAveList->from[$i]->aveWt);
            }
    
            $percentile = $this->mypercentile($arrAve,$percentdec);
            return $percentile;
          
        }else{
            return 0 ;
        }
       
     }

     public function divideByZeroExempt($val1,$val2){

        if($val2  == 0){
          return strval($val1). "/".strval($val2);
        }else if($val2  == 0 && $val21 == 0 ){
            return strval($val1). "/".strval($val2);
        }else {
          return number_format(($val1)/($val2),4);
         // return 0;
        }
     }




     public function getSpecsLimitTarget($prod,$node,$bbnum)
     {
         
         $medianCount = DB::table(DB::select("SELECT * FROM parameters JOIN producttype ON parameters.BOMType = producttype.bomType JOIN subprocess ON parameters.subProcessName = subprocess.subProcessName WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."' AND parameters.BBno = '".$bbnum."'"));
         $medianCount2 = DB::table(DB::select("SELECT count(targetVal) as tarval FROM parameters JOIN producttype ON parameters.BOMType = producttype.bomType JOIN subprocess ON parameters.subProcessName = subprocess.subProcessName WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."' AND parameters.BBno = '".$bbnum."'"));
         $ctr=$medianCount2->from[0]->tarval;
         if( $ctr >  0){
             $target = $medianCount->from[0]->targetVal;
             return $target;
            
         }else{
             return 0;
         }
       
         }

         
     public function getSpecsLLVal($prod,$node,$bbnum)
     {
         
        $medianCount = DB::table(DB::select("SELECT * FROM parameters INNER JOIN producttype ON parameters.BOMType = producttype.bomType WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."'  AND parameters.BBno = '".$bbnum."'"));
        $medianCount2 = DB::table(DB::select("SELECT COUNT(targetVal) as tarval FROM parameters INNER JOIN producttype ON parameters.BOMType = producttype.bomType WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."'  AND parameters.BBno = '".$bbnum."'"));
         $ctr=$medianCount2->from[0]->tarval;
         if( $ctr >  0){
             $target = $medianCount->from[0]->LLVal;
             return $target;
            
         }else{
             return 0;
         }
       
         }

         public function getSpecsULVal($prod,$node,$bbnum)
         {
            $medianCount = DB::table(DB::select("SELECT * FROM parameters INNER JOIN producttype ON parameters.BOMType = producttype.bomType WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."'  AND parameters.BBno = '".$bbnum."'"));
                 $medianCount2 = DB::table(DB::select("SELECT COUNT(targetVal) as tarval FROM parameters INNER JOIN producttype ON parameters.BOMType = producttype.bomType WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."'  AND parameters.BBno = '".$bbnum."'"));
             $ctr=$medianCount2->from[0]->tarval;
             if( $ctr >  0){
                 $target = $medianCount->from[0]->ULVal;
                 return $target;
                
             }else{
                 return 0;
             }
           
             }

            
}
