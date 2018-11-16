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
       // $UCL=37.4;
       // $LCL=7.09;
       $UCL = $this->getSpecsUCLVal($prod,$node1,$bbno);
       $LCL = $this->getSpecsLCLVal($prod,$node1,$bbno);
        $CL = (($UCL-$LCL)/2)+$LCL;
        $zBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$CL),$stdOfStdBus1Top1));
        $CpLBus1Top1 = ABS($this->divideByZeroExempt(($aveOfAveBus1Top1-$LCL),(3*$stdOfStdBus1Top1) ));
        $CpUBus1Top1 = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveBus1Top1),(3*$stdOfStdBus1Top1) ));      
        $arrValForCpkB1T1 = array( $CpUBus1Top1,$CpLBus1Top1);  
        $CpkB1T1 =  min(array_filter( $arrValForCpkB1T1));  

        $CpnUB1T1 =$this->divideByZeroExempt(($USL - $medianBus1Top1 ),( $perc2Bus1Top1 - $medianBus1Top1));
        $CpnLB1T1 = $this->divideByZeroExempt(($medianBus1Top1  - $LSL),( $medianBus1Top1 -  $perc1Bus1Top1));
        $arrValForCpnB1T1 = array( $CpnUB1T1,  $CpnLB1T1);         
        $CpnB1T1 =  min(array_filter(  $arrValForCpnB1T1));  
       

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
      ->with('N',$this->getMedianCount())
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

    public function store_Sum(Request $request)
    {
        
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
            //$UCL=37.4;
            //$LCL=7.09;
            $UCL = $this->getSpecsUCLVal($prod,$node1,$bbno);
            $LCL = $this->getSpecsLCLVal($prod,$node1,$bbno);
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
           // $UCL=37.4;
           // $LCL=7.09;
           $UCL = $this->getSpecsUCLVal($prod,$node1,$bbno);
           $LCL = $this->getSpecsLCLVal($prod,$node1,$bbno);
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
          ->with('CpnLB1T1',$CpnLB1T1);
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
        $node1 = "BB-to-BB Pull Strength";
        $target = DB::table(DB::select("SELECT * FROM parameters JOIN producttype ON parameters.BOMType = producttype.bomType JOIN subprocess ON parameters.subProcessName = subprocess.subProcessName WHERE producttype.prodName ='".$prod."' AND parameters.subProcessName = '".$node1."'"));
        $LLval =  number_format($target->from[0]->LCL,2);
        $ULval = number_format($target->from[0]->UCL,2);
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

            $empid = $request->input('employeeid');
                        $process = $request->input('process');
                        $shift = $request->input('shift');
                        $node = $request->input('node');
                        $sup = $request->input('supplier');
                        $site1 = $request->input('site1');
                        $site2 = $request->input('site2');
                        $site3 = $request->input('site3');
                        $remarks = $request->input('remarks');
                        $ave = $request->input('average');
                        $fixdate = $request->input('fixture_date');
                        $prodbuilt = $request->input('prodBuilt');
        //Create Post;;;;;;;;;;;;;;;;;;;;;;;;;;;;;pl.pki
        //$post = $request->post;
                if($ULval != 0 && $ULval > $LLval){
                        
                        
                        //$qualRes = 'pass';
                       // $site = $request->input('site1');
                        if($this->checkLLval($site1,$LLval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                            return redirect('/offlinebtob/create')->with('error', 'Record added but site1 failed. For Requal.');
                        }elseif($this->checkULval($site1,$ULval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                            return redirect('/offlinebtob/create')->with('error', 'Record added but site1 failed. For Requal.');
                        }elseif($this->checkLLval($site2,$LLval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                            return redirect('/offlinebtob/create')->with('error', 'Record added but site2 failed. For Requal.');
                        }elseif($this->checkULval($site2,$ULval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                            return redirect('/offlinebtob/create')->with('error', 'Record added but site2 failed. For Requal.');
                        }elseif($this->checkLLval($site3,$LLval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                            return redirect('/offlinebtob/create')->with('error', 'Record added but site3 failed. For Requal.');
                        }elseif($this->checkULval($site3,$ULval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                            return redirect('/offlinebtob/create')->with('error', 'Record added but site3 failed. For Requal.');
                        }else{
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
                            $post->qualRes = 'pass';
                            $post->save ();
                            return redirect('/btobpulltest')->with('success', 'Record Successfully added');

                        }

                      
               
                }elseif($ULval == 0){
                    if($this->checkLLval($site1,$LLval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                        return redirect('/offlinebtob/create')->with('error', 'Record added but site1 failed. For Requal.');
                    }elseif($this->checkLLval($site2,$LLval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                        return redirect('/offlinebtob/create')->with('error', 'Record added but site2 failed. For Requal.');
                    }elseif($this->checkLLval($site3,$LLval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt)){
                        return redirect('/offlinebtob/create')->with('error', 'Record added but site3 failed. For Requal.');
                    }else{
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
                        $post->qualRes = 'pass';
                        $post->save ();
                        return redirect('/btobpulltest')->with('success', 'Record Successfully added');
                    }

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
            // $cnt = OfflineBtoBPullTestPost::where("prodBuilt",$product)->limit(30)->get()->count() / 10 * 3;
            $cnt = 3;   
            $btob = OfflineBtoBPullTestPost::selectRaw("AVG(site1 + site2 + site3) / ? AS AVERAGE", [$cnt])->where("prodBuilt","=",$product)->orderBy("date","desc")->limit(30)->first();
            // $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT  location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT  location,node,prodBuilt,date,site3 as site FROM btobpulltest) as tbl_ave  WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."'"));
            // $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return number_format($btob->AVERAGE,6);
        }else{
            $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT  location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT  location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT  location,node,prodBuilt,date,site3 as site FROM btobpulltest ) as tbl_ave WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."'"));
            $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return $wtAve;
        }
       
    }
      
    public function wDategetAveInd($location,$process,$product,$from,$to)
    {
        if($product!="All"){
            $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT  location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site3 as site FROM btobpulltest ) as tbl_ave WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."'"));
            $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT AVG(site) as aveWt FROM (SELECT location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site3 as site FROM btobpulltest ) as tbl_ave  WHERE date IN (SELECT * FROM view_btobpulltest) AND  location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."'"));
            $wtAve = number_format($weightAve->from[0]->aveWt,6);
            return $wtAve;
        }
       
       
    }
    public function getStdInd($location,$process,$product)
    {
        if($product!="All"){
       $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(site) as StdWt FROM (SELECT location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site3 as site FROM btobpulltest ) as tbl_ave WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."'"));
       $wtAve = number_format($weightAve->from[0]->StdWt,6);
       return $wtAve;

      //  $cnt = 3;   
       //$btob = OfflineBtoBPullTestPost::selectRaw("STDDEV_SAMP(site1 + site2 + site3) / ? AS STDev", [$cnt])->where("prodBuilt","=",$product)->orderBy("date","desc")->limit(30)->first();
       // return number_format($btob->STDev,6);
    }else{
            $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(site) as StdWt FROM (SELECT location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site3 as site FROM btobpulltest ) as tbl_ave WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."'"));
            $wtAve = number_format($weightAve->from[0]->StdWt,6);
            return $wtAve;
        }
    }
    public function wDategetStdInd($location,$process,$product,$from,$to)
    {
        if($product!="All"){
        $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(site) as StdWt FROM (SELECT location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site3 as site FROM btobpulltest )  as tbl_ave WHERE location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."' AND date BETWEEN '".$from."' AND '".$to."'"));
        $wtAve = number_format($weightAve->from[0]->StdWt,6);
        return $wtAve;
        }else{
            $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(site) as StdWt FROM (SELECT location,node,prodBuilt,date,site1 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site2 as site FROM btobpulltest UNION SELECT location,node,prodBuilt,date,site3 as site FROM btobpulltest )  as tbl_ave WHERE location='".$location."' AND node ='".$process."' AND date BETWEEN '".$from."' AND '".$to."'"));
            $wtAve = number_format($weightAve->from[0]->StdWt,6);
            return $wtAve; 
        }
       
    }
    public function getAveOfAve($location,$process,$product)
    {
        if($product!="All"){
      //  $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' AND prodBuilt = '".$product."') as tbl_ave GROUP BY date) as tbl_aveOfave"));
        //$wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        //return $wtAve;
        
        $btob = OfflineBtoBPullTestPost::selectRaw("AVG(average) AS AVERAGE")->where("prodBuilt","=",$product)->orderBy("date","desc")->limit(30)->first();
        return number_format($btob->AVERAGE,6);
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
    public function getMedianCount()
    {
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) ) as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
        $medianCountVal = $medianCount->from[0]->aveCount;
        return  $medianCountVal;
    }
    
    public function getMedian($location,$process,$product)
    {

        if($product!="All"){
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
        else
        {
            $median = DB::table(DB::select("SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' ) as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
            $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(average) as aveWt FROM (SELECT * FROM btobpulltest WHERE date IN (SELECT * FROM view_btobpulltest) AND location='".$location."' AND node ='".$process."' ) as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
           
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
         
            $median = DB::table(DB::select("SELECT COUNT(DISTINCT(date)) as aveCount FROM btobpulltest WHERE date BETWEEN '".$from."' AND '".$to."'"));
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
          //return number_format(($val1)/($val2),4);
         // return 0;
         $quo = number_format(($val1)/($val2),4);
         if($quo >0){
             return $quo;
         }else{
             return 0;
         }
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

         public function minZero($val){
             if($val==0){
                 return ' ';
             }else{
                 return $val;
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
           public function checkULval($site,$ULval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt){
            if($site  > $ULval )
            {
                $post = new OfflineBtoBPullTestPost;
                $post->employeeid = $empid;
                $post->location = $process;
                $post->shift = $shift;
                $post->node = $node;
                $post->supplier = $sup;
                $post->site1 = $site1;
                $post->site2 = $site2;
                $post->site3 = $site3;
                $post->remarks = $remarks;
                $post->average = $ave;
                $post->date = $fixdate;
                $post->prodBuilt = $prodbuilt;
                $post->qualRes = 'fail';
                $post->save ();
                return true;
               // return redirect('/offlinebtob/create')->with('error', 'Record added but '.$site.' failed. For Requal.');
            }else{
                return false;
            }
            }

           public function checkLLval($site,$LLval,$empid,$process,$shift,$node,$sup,$site1,$site2,$site3,$remarks,$ave,$fixdate,$prodbuilt){
            if($LLval > $site )
            {
                $post = new OfflineBtoBPullTestPost;
                $post->employeeid = $empid;
                $post->location = $process;
                $post->shift = $shift;
                $post->node = $node;
                $post->supplier = $sup;
                $post->site1 = $site1;
                $post->site2 = $site2;
                $post->site3 = $site3;
                $post->remarks = $remarks;
                $post->average = $ave;
                $post->date = $fixdate;
                $post->prodBuilt = $prodbuilt;
                $post->qualRes = 'fail';
                $post->save ();
                return true;
               // return redirect('/offlinebtob/create')->with('error', 'Record added but '.$site.' failed. For Requal.');
            }else{
                return false;
            }
            }

}