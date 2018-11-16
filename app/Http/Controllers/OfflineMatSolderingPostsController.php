<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\OfflineMatSolderingPost;


class OfflineMatSolderingPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $getLastProd = DB::select("SELECT * FROM prodselect JOIN producttype ON prodselect.productName = producttype.prodName WHERE ProcessName ='Material Preparation' ORDER BY prodselect.created_at DESC LIMIT 1"); 
                      
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
    
        $node1 = "Soldering Temperature MatPrep";
       // $prod = "Gintech";
        $location ="Busbar Prep";
        $node = "Soldering Temp";
        $aveIndBus1Top1 = $this->getAveInd($location,$node,$prod);
        $stdIndBus1Top1 = $this->getStdInd($location,$node,$prod);      
        $aveOfAveBus1Top1 = $this->getAveOfAve($location,$node,$prod);      
        $stdOfStdBus1Top1 = $this->getStdOfStd($location,$node,$prod);
        $medianBus1Top1 = $this->getMedian($location,$node,$prod);          
        $perc1Bus1Top1 = $this->getList4percentile($location,$node,$prod,0.00135);     
        $perc2Bus1Top1 = $this->getList4percentile($location,$node,$prod,0.99865);
       
       /* $USL = 360;
        $LSL = 340;
        $target = 350;
        $UCL=0;
        $LCL=0; */

         
        $USL = $this->getSpecsULVal($prod,$node1,$bbno);
        $LSL = $this->getSpecsLLVal($prod,$node1,$bbno);
        $target = $this->getSpecsLimitTarget($prod,$node1,$bbno);
        $UCL=0;
        $LCL=0;

        $CL = (($UCL-$LCL)/2)+$LCL;
        $zBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$CL),$stdOfStdBus1Top1));
        $CpLBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$LCL),(3*$stdOfStdBus1Top1) ));
        $CpUBus1Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top1),(3*$stdOfStdBus1Top1) ));      
        $arrValForCpkB1T1 = array( $CpUBus1Top1,$CpLBus1Top1);  
        $CpkB1T1 = min($arrValForCpkB1T1);
        $CpnUB1T1 =$this->divideByZeroExempt(($USL - $medianBus1Top1 ),( $perc2Bus1Top1 - $medianBus1Top1));
        $CpnLB1T1 = $this->divideByZeroExempt(($medianBus1Top1  - $LSL),( $medianBus1Top1 -  $perc1Bus1Top1));
        $arrValForCpnB1T1 = array( $CpnUB1T1,  $CpnLB1T1);         
        $CpnB1T1 = min($arrValForCpnB1T1);
        
        return view('matrix.offlinematsolderingtemp')
        ->with('aveIndB1T1', $aveIndBus1Top1)
      ->with('stdIndB1T1', $stdIndBus1Top1)         
      ->with('aveOfAveB1T1', $aveOfAveBus1Top1)   
      ->with('stdOfStdB1T1', $stdOfStdBus1Top1)
      ->with('medianB1T1', $medianBus1Top1)
      ->with('perc1B1T1', $perc1Bus1Top1)
      ->with('perc2B1T1', $perc2Bus1Top1)    
      ->with('dateRange',$this->getDateRangeForSPC())
      ->with('productBuilt',$prod)
      ->with('USL',$USL)
      ->with('LSL',$LSL)
      ->with('UCL',$UCL)
      ->with('LCL',$LCL)
      ->with('CL',$CL)
      ->with('target',$target)
      ->with('zBus1Top1',$zBus1Top1)
      ->with('CpUB1T1',$CpUBus1Top1)
      ->with('CpLB1T1',$CpLBus1Top1)
      ->with('CpkB1T1',$CpkB1T1)
      ->with('CpnB1T1',$CpnB1T1)
      ->with('CpnUB1T1',$CpnUB1T1)     
      ->with('CpnLB1T1',$CpnLB1T1);
    
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matrix.createofflinematsoldering');
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request   
     * @return \Illuminate\Http\Response
     */

    public function store_Sum(Request $request)
    {
        
        if($request->input('prodBuilt') != null && $request->input('fromDate') == null && $request->input('toDate') == null ){
            $prod = $request->input('prodBuilt') ;
            if (strpos($prod, '5BB') ) {
                $bbno = "5bb";
            }else{
                $bbno = "4bb";
            }
        
            $node1 = "Soldering Temperature MatPrep";
            
           // $prod = "Gintech";
            $location ="Busbar Prep";
            $node = "Soldering Temp";
            $aveIndBus1Top1 = $this->getAveInd($location,$node,$prod);
            $stdIndBus1Top1 = $this->getStdInd($location,$node,$prod);      
            $aveOfAveBus1Top1 = $this->getAveOfAve($location,$node,$prod);      
            $stdOfStdBus1Top1 = $this->getStdOfStd($location,$node,$prod);
            $medianBus1Top1 = $this->getMedian($location,$node,$prod);          
            $perc1Bus1Top1 = $this->getList4percentile($location,$node,$prod,0.00135);     
            $perc2Bus1Top1 = $this->getList4percentile($location,$node,$prod,0.99865);
           
            $USL = $this->getSpecsULVal($prod,$node1,$bbno);
            $LSL = $this->getSpecsLLVal($prod,$node1,$bbno);
            $target = $this->getSpecsLimitTarget($prod,$node1,$bbno);
            //$UCL=37.4;
            //$LCL=7.09;
            $UCL = 4.695624;
            $LCL = 1.763120;
            $CL = (($UCL-$LCL)/2)+$LCL;
            $zBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$CL),$stdOfStdBus1Top1));
            $CpLBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$LCL),(3*$stdOfStdBus1Top1) ));
            $CpUBus1Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top1),(3*$stdOfStdBus1Top1) ));      
            $arrValForCpkB1T1 = array( $CpUBus1Top1,$CpLBus1Top1);  
            $CpkB1T1 = min(array_filter($arrValForCpkB1T1));  
            $CpnUB1T1 =$this->divideByZeroExempt(($USL - $medianBus1Top1 ),( $perc2Bus1Top1 - $medianBus1Top1));
            $CpnLB1T1 = $this->divideByZeroExempt(($medianBus1Top1  - $LSL),( $medianBus1Top1 -  $perc1Bus1Top1));
            $arrValForCpnB1T1 = array( $CpnUB1T1,  $CpnLB1T1);         
            $CpnB1T1 =  min(array_filter($arrValForCpnB1T1));  
           
    
            return view('matrix.btobpulltest') 
          ->with('aveIndB1T1', $aveIndBus1Top1)
          ->with('stdIndB1T1', $stdIndBus1Top1)         
          ->with('aveOfAveB1T1', $aveOfAveBus1Top1)   
          ->with('stdOfStdB1T1', $stdOfStdBus1Top1)
          ->with('medianB1T1', $medianBus1Top1)
          ->with('perc1B1T1', $perc1Bus1Top1)
          ->with('perc2B1T1', $perc2Bus1Top1)    
          ->with('dateRange',$this->getDateRangeForSPC())
          ->with('productBuilt',$prod)
          ->with('USL',$USL)
          ->with('LSL',$LSL)
          ->with('UCL',$UCL)
          ->with('LCL',$LCL)
          ->with('CL',$CL)
          ->with('N',$this-> getMedianCount())
          ->with('target',$target)
          ->with('zBus1Top1',$zBus1Top1)
          ->with('CpUB1T1',$CpUBus1Top1)
          ->with('CpLB1T1',$CpLBus1Top1)
          ->with('CpkB1T1',$CpkB1T1)
          ->with('CpnB1T1',$CpnB1T1)
          ->with('CpnUB1T1',$CpnUB1T1)     
          ->with('CpnLB1T1',$CpnLB1T1);
      
         
        }elseif($request->input('prodBuilt') != null && $request->input('fromDate') != null && $request->input('toDate') != null )
        {         
   
       /*     $prod = $request->input('prodBuilt') ;
            $from = $request->input('fromDate');
            $to = $request->input('toDate');
            if (strpos($prod, '5BB') ) {
                $bbno = "5bb";
            }else{
                $bbno = "4bb";
            }
        
            $node1 = "BB-to-BB Pull Strength";
            
           // $prod = "Gintech";
            $location ="Busbar Prep";
            $node = "Busbar to Busbar";
            $aveIndBus1Top1 = $this->wDategetAveInd($location,$node,$prod,$from,$to);
            $stdIndBus1Top1 = $this->wDategetStdInd($location,$node,$prod,$from,$to);      
            $aveOfAveBus1Top1 = $this->wDategetAveOfAve($location,$node,$prod,$from,$to);      
            $stdOfStdBus1Top1 = $this->wDategetStdOfStd($location,$node,$prod,$from,$to);
            $medianBus1Top1 = $this->wDategetMedian($location,$node,$prod,$from,$to);          
            $perc1Bus1Top1 = $this->wDategetList4percentile($location,$node,$prod,$from,$to,0.00135);     
            $perc2Bus1Top1 = $this->wDategetList4percentile($location,$node,$prod,$from,$to,0.99865);
           
            $USL = $this->getSpecsULVal($prod,$node1,$bbno);
            $LSL = $this->getSpecsLLVal($prod,$node1,$bbno);
            $target = $this->getSpecsLimitTarget($prod,$node1,$bbno);
           // $UCL=37.4;
           // $LCL=7.09;
           $UCL = 4.695624;
           $LCL = 1.763120;
            $CL = (($UCL-$LCL)/2)+$LCL;
            $zBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$CL),$stdOfStdBus1Top1));
            $CpLBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$LCL),(3*$stdOfStdBus1Top1) ));
            $CpUBus1Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top1),(3*$stdOfStdBus1Top1) ));      
            $arrValForCpkB1T1 = array( $CpUBus1Top1,$CpLBus1Top1);  
            $CpkB1T1 =  min(array_filter( $arrValForCpkB1T1));  
            $CpnUB1T1 =$this->divideByZeroExempt(($USL - $medianBus1Top1 ),( $perc2Bus1Top1 - $medianBus1Top1));
            $CpnLB1T1 = $this->divideByZeroExempt(($medianBus1Top1  - $LSL),( $medianBus1Top1 -  $perc1Bus1Top1));
            $arrValForCpnB1T1 = array( $CpnUB1T1,  $CpnLB1T1);         
            $CpnB1T1 = min(array_filter(  $arrValForCpnB1T1));  
    
            return view('matrix.btobpulltest') 
          ->with('aveIndB1T1', $aveIndBus1Top1)
          ->with('stdIndB1T1', $stdIndBus1Top1)         
          ->with('aveOfAveB1T1', $aveOfAveBus1Top1)   
          ->with('stdOfStdB1T1', $stdOfStdBus1Top1)
          ->with('medianB1T1', $medianBus1Top1)
          ->with('perc1B1T1', $perc1Bus1Top1)
          ->with('perc2B1T1', $perc2Bus1Top1)    
          ->with('dateRange',$this->getDateRange2($from,$to))
          ->with('productBuilt',$prod)
          ->with('USL',$USL)
          ->with('LSL',$LSL)
          ->with('UCL',$UCL)
          ->with('LCL',$LCL)
          ->with('CL',$CL)
          ->with('N',$this->getDateRange($from,$to))
          ->with('target',$target)
          ->with('zBus1Top1',$zBus1Top1)
          ->with('CpUB1T1',$CpUBus1Top1)
          ->with('CpLB1T1',$CpLBus1Top1)
          ->with('CpkB1T1',$CpkB1T1)
          ->with('CpnB1T1',$CpnB1T1)
          ->with('CpnUB1T1',$CpnUB1T1)     
          ->with('CpnLB1T1',$CpnLB1T1); */

          return view('matrix.btobpulltest');
         }

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

        $prod = $request->input('prodBuilt');
        $node1 = "Soldering Temperature MatPrep";
        $target = DB::table(DB::select("SELECT * FROM parameters JOIN producttype ON parameters.BOMType = producttype.bomType JOIN subprocess ON parameters.subProcessName = subprocess.subProcessName WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node1."'"));
        $LLval =  number_format($target->from[0]->LCL,2);
        $ULval = number_format($target->from[0]->UCL,2);
            $this->validate($request, [  
                'employeeid' => 'required',       
                'location' => 'required',
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required',
                'temp1' =>  'required|numeric',
                'temp2' =>  'required|numeric',
                'temp3' =>  'required|numeric',
                'remarks' => 'required',
                'average' => 'required',
                'prodBuilt' => 'required',
                'station' => 'required'
            ]);
            $empid = $request->input('employeeid');
            $location = $request->input('location');
            $station = $request->input('station');
            $shift = $request->input('shift');
            $node = $request->input('node');
            $sup = $request->input('supplier');
            $temp1 = $request->input('temp1');
            $temp2 = $request->input('temp2');
            $temp3 = $request->input('temp3');
            $remarks = $request->input('remarks');
            $ave = $request->input('average');
            $fixdate = $request->input('fixture_date');
            $prodbuilt = $request->input('prodBuilt');
            $station = $request->input('station');

            if($ULval != 0 && $ULval > $LLval){
                if($this->checkULval($temp1,$ULval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station))
                {   return redirect('/offlinematsolder/create')->with('error', 'Record added but temp1 failed. For Requal.');
                }elseif($this->checkLLval($temp1,$LLval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station))
                {  return redirect('/offlinematsolder/create')->with('error', 'Record added but temp1 failed. For Requal.');
                }elseif($this->checkULval($temp2,$ULval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station))
                {   return redirect('/offlinematsolder/create')->with('error', 'Record added but temp2 failed. For Requal.');
                }elseif($this->checkLLval($temp2,$LLval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station))
                {  return redirect('/offlinematsolder/create')->with('error', 'Record added but temp2 failed. For Requal.');
                }elseif($this->checkULval($temp3,$ULval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station))
                {   return redirect('/offlinematsolder/create')->with('error', 'Record added but temp3 failed. For Requal.');
                }elseif($this->checkLLval($temp3,$LLval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station))
                {  return redirect('/offlinematsolder/create')->with('error', 'Record added but temp3 failed. For Requal.');
                }else{
                    $post =  new OfflineMatSolderingPost;
                    $post->employeeid = $request->input('employeeid');
                    $post->location = $request->input('location');
                    $post->shift = $request->input('shift');
                    $post->node = $request->input('node');
                    $post->supplier = $request->input('supplier');
                    $post->temp1 = $request->input('temp1');
                    $post->temp2 = $request->input('temp2');
                    $post->temp3 = $request->input('temp3');
                    $post->remarks = $request->input('remarks');
                    $post->average = $request->input('average');
                    $post->date = $request->input('fixture_date');
                    $post->prodBuilt = $request->input('prodBuilt');
                    $post->station = $request->input('station');
                    $post->qualRes = 'pass';
                    $post->save ();
                    $posts = DB::select('SELECT * FROM offlinematsoldering ORDER BY id DESC');
                    return view('matrix.sumofflinematsoldering')->with('offlinematsolderingtemp', $posts)
                    ->with('success','Record was successfully added!');
                }
            
            }elseif($ULval == 0){

            }



        //Create Post
        //$post = $request->post;
        $post =  new OfflineMatSolderingPost;
        $post->employeeid = $request->input('employeeid');
        $post->location = $request->input('location');
        $post->station = $request->input('station');
        $post->shift = $request->input('shift');
        $post->node = $request->input('node');
        $post->supplier = $request->input('supplier');
        $post->temp1 = $request->input('temp1');
        $post->temp2 = $request->input('temp2');
        $post->temp3 = $request->input('temp3');
        $post->remarks = $request->input('remarks');
        $post->average = $request->input('average');
        $post->date = $request->input('fixture_date');
        $post->prodBuilt = $request->input('prodBuilt');
        $post->station = $request->input('station');
        $post->save ();
        $posts = DB::select('SELECT * FROM offlinematsoldering ORDER BY id DESC');
        return view('matrix.sumofflinematsoldering')->with('offlinematsolderingtemp', $posts)
        ->with('success','Record was successfully added!');
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
        $post = OfflineMatSolderingPost::find($id);
        return view('pages.about')->with('offlinematsoldering', $post);
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
        $post = OfflineMatSolderingPost::find($id);
        $post->string = $request->input('location');
        $post->string = $request->input('station');
        $post->string = $request->input('shift');
        $post->string = $request->input('node');
        $post->string = $request->input('supplier');
        $post->string = $request->input('temp1');
        $post->string = $request->input('temp2');
        $post->string = $request->input('temp3');
        $post->string = $request->input('remarks');
        $post->float = $request->input('average');
        $post->string = $request->input('date');
        $post->save();
        return redirect('/offlinematsolderingposts')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = OfflineMatSolderingPost::find($id);
        $post->delete();
        return redirect('/offlinematsolderingposts')->with('success', 'Data Deleted');
    }

    
    
    public function getAveInd($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->aveWt,6);
        return $wtAve;
    }
    public function getStdInd($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(average) as StdWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->StdWt,6);
        return $wtAve;
    }
    public function getAveOfAve($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        return $wtAve;
    }
    public function getStdOfStd($location,$process,$product)
    {
        $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
        return $wtAve;
    }
    public function getMedian($location,$process,$product)
    {
        $median = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));

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
        $median = DB::table(DB::select("SELECT * FROM view_offlinematsoldering"));
        $medianCount = DB::table(DB::select("SELECT COUNT(date) as aveCount FROM view_offlinematsoldering "));

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
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
        $wtAveList = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM offlinematsoldering WHERE date IN (SELECT * FROM view_offlinematsoldering) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
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

             public function getSpecsUCLVal($prod,$node,$bbnum)
             {
               
                $target = DB::table(DB::select("SELECT * FROM parameters JOIN producttype ON parameters.BOMType = producttype.bomType JOIN subprocess ON parameters.subProcessName = subprocess.subProcessName WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."'"));
              //  $LLval =  number_format($target->from[0]->LCL,2);
                $ULval = number_format($target->from[0]->UCL,2);
                return $ULval;
               
            }
            public function getSpecsLCLVal($prod,$node,$bbnum)
            {
               
               $target = DB::table(DB::select("SELECT * FROM parameters JOIN producttype ON parameters.BOMType = producttype.bomType JOIN subprocess ON parameters.subProcessName = subprocess.subProcessName WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node."'"));
               $LLval =  number_format($target->from[0]->LCL,2);
              // $ULval = number_format($target->from[0]->UCL,2);
               
              return $LLval;
           }
           public function checkULval($site,$ULval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station){
            if($site  > $ULval )
            {
                $post =  new OfflineMatSolderingPost;
                $post->employeeid = $empid;
                $post->location = $location;
                $post->shift = $shift;
                $post->node = $node;
                $post->supplier = $sup;
                $post->temp1 = $temp1;
                $post->temp2 = $temp2;
                $post->temp3 = $temp3;
                $post->remarks = $remarks;
                $post->average = $ave;
                $post->date = $fixdate;
                $post->prodBuilt = $prodbuilt;
                $post->station = $station;
                $post->qualRes = 'fail';
                $post->save();
                return true;
                    /*  $posts = DB::select('SELECT * FROM offlinematsoldering ORDER BY id DESC');
                return view('matrix.sumofflinematsoldering')->with('offlinematsolderingtemp', $posts)
                ->with('success','Record was successfully added!'); */
            }else{
                return false;
            }
            }

           public function checkLLval($site,$ULval,$empid,$location,$shift,$node,$sup,$temp1,$temp2,$temp3,$remarks,$ave,$fixdate,$prodbuilt,$station){
            if($ULval > $site )
            {
                $post =  new OfflineMatSolderingPost;
                $post->employeeid = $empid;
                $post->location = $location;
                $post->shift = $shift;
                $post->node = $node;
                $post->supplier = $sup;
                $post->temp1 = $temp1;
                $post->temp2 = $temp2;
                $post->temp3 = $temp3;
                $post->remarks = $remarks;
                $post->average = $ave;
                $post->date = $fixdate;
                $post->prodBuilt = $prodbuilt;
                $post->station = $station;
                $post->qualRes = 'fail';
                $post->save();
                return true;
                    /*  $posts = DB::select('SELECT * FROM offlinematsoldering ORDER BY id DESC');
                return view('matrix.sumofflinematsoldering')->with('offlinematsolderingtemp', $posts)
                ->with('success','Record was successfully added!'); */
            }else{
                return false;
            }
            }


     

     
          
}