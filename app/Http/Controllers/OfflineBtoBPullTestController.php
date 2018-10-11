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
    
        $node1 = "BB-to-BB Pull Strength";
        
       // $prod = "Gintech";
        $location ="Busbar Prep";
        $node = "Busbar to Busbar";
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
        $UCL=37.4;
        $LCL=7.09;
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
      ->with('N','30')
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
           
        if($request->input('prodBuilt') != null && $request->input('fromDate') == null && $request->input('toDate') == null ){
            $prod = $request->input('prodBuilt') ;
            if (strpos($prod, '5BB') ) {
                $bbno = "5bb";
            }else{
                $bbno = "4bb";
            }
        
            $node1 = "BB-to-BB Pull Strength";
            
           // $prod = "Gintech";
            $location ="Busbar Prep";
            $node = "Busbar to Busbar";
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
            $UCL=37.4;
            $LCL=7.09;
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
          ->with('N','30')
          ->with('target',$target)
          ->with('zBus1Top1',$zBus1Top1)
          ->with('CpUB1T1',$CpUBus1Top1)
          ->with('CpLB1T1',$CpLBus1Top1)
          ->with('CpkB1T1',$CpkB1T1)
          ->with('CpnB1T1',$CpnB1T1)
          ->with('CpnUB1T1',$CpnUB1T1)     
          ->with('CpnLB1T1',$CpnLB1T1);
      
         
        }elseif($request->input('prodBuilt') != null && $request->input('fromDate') != null && $request->input('toDate') != null ){
            $prod = $request->input('prodBuilt') ;
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
            $UCL=37.4;
            $LCL=7.09;
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
          ->with('CpnLB1T1',$CpnLB1T1);
         }else{
            $this->validate($request, [  
                'employeeid' => 'required|numeric',       
                'process' => 'required',
                'shift' => 'required',
                'node'=> 'required',
                'supplier' => 'required',  
                'site1' => 'required',
                'site2' => 'required',
                'site3' => 'required',
                'remarks' => 'required',
                'average' => 'required',
                'prodBuilt'=>'required'
            ]);

        //Create Post;;;;;;;;;;;;;;;;;;;;;;;;;;;;;pl.pki
        //$post = $request->post;
        $post = new OfflineBtoBPullTestPost;
        $post->employeeid = $request->input('employeeid');
        $post->location = $request->input('process');
        $post->shift = $request->input('shift');
        $post->node = $request->input('node');
        $post->supplier = $request->input('supplier');
        $post->site1 = $request->input('site1');
        $post->site2 = $request->input('site2');
        $post->site3 = $request->input('site3');
        $post->remarks = $request->input('remarks');
        $post->average = $request->input('average');
        $post->date = $request->input('fixture_date');
        $post->prodBuilt = $request->input('prodBuilt');
        $post->save ();
        return redirect('/btobpulltest')->with('success', 'Record Successfully added');
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


    
    public function getAveInd($location,$process,$product)
    {
        if($product!="All"){
            $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave"));
            $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."') as tbl_ave"));
            $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return $wtAve;
        }
       
    }
      
    public function wDategetAveInd($location,$process,$product,$from,$to)
    {
        if($product!="All"){
            $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."') as tbl_ave"));
            $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."') as tbl_ave"));
            $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return $wtAve;
        }
       
       
    }
    public function getStdInd($location,$process,$product)
    {
        if($product!="All"){
        $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(site) as StdWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->StdWt,6);
        return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(site) as StdWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."') as tbl_ave"));
            $wtAve = number_format($weightAve->from[0]->StdWt,6);
            return $wtAve;
        }
    }
    public function wDategetStdInd($location,$process,$product,$from,$to)
    {
        if($product!="All"){
        $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(site) as StdWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->StdWt,6);
        return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(site) as StdWt FROM (SELECT date,site1 as site FROM btobpulltest UNION SELECT date,site2 as site FROM btobpulltest UNION SELECT date,site3 as site FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave"));
            $wtAve = number_format($weightAve->from[0]->StdWt,6);
            return $wtAve; 
        }
       
    }
    public function getAveOfAve($location,$process,$product)
    {
        if($product!="All"){
        $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' ) as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        return $wtAve;
        }
    }
    public function wDategetAveOfAve($location,$process,$product,$from,$to)
    {
        if($product!="All"){
        $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date) as tbl_aveOfave"));
            $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
            return $wtAve;
        }
       
    }
    public function getStdOfStd($location,$process,$product)
    {
        if($product!="All"){
        $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
        return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' ) as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
        return $wtAve;
        }
    }
    public function wDategetStdOfStd($location,$process,$product,$from,$to)
    {
        if($product!="All"){
      
        $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
        return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date) as tbl_aveOfave"));
            $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
            return $wtAve;
        }
       
    }
    public function getMedian($location,$process,$product)
    {
      
        $median = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
       
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
    public function wDategetMedian($location,$process,$product,$from,$to)
    {
       if($product!="All"){
        $median = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
       
    }else{
        $median = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."'  AND date BETWEEN '".$from."' AND '".$to."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));

    }
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
     
        $median = DB::table(DB::select("SELECT * FROM view_btobpulltest"));
        $medianCount = DB::table(DB::select("SELECT COUNT(date) as aveCount FROM view_btobpulltest "));
        
        $medianCountVal = $medianCount->from[0]->aveCount;
       
        if($medianCountVal == 0){
            return "no data.";
        }else{
            $enddate = $median->from[0]->date ;
            $startdate = $median->from[$medianCountVal-1]->date ;
            return $startdate."  to  ".$enddate;
        }
       
        }

        public function getDateRange2($from,$to)
        {
         
            return $from." to  ".$to;
            }

        public function getDateRange($from,$to)
        {
         
            $median = DB::table(DB::select("SELECT COUNT(date) as aveCount FROM btobpulltest WHERE date BETWEEN '".$from."' AND '".$to."'"));
           // $medianCount = DB::table(DB::select("SELECT COUNT(date) as aveCount FROM view_btobpulltest "));
            
            $medianCountVal = $median->from[0]->aveCount;
           return  $medianCountVal;
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
        if($product!="All"){
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
        $wtAveList = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        }else{
            $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' ) as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
            $wtAveList = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."') as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        }
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
     public function wDategetList4percentile($location,$process,$product,$from,$to,$percentdec){
       
        if($product!="All"){
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
        $wtAveList = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        }
        else{
            $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
            $wtAveList = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE location='".$location."' AND node ='".$process."'  AND date BETWEEN '".$from."' AND '".$to."')  as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        }
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