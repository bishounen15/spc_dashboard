<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Stringer;
use DB;
use datatable;
class StringerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        return view('pages.datatable');
    }
    public function getPosts()
    {
        return \DataTables::of(DB::query('Select * FROM stringers'))->make(true);
    }
    public function index()
    {
    /*
    // --------------STRINGER 1A---------------------------------//
        //AVE(IND) FRONT
        $avefront = number_format(DB::table('stringers')
        ->where([['Side','=','Front']])
        ->avg('PeelTest'),2);
        //AVE(IND) BACK
        $aveback = number_format(DB::table('stringers')
        ->where([['side','=','Back']])
        ->avg('PeelTest'),2);
        //STD(IND) FRONT
        $stdfront = DB::table('stringers')
        ->select(DB::raw('STDDEV(PeelTest) as Peeltest'))
        ->where([['Side','=','Front']])
        ->get();
        $stdfront = number_format($stdfront[0]->Peeltest,2);
         //STD(IND) BACK
         $stdback = DB::table('stringers')
         ->select(DB::raw('STDDEV(PeelTest) as Peeltest'))
         ->where([['Side','=','Back']])
         ->get();
         $stdback = number_format($stdback[0]->Peeltest,2);
        //XBB AVE OF AVE (FRONT)
        $xbbfront = DB::table('stringers')
        ->select(DB::raw('AVG(PeelTest) as PeelTest'))
        ->whereBetween('Date', [Date('Y-m-d',strtotime("-30 days")), Date('Y-m-d')])
        ->where([['Side','=','front']])
        ->groupBy('Date')
        ->get();
        $xbbfront = number_format($xbbfront->avg('PeelTest'),2);
         //XBB AVE OF AVE (BACK)
        $xbbback = DB::table('stringers')
        ->select(DB::raw('AVG(PeelTest) as PeelTest'))
        ->whereBetween('Date', [Date('Y-m-d',strtotime("-30 days")), Date('Y-m-d')])
        ->where([['Side','=','Back']])
        ->groupBy('Date')
        ->get();
        $xbbback = number_format($xbbback->avg('PeelTest'),2);
        //STD AVE (FRONT)
        $stdavg = DB::table(DB::raw("(SELECT AVG(PeelTest) as PeelTest FROM stringers WHERE Side = 'Front' and Date BETWEEN '".Date('Y-m-d',strtotime("-30 days"))."' AND '".Date('Y-m-d')."' GROUP BY Date) as temp"))
        //date BETWEEN from AND to
        ->select(DB::raw('STDDEV(PeelTest) as PeelTest'))
        ->get();
        $stdavg = number_format($stdavg->avg('PeelTest'),2);
        //STD AVE (BACK)
        $stdavgback = DB::table(DB::raw("(SELECT AVG(PeelTest) as PeelTest FROM stringers WHERE Side = 'Back' and Date BETWEEN '".Date('Y-m-d',strtotime("-30 days"))."' AND '".Date('Y-m-d')."' GROUP BY Date) as temp"))
        //date BETWEEN from AND to
        ->select(DB::raw('STDDEV(PeelTest) as PeelTest'))
        ->get();
        $stdavgback = number_format($stdavgback->avg('PeelTest'),2);
        //MEDIAN (FRONT)
        $medianfront = DB::table('stringers')
        ->select(DB::raw('AVG(PeelTest) as PeelTest'))
        ->whereBetween('Date', [Date('Y-m-d',strtotime("-30 days")), Date('Y-m-d')])
        ->groupBy('Date')
        ->where([['Side','=','Front']])
        ->get();
        $medianfront = number_format($medianfront->median('PeelTest'),2);
        //MEDIAN (BACK)
        $medianback = DB::table('stringers')
        ->select(DB::raw('AVG(PeelTest) as PeelTest'))
        ->whereBetween('Date', [Date('Y-m-d',strtotime("-30 days")), Date('Y-m-d')])
        ->groupBy('Date')
        ->where([['Side','=','Back']])
        ->get();
        $medianback = number_format($medianback->median('PeelTest'),2);
        */


        $USL = 0;
        $LSL = 0.6;
        $target = 0;
        $UCL=0;
        $LCL=0;
        $CL = (($UCL-$LCL)/2)+$LCL;

     
/// FOR stringer 1A and 1B
        
        $ave = "PeelTest";  
        $loc1  = "Stringer 1A";
        $side = "Front";
        $aveIndS1AF = $this->getAveInd($ave,$loc1,$side);
        $stdIndS1AF = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS1AF = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS1AF = $this->getStdOfStd($ave,$loc1,$side);
        $medianS1AF = $this->getMedian($ave,$loc1,$side);          
        $perc1S1AF = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S1AF = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS1AF = ABS($this->divideByZeroExempt(($aveOfAveS1AF-$CL),$stdOfStdS1AF));
        $CpLS1AF = ABS($this->divideByZeroExempt(($aveOfAveS1AF-$LCL),(3*$stdOfStdS1AF) ));
        $CpUS1AF = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS1AF),(3*$stdOfStdS1AF) ));      
        $arrValForCpkS1AF = array( $CpUS1AF,$CpLS1AF);  
        $CpkS1AF = min($arrValForCpkS1AF);
        $CpnUS1AF =$this->divideByZeroExempt(($USL - $medianS1AF ),( $perc2S1AF - $medianS1AF));
        $CpnLS1AF = $this->divideByZeroExempt(($medianS1AF  - $LSL),( $medianS1AF -  $perc1S1AF));
        $arrValForCpnS1AF = array( $CpnUS1AF,  $CpnLS1AF);         
        $CpnS1AF = min($arrValForCpnS1AF);

           
        $ave = "PeelTest";  
        $loc1  = "Stringer 1A";
        $side = "Back";
        $aveIndS1AB = $this->getAveInd($ave,$loc1,$side);
        $stdIndS1AB = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS1AB = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS1AB = $this->getStdOfStd($ave,$loc1,$side);
        $medianS1AB = $this->getMedian($ave,$loc1,$side);          
        $perc1S1AB = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S1AB = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS1AB = ABS($this->divideByZeroExempt(($aveOfAveS1AB-$CL),$stdOfStdS1AB));
        $CpLS1AB = ABS($this->divideByZeroExempt(($aveOfAveS1AB-$LCL),(3*$stdOfStdS1AB) ));
        $CpUS1AB = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS1AB),(3*$stdOfStdS1AB) ));      
        $arrValForCpkS1AB = array( $CpUS1AB,$CpLS1AB);  
        $CpkS1AB = min($arrValForCpkS1AB);
        $CpnUS1AB =$this->divideByZeroExempt(($USL - $medianS1AB ),( $perc2S1AB - $medianS1AB));
        $CpnLS1AB = $this->divideByZeroExempt(($medianS1AB  - $LSL),( $medianS1AB -  $perc1S1AB));
        $arrValForCpnS1AB = array( $CpnUS1AB,  $CpnLS1AB);         
        $CpnS1AB = min($arrValForCpnS1AB);


        $ave = "PeelTest";  
        $loc1  = "Stringer 1B";
        $side = "Front";
        $aveIndS1BF = $this->getAveInd($ave,$loc1,$side);
        $stdIndS1BF = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS1BF = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS1BF = $this->getStdOfStd($ave,$loc1,$side);
        $medianS1BF = $this->getMedian($ave,$loc1,$side);          
        $perc1S1BF = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S1BF = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS1BF = ABS($this->divideByZeroExempt(($aveOfAveS1BF-$CL),$stdOfStdS1BF));
        $CpLS1BF = ABS($this->divideByZeroExempt(($aveOfAveS1BF-$LCL),(3*$stdOfStdS1BF) ));
        $CpUS1BF = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS1BF),(3*$stdOfStdS1BF) ));      
        $arrValForCpkS1BF = array( $CpUS1BF,$CpLS1BF);  
        $CpkS1BF = min($arrValForCpkS1BF);
        $CpnUS1BF =$this->divideByZeroExempt(($USL - $medianS1BF ),( $perc2S1BF - $medianS1BF));
        $CpnLS1BF = $this->divideByZeroExempt(($medianS1BF  - $LSL),( $medianS1BF -  $perc1S1BF));
        $arrValForCpnS1BF = array( $CpnUS1BF,  $CpnLS1BF);         
        $CpnS1BF = min($arrValForCpnS1BF);



        $ave = "PeelTest";  
        $loc1  = "Stringer 1B";
        $side = "Back";
        $aveIndS1BB = $this->getAveInd($ave,$loc1,$side);
        $stdIndS1BB = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS1BB = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS1BB = $this->getStdOfStd($ave,$loc1,$side);
        $medianS1BB = $this->getMedian($ave,$loc1,$side);          
        $perc1S1BB = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S1BB = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS1BB = ABS($this->divideByZeroExempt(($aveOfAveS1BB-$CL),$stdOfStdS1BB));
        $CpLS1BB = ABS($this->divideByZeroExempt(($aveOfAveS1BB-$LCL),(3*$stdOfStdS1BB) ));
        $CpUS1BB = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS1BB),(3*$stdOfStdS1BB) ));      
        $arrValForCpkS1BB = array( $CpUS1BB,$CpLS1BB);  
        $CpkS1BB = min($arrValForCpkS1BB);
        $CpnUS1BB =$this->divideByZeroExempt(($USL - $medianS1BB ),( $perc2S1BB - $medianS1BB));
        $CpnLS1BB = $this->divideByZeroExempt(($medianS1BB  - $LSL),( $medianS1BB -  $perc1S1BB));
        $arrValForCpnS1BB = array( $CpnUS1BB,  $CpnLS1BB);         
        $CpnS1BB = min($arrValForCpnS1BB);

        /// FOR STRINGER 2A and 2B

        $ave = "PeelTest";  
        $loc1  = "Stringer 2A";
        $side = "Front";
        $aveIndS2AF = $this->getAveInd($ave,$loc1,$side);
        $stdIndS2AF = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS2AF = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS2AF = $this->getStdOfStd($ave,$loc1,$side);
        $medianS2AF = $this->getMedian($ave,$loc1,$side);          
        $perc1S2AF = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S2AF = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS2AF = ABS($this->divideByZeroExempt(($aveOfAveS2AF-$CL),$stdOfStdS2AF));
        $CpLS2AF = ABS($this->divideByZeroExempt(($aveOfAveS2AF-$LCL),(3*$stdOfStdS2AF) ));
        $CpUS2AF = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS2AF),(3*$stdOfStdS2AF) ));      
        $arrValForCpkS2AF = array( $CpUS2AF,$CpLS2AF);  
        $CpkS2AF = min($arrValForCpkS2AF);
        $CpnUS2AF =$this->divideByZeroExempt(($USL - $medianS2AF ),( $perc2S2AF - $medianS2AF));
        $CpnLS2AF = $this->divideByZeroExempt(($medianS2AF  - $LSL),( $medianS2AF -  $perc1S2AF));
        $arrValForCpnS2AF = array( $CpnUS2AF,  $CpnLS2AF);         
        $CpnS2AF = min($arrValForCpnS2AF);

           
        $ave = "PeelTest";  
        $loc1  = "Stringer 2A";
        $side = "Back";
        $aveIndS2AB = $this->getAveInd($ave,$loc1,$side);
        $stdIndS2AB = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS2AB = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS2AB = $this->getStdOfStd($ave,$loc1,$side);
        $medianS2AB = $this->getMedian($ave,$loc1,$side);          
        $perc1S2AB = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S2AB = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS2AB = ABS($this->divideByZeroExempt(($aveOfAveS2AB-$CL),$stdOfStdS2AB));
        $CpLS2AB = ABS($this->divideByZeroExempt(($aveOfAveS2AB-$LCL),(3*$stdOfStdS2AB) ));
        $CpUS2AB = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS2AB),(3*$stdOfStdS2AB) ));      
        $arrValForCpkS2AB = array( $CpUS2AB,$CpLS2AB);  
        $CpkS2AB = min($arrValForCpkS2AB);
        $CpnUS2AB =$this->divideByZeroExempt(($USL - $medianS2AB ),( $perc2S2AB - $medianS2AB));
        $CpnLS2AB = $this->divideByZeroExempt(($medianS2AB  - $LSL),( $medianS2AB -  $perc1S2AB));
        $arrValForCpnS2AB = array( $CpnUS2AB,  $CpnLS2AB);         
        $CpnS2AB = min($arrValForCpnS2AB);



        $ave = "PeelTest";  
        $loc1  = "Stringer 2B";
        $side = "Front";
        $aveIndS2BF = $this->getAveInd($ave,$loc1,$side);
        $stdIndS2BF = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS2BF = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS2BF = $this->getStdOfStd($ave,$loc1,$side);
        $medianS2BF = $this->getMedian($ave,$loc1,$side);          
        $perc1S2BF = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S2BF = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS2BF = ABS($this->divideByZeroExempt(($aveOfAveS2BF-$CL),$stdOfStdS2BF));
        $CpLS2BF = ABS($this->divideByZeroExempt(($aveOfAveS2BF-$LCL),(3*$stdOfStdS2BF) ));
        $CpUS2BF = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS2BF),(3*$stdOfStdS2BF) ));      
        $arrValForCpkS2BF = array( $CpUS2BF,$CpLS2BF);  
        $CpkS2BF = min($arrValForCpkS2BF);
        $CpnUS2BF =$this->divideByZeroExempt(($USL - $medianS2BF ),( $perc2S2BF - $medianS2BF));
        $CpnLS2BF = $this->divideByZeroExempt(($medianS2BF  - $LSL),( $medianS2BF -  $perc1S2BF));
        $arrValForCpnS2BF = array( $CpnUS2BF,  $CpnLS2BF);         
        $CpnS2BF = min($arrValForCpnS2BF);

           
        $ave = "PeelTest";  
        $loc1  = "Stringer 2B";
        $side = "Back";
        $aveIndS2BB = $this->getAveInd($ave,$loc1,$side);
        $stdIndS2BB = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS2BB = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS2BB = $this->getStdOfStd($ave,$loc1,$side);
        $medianS2BB = $this->getMedian($ave,$loc1,$side);          
        $perc1S2BB = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S2BB = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS2BB = ABS($this->divideByZeroExempt(($aveOfAveS2BB-$CL),$stdOfStdS2BB));
        $CpLS2BB = ABS($this->divideByZeroExempt(($aveOfAveS2BB-$LCL),(3*$stdOfStdS2BB) ));
        $CpUS2BB = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS2BB),(3*$stdOfStdS2BB) ));      
        $arrValForCpkS2BB = array( $CpUS2BB,$CpLS2BB);  
        $CpkS2BB = min($arrValForCpkS2BB);
        $CpnUS2BB =$this->divideByZeroExempt(($USL - $medianS2BB ),( $perc2S2BB - $medianS2BB));
        $CpnLS2BB = $this->divideByZeroExempt(($medianS2BB  - $LSL),( $medianS2BB -  $perc1S2BB));
        $arrValForCpnS2BB = array( $CpnUS2BB,  $CpnLS2BB);         
        $CpnS2BB = min($arrValForCpnS2BB);



///For Stringer 3 AandB



$ave = "PeelTest";  
$loc1  = "Stringer 3A";
$side = "Front";
$aveIndS3AF = $this->getAveInd($ave,$loc1,$side);
$stdIndS3AF = $this->getStdInd($ave,$loc1,$side);      
$aveOfAveS3AF = $this->getAveOfAve($ave,$loc1,$side);      
$stdOfStdS3AF = $this->getStdOfStd($ave,$loc1,$side);
$medianS3AF = $this->getMedian($ave,$loc1,$side);          
$perc1S3AF = $this->getList4percentile($ave,$loc1,$side,0.00135);     
$perc2S3AF = $this->getList4percentile($ave,$loc1,$side,0.99865);


$zS3AF = ABS($this->divideByZeroExempt(($aveOfAveS3AF-$CL),$stdOfStdS3AF));
$CpLS3AF = ABS($this->divideByZeroExempt(($aveOfAveS3AF-$LCL),(3*$stdOfStdS3AF) ));
$CpUS3AF = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS3AF),(3*$stdOfStdS3AF) ));      
$arrValForCpkS3AF = array( $CpUS3AF,$CpLS3AF);  
$CpkS3AF = min($arrValForCpkS3AF);
$CpnUS3AF =$this->divideByZeroExempt(($USL - $medianS3AF ),( $perc2S3AF - $medianS3AF));
$CpnLS3AF = $this->divideByZeroExempt(($medianS3AF  - $LSL),( $medianS3AF -  $perc1S3AF));
$arrValForCpnS3AF = array( $CpnUS3AF,  $CpnLS3AF);         
$CpnS3AF = min($arrValForCpnS3AF);

   
$ave = "PeelTest";  
$loc1  = "Stringer 3A";
$side = "Back";
$aveIndS3AB = $this->getAveInd($ave,$loc1,$side);
$stdIndS3AB = $this->getStdInd($ave,$loc1,$side);      
$aveOfAveS3AB = $this->getAveOfAve($ave,$loc1,$side);      
$stdOfStdS3AB = $this->getStdOfStd($ave,$loc1,$side);
$medianS3AB = $this->getMedian($ave,$loc1,$side);          
$perc1S3AB = $this->getList4percentile($ave,$loc1,$side,0.00135);     
$perc2S3AB = $this->getList4percentile($ave,$loc1,$side,0.99865);


$zS3AB = ABS($this->divideByZeroExempt(($aveOfAveS3AB-$CL),$stdOfStdS3AB));
$CpLS3AB = ABS($this->divideByZeroExempt(($aveOfAveS3AB-$LCL),(3*$stdOfStdS3AB) ));
$CpUS3AB = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS3AB),(3*$stdOfStdS3AB) ));      
$arrValForCpkS3AB = array( $CpUS3AB,$CpLS3AB);  
$CpkS3AB = min($arrValForCpkS3AB);
$CpnUS3AB =$this->divideByZeroExempt(($USL - $medianS3AB ),( $perc2S3AB - $medianS3AB));
$CpnLS3AB = $this->divideByZeroExempt(($medianS3AB  - $LSL),( $medianS3AB -  $perc1S3AB));
$arrValForCpnS3AB = array( $CpnUS3AB,  $CpnLS3AB);         
$CpnS3AB = min($arrValForCpnS3AB);




        $ave = "PeelTest";  
        $loc1  = "Stringer 3B";
        $side = "Front";
        $aveIndS3BF = $this->getAveInd($ave,$loc1,$side);
        $stdIndS3BF = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS3BF = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS3BF = $this->getStdOfStd($ave,$loc1,$side);
        $medianS3BF = $this->getMedian($ave,$loc1,$side);          
        $perc1S3BF = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S3BF = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS3BF = ABS($this->divideByZeroExempt(($aveOfAveS3BF-$CL),$stdOfStdS3BF));
        $CpLS3BF = ABS($this->divideByZeroExempt(($aveOfAveS3BF-$LCL),(3*$stdOfStdS3BF) ));
        $CpUS3BF = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS3BF),(3*$stdOfStdS3BF) ));      
        $arrValForCpkS3BF = array( $CpUS3BF,$CpLS3BF);  
        $CpkS3BF = min($arrValForCpkS3BF);
        $CpnUS3BF =$this->divideByZeroExempt(($USL - $medianS3BF ),( $perc2S3BF - $medianS3BF));
        $CpnLS3BF = $this->divideByZeroExempt(($medianS3BF  - $LSL),( $medianS3BF -  $perc1S3BF));
        $arrValForCpnS3BF = array( $CpnUS3BF,  $CpnLS3BF);         
        $CpnS3BF = min($arrValForCpnS3BF);



        $ave = "PeelTest";  
        $loc1  = "Stringer 3B";
        $side = "Back";
        $aveIndS3BB = $this->getAveInd($ave,$loc1,$side);
        $stdIndS3BB = $this->getStdInd($ave,$loc1,$side);      
        $aveOfAveS3BB = $this->getAveOfAve($ave,$loc1,$side);      
        $stdOfStdS3BB = $this->getStdOfStd($ave,$loc1,$side);
        $medianS3BB = $this->getMedian($ave,$loc1,$side);          
        $perc1S3BB = $this->getList4percentile($ave,$loc1,$side,0.00135);     
        $perc2S3BB = $this->getList4percentile($ave,$loc1,$side,0.99865);

        
        $zS3BB = ABS($this->divideByZeroExempt(($aveOfAveS3BB-$CL),$stdOfStdS3BB));
        $CpLS3BB = ABS($this->divideByZeroExempt(($aveOfAveS3BB-$LCL),(3*$stdOfStdS3BB) ));
        $CpUS3BB = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveS3BB),(3*$stdOfStdS3BB) ));      
        $arrValForCpkS3BB = array( $CpUS3BB,$CpLS3BB);  
        $CpkS3BB = min($arrValForCpkS3BB);
        $CpnUS3BB =$this->divideByZeroExempt(($USL - $medianS3BB ),( $perc2S3BB - $medianS3BB));
        $CpnLS3BB = $this->divideByZeroExempt(($medianS3BB  - $LSL),( $medianS3BB -  $perc1S3BB));
        $arrValForCpnS3BB = array( $CpnUS3BB,  $CpnLS3BB);         
        $CpnS3BB = min($arrValForCpnS3BB);

       
    

        return view('pages.stringerdataSum')
        ->with('dateRange',$this->getDateRangeForSPC())
        ->with('USL',$USL)
        ->with('LSL',$LSL)
        ->with('UCL',$UCL)
        ->with('LCL',$LCL)
        ->with('CL',$CL)
        ->with('target',$target)
///S1AF
    ->with('aveIndS1AF', $aveIndS1AF)
    ->with('stdIndS1AF', $stdIndS1AF)         
    ->with('aveOfAveS1AF', $aveOfAveS1AF)   
    ->with('stdOfStdS1AF', $stdOfStdS1AF)
    ->with('medianS1AF', $medianS1AF)
    ->with('perc1S1AF', $perc1S1AF)
    ->with('perc2S1AF', $perc2S1AF)    

    ->with('zS1AF',$zS1AF)
    ->with('CpUS1AF',$CpUS1AF)
    ->with('CpLS1AF',$CpLS1AF)
    ->with('CpkS1AF',$CpkS1AF)
    ->with('CpnS1AF',$CpnS1AF)
    ->with('CpnUS1AF',$CpnUS1AF)     
    ->with('CpnLS1AF',$CpnLS1AF)
//S1BF


->with('aveIndS1BF', $aveIndS1BF)
->with('stdIndS1BF', $stdIndS1BF)         
->with('aveOfAveS1BF', $aveOfAveS1BF)   
->with('stdOfStdS1BF', $stdOfStdS1BF)
->with('medianS1BF', $medianS1BF)
->with('perc1S1BF', $perc1S1BF)
->with('perc2S1BF', $perc2S1BF)    

->with('zS1BF',$zS1BF)
->with('CpUS1BF',$CpUS1BF)
->with('CpLS1BF',$CpLS1BF)
->with('CpkS1BF',$CpkS1BF)
->with('CpnS1BF',$CpnS1BF)
->with('CpnUS1BF',$CpnUS1BF)     
->with('CpnLS1BF',$CpnLS1BF)

//S1AB
    ->with('aveIndS1AB', $aveIndS1AB)
    ->with('stdIndS1AB', $stdIndS1AB)         
    ->with('aveOfAveS1AB', $aveOfAveS1AB)   
    ->with('stdOfStdS1AB', $stdOfStdS1AB)
    ->with('medianS1AB', $medianS1AB)
    ->with('perc1S1AB', $perc1S1AB)
    ->with('perc2S1AB', $perc2S1AB)    

  
    ->with('zS1AB',$zS1AB)
    ->with('CpUS1AB',$CpUS1AB)
    ->with('CpLS1AB',$CpLS1AB)
    ->with('CpkS1AB',$CpkS1AB)
    ->with('CpnS1AB',$CpnS1AB)
    ->with('CpnUS1AB',$CpnUS1AB)     
    ->with('CpnLS1AB',$CpnLS1AB)

    //S1BB
->with('aveIndS1BB', $aveIndS1BB)
->with('stdIndS1BB', $stdIndS1BB)         
->with('aveOfAveS1BB', $aveOfAveS1BB)   
->with('stdOfStdS1BB', $stdOfStdS1BB)
->with('medianS1BB', $medianS1BB)
->with('perc1S1BB', $perc1S1BB)
->with('perc2S1BB', $perc2S1BB)    


->with('zS1BB',$zS1BB)
->with('CpUS1BB',$CpUS1BB)
->with('CpLS1BB',$CpLS1BB)
->with('CpkS1BB',$CpkS1BB)
->with('CpnS1BB',$CpnS1BB)
->with('CpnUS1BB',$CpnUS1BB)     
->with('CpnLS1BB',$CpnLS1BB)

    ///S2AF
    ->with('aveIndS2AF', $aveIndS2AF)
    ->with('stdIndS2AF', $stdIndS2AF)         
    ->with('aveOfAveS2AF', $aveOfAveS2AF)   
    ->with('stdOfStdS2AF', $stdOfStdS2AF)
    ->with('medianS2AF', $medianS2AF)
    ->with('perc1S2AF', $perc1S2AF)
    ->with('perc2S2AF', $perc2S2AF)    

  
    ->with('zS2AF',$zS2AF)
    ->with('CpUS2AF',$CpUS2AF)
    ->with('CpLS2AF',$CpLS2AF)
    ->with('CpkS2AF',$CpkS2AF)
    ->with('CpnS2AF',$CpnS2AF)
    ->with('CpnUS2AF',$CpnUS2AF)     
    ->with('CpnLS2AF',$CpnLS2AF)


    //S2AB
    ->with('aveIndS2AB', $aveIndS2AB)
    ->with('stdIndS2AB', $stdIndS2AB)         
    ->with('aveOfAveS2AB', $aveOfAveS2AB)   
    ->with('stdOfStdS2AB', $stdOfStdS2AB)
    ->with('medianS2AB', $medianS2AB)
    ->with('perc1S2AB', $perc1S2AB)
    ->with('perc2S2AB', $perc2S2AB)    

  
    ->with('zS2AB',$zS2AB)
    ->with('CpUS2AB',$CpUS2AB)
    ->with('CpLS2AB',$CpLS2AB)
    ->with('CpkS2AB',$CpkS2AB)
    ->with('CpnS2AB',$CpnS2AB)
    ->with('CpnUS2AB',$CpnUS2AB)     
    ->with('CpnLS2AB',$CpnLS2AB)


    ///S2BF
    ->with('aveIndS2BF', $aveIndS2BF)
    ->with('stdIndS2BF', $stdIndS2BF)         
    ->with('aveOfAveS2BF', $aveOfAveS2BF)   
    ->with('stdOfStdS2BF', $stdOfStdS2BF)
    ->with('medianS2BF', $medianS2BF)
    ->with('perc1S2BF', $perc1S2BF)
    ->with('perc2S2BF', $perc2S2BF)    

  
    ->with('zS2BF',$zS2BF)
    ->with('CpUS2BF',$CpUS2BF)
    ->with('CpLS2BF',$CpLS2BF)
    ->with('CpkS2BF',$CpkS2BF)
    ->with('CpnS2BF',$CpnS2BF)
    ->with('CpnUS2BF',$CpnUS2BF)     
    ->with('CpnLS2BF',$CpnLS2BF)


    //S2BB
    ->with('aveIndS2BB', $aveIndS2BB)
    ->with('stdIndS2BB', $stdIndS2BB)         
    ->with('aveOfAveS2BB', $aveOfAveS2BB)   
    ->with('stdOfStdS2BB', $stdOfStdS2BB)
    ->with('medianS2BB', $medianS2BB)
    ->with('perc1S2BB', $perc1S2BB)
    ->with('perc2S2BB', $perc2S2BB)    

  
    ->with('zS2BB',$zS2BB)
    ->with('CpUS2BB',$CpUS2BB)
    ->with('CpLS2BB',$CpLS2BB)
    ->with('CpkS2BB',$CpkS2BB)
    ->with('CpnS2BB',$CpnS2BB)
    ->with('CpnUS2BB',$CpnUS2BB)     
    ->with('CpnLS2BB',$CpnLS2BB)


    ///S3AF
    ->with('aveIndS3AF', $aveIndS3AF)
    ->with('stdIndS3AF', $stdIndS3AF)         
    ->with('aveOfAveS3AF', $aveOfAveS3AF)   
    ->with('stdOfStdS3AF', $stdOfStdS3AF)
    ->with('medianS3AF', $medianS3AF)
    ->with('perc1S3AF', $perc1S3AF)
    ->with('perc2S3AF', $perc2S3AF)    

  
    ->with('zS3AF',$zS3AF)
    ->with('CpUS3AF',$CpUS3AF)
    ->with('CpLS3AF',$CpLS3AF)
    ->with('CpkS3AF',$CpkS3AF)
    ->with('CpnS3AF',$CpnS3AF)
    ->with('CpnUS3AF',$CpnUS3AF)     
    ->with('CpnLS3AF',$CpnLS3AF)

     ///S3AB
    ->with('aveIndS3AB', $aveIndS3AB)
    ->with('stdIndS3AB', $stdIndS3AB)         
    ->with('aveOfAveS3AB', $aveOfAveS3AB)   
    ->with('stdOfStdS3AB', $stdOfStdS3AB)
    ->with('medianS3AB', $medianS3AB)
    ->with('perc1S3AB', $perc1S3AB)
    ->with('perc2S3AB', $perc2S3AB)    

  
    ->with('zS3AB',$zS3AB)
    ->with('CpUS3AB',$CpUS3AB)
    ->with('CpLS3AB',$CpLS3AB)
    ->with('CpkS3AB',$CpkS3AB)
    ->with('CpnS3AB',$CpnS3AB)
    ->with('CpnUS3AB',$CpnUS3AB)     
    ->with('CpnLS3AB',$CpnLS3AB)
        

    

    ///S3BF
    ->with('aveIndS3BF', $aveIndS3BF)
    ->with('stdIndS3BF', $stdIndS3BF)         
    ->with('aveOfAveS3BF', $aveOfAveS3BF)   
    ->with('stdOfStdS3BF', $stdOfStdS3BF)
    ->with('medianS3BF', $medianS3BF)
    ->with('perc1S3BF', $perc1S3BF)
    ->with('perc2S3BF', $perc2S3BF)    

  
    ->with('zS3BF',$zS3BF)
    ->with('CpUS3BF',$CpUS3BF)
    ->with('CpLS3BF',$CpLS3BF)
    ->with('CpkS3BF',$CpkS3BF)
    ->with('CpnS3BF',$CpnS3BF)
    ->with('CpnUS3BF',$CpnUS3BF)     
    ->with('CpnLS3BF',$CpnLS3BF)

     ///S3BB
    ->with('aveIndS3BB', $aveIndS3BB)
    ->with('stdIndS3BB', $stdIndS3BB)         
    ->with('aveOfAveS3BB', $aveOfAveS3BB)   
    ->with('stdOfStdS3BB', $stdOfStdS3BB)
    ->with('medianS3BB', $medianS3BB)
    ->with('perc1S3BB', $perc1S3BB)
    ->with('perc2S3BB', $perc2S3BB)    

  
    ->with('zS3BB',$zS3BB)
    ->with('CpUS3BB',$CpUS3BB)
    ->with('CpLS3BB',$CpLS3BB)
    ->with('CpkS3BB',$CpkS3BB)
    ->with('CpnS3BB',$CpnS3BB)
    ->with('CpnUS3BB',$CpnUS3BB)     
    ->with('CpnLS3BB',$CpnLS3BB);
        
        
                 
   
        
    }
 
    public function create()
    {
        return view ('posts.Stringer');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->input('bb')=='4bb'){
      /*  $this->validate($request, [
            'Date' => 'required',
            'Stringer' => 'required',
            'Shift' => 'required',
            'Cell' => 'required',
            'Ribbon' => 'required',
            'Side' => 'required',
            'CellNo' => 'required',
            'PeeltestA' => 'required',
            
        ]); */
        //Create
       //instead n single value nging array value nito $request->input('PeeltestA');
       //sa example dun s web n nligay ko. magiging value nito ay [1,2,3,5]
        $peeltesta = $request->input('PeeltestA');
      //so pag pinost un ang value ng $peeltesta ay
      //$peeltesta[0] = 1
      //$peeltesta[1] = 2
      //$peeltesta[2] = 3
      //$peeltesta[3] = 5
        $peeltestb = $request->input('PeeltestB');
        $peeltestc = $request->input('PeeltestD');
        $peeltestd = $request->input('PeeltestD');
        $criteriaa = $request->input('CriteriaA');
        //$criteriaa[0] = 5
        //$criteriaa[1] = 4
        //$criteriaa[2] = 3
        //$criteriaa[3] = 2
        $criteriab = $request->input('CriteriaB');
        $criteriac = $request->input('CriteriaC');
        $criteriad = $request->input('CriteriaD');
        $remarksa = $request->input('RemarksA');
        $remarksb = $request->input('RemarksB');
        $remarksc = $request->input('RemarksC');
        $remarksd = $request->input('RemarksD');
        //loop $i 1 to 4 loop to pero start sa 0 to 3 kse para sa index
        //serve ng loop neto para kunin ung value per site.
        for($i = 0;$i<4;$i++){
            
            //loop $j for letter 
            //server ng loop neto para kunin ung value per letter A to D
            for($j=0;$j<4;$j++){
                $stringer = new Stringer();
                $stringer->Date = $request->input('Date');
                $stringer->Stringer = $request->input('Stringer');
                $stringer->Shift = $request->input('Shift');
                $stringer->Cell = $request->input('Cell');
                $stringer->Ribbon = $request->input('Ribbon');
                $stringer->Side = $request->input('Side');
                $stringer->CellNo = $request->input('CellNo');
                $stringer->BBNo = $request->input('bb');
                //check mo to $i+1
                //sample current value nya is 0 ... so 0+1 =1 un ung site number nya
                $stringer->Site = $i+1;
                //etong if n to is checking nnung value ng $j
                //sample j==0 ibig sbhin una sya so letterA kukunin mo
                if($j==0){
                    //Dto mkikita mo n A ung location, ungvariable n kinuha is $peeltesta
                    //kse nga A dapat ung iinsert
                    //tpos $i ung index kse para malaman kung anong site ng peeltestA
                    $stringer->Location = 'A';
                    $stringer->PeelTest = $peeltesta[$i];
                    $stringer->Criteria = $criteriaa[$i];
                    $stringer->Remarks = $remarksa[$i];
                }else if($j==1){
                    $stringer->Location = 'B';
                    $stringer->PeelTest = $peeltestb[$i];
                    $stringer->Criteria = $criteriab[$i];
                    $stringer->Remarks = $remarksb[$i];
                    
                }else if($j==2){
                    $stringer->Location = 'C';
                    $stringer->PeelTest = $peeltestc[$i];
                    $stringer->Criteria = $criteriac[$i];
                    $stringer->Remarks = $remarksc[$i];
                }else if($j==3){
                    $stringer->Location = 'D';
                    $stringer->PeelTest = $peeltestd[$i];
                    $stringer->Criteria = $criteriad[$i];
                    $stringer->Remarks = $remarksd[$i];
                }
                $stringer->save();
            }
            
        }
        
        return redirect('/stringer/create')->with('success', 'Successfully Created');

    }elseif($request->input('bb')=='5bb'){
           /*  $this->validate($request, [
            'Date' => 'required',
            'Stringer' => 'required',
            'Shift' => 'required',
            'Cell' => 'required',
            'Ribbon' => 'required',
            'Side' => 'required',
            'CellNo' => 'required',
            'PeeltestA' => 'required',
            
        ]); */
        //Create
       //instead n single value nging array value nito $request->input('PeeltestA');
       //sa example dun s web n nligay ko. magiging value nito ay [1,2,3,5]
       $peeltesta = $request->input('PeeltestA');
       //so pag pinost un ang value ng $peeltesta ay
       //$peeltesta[0] = 1
       //$peeltesta[1] = 2
       //$peeltesta[2] = 3
       //$peeltesta[3] = 5
         $peeltestb = $request->input('PeeltestB');
         $peeltestc = $request->input('PeeltestD');
         $peeltestd = $request->input('PeeltestD');
         $criteriaa = $request->input('CriteriaA');
         //$criteriaa[0] = 5
         //$criteriaa[1] = 4
         //$criteriaa[2] = 3
         //$criteriaa[3] = 2
         $criteriab = $request->input('CriteriaB');
         $criteriac = $request->input('CriteriaC');
         $criteriad = $request->input('CriteriaD');
         $remarksa = $request->input('RemarksA');
         $remarksb = $request->input('RemarksB');
         $remarksc = $request->input('RemarksC');
         $remarksd = $request->input('RemarksD');
         //loop $i 1 to 4 loop to pero start sa 0 to 3 kse para sa index
         //serve ng loop neto para kunin ung value per site.
         for($i = 0;$i<4;$i++){
             
             //loop $j for letter 
             //server ng loop neto para kunin ung value per letter A to D
             for($j=0;$j<4;$j++){
                 $stringer = new Stringer();
                 $stringer->Date = $request->input('Date');
                 $stringer->Stringer = $request->input('Stringer');
                 $stringer->Shift = $request->input('Shift');
                 $stringer->Cell = $request->input('Cell');
                 $stringer->Ribbon = $request->input('Ribbon');
                 $stringer->Side = $request->input('Side');
                 $stringer->CellNo = $request->input('CellNo');
                 $stringer->BBNo = $request->input('bb');
                 //check mo to $i+1
                 //sample current value nya is 0 ... so 0+1 =1 un ung site number nya
                 $stringer->Site = $i+1;
                 //etong if n to is checking nnung value ng $j
                 //sample j==0 ibig sbhin una sya so letterA kukunin mo
                 if($j==0){
                     //Dto mkikita mo n A ung location, ungvariable n kinuha is $peeltesta
                     //kse nga A dapat ung iinsert
                     //tpos $i ung index kse para malaman kung anong site ng peeltestA
                     $stringer->Location = 'A';
                     $stringer->PeelTest = $peeltesta[$i];
                     $stringer->Criteria = $criteriaa[$i];
                     $stringer->Remarks = $remarksa[$i];
                 }else if($j==1){
                     $stringer->Location = 'B';
                     $stringer->PeelTest = $peeltestb[$i];
                     $stringer->Criteria = $criteriab[$i];
                     $stringer->Remarks = $remarksb[$i];
                     
                 }else if($j==2){
                     $stringer->Location = 'C';
                     $stringer->PeelTest = $peeltestc[$i];
                     $stringer->Criteria = $criteriac[$i];
                     $stringer->Remarks = $remarksc[$i];
                 }else if($j==3){
                     $stringer->Location = 'D';
                     $stringer->PeelTest = $peeltestd[$i];
                     $stringer->Criteria = $criteriad[$i];
                     $stringer->Remarks = $remarksd[$i];
                 }
                 $stringer->save();
             }
             
         }
         
         return redirect('/stringer/create')->with('success', 'Successfully Created');
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


     
    public function getAveInd($ave,$str,$side)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."' ) as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->aveWt,6);
        return $wtAve;
    }
    public function getStdInd($ave,$str,$side)
    {
        $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(".$ave.") as StdWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."'   ) as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->StdWt,6);
        return $wtAve;
    }
    public function getAveOfAve($ave,$str,$side)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT Date,AVG(".$ave.") as aveWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."'   ) as tbl_ave GROUP BY Date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        return $wtAve;
    }
    public function getStdOfStd($ave,$str,$side)
    {
        $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT Date,AVG(".$ave.") as aveWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."'   ) as tbl_ave GROUP BY Date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
        return $wtAve;
    }
    public function getMedian($ave,$str,$side)
    {
        $median = DB::table(DB::select("SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."'   ) as tbl_ave GROUP BY Date ORDER BY aveWt ASC"));
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."'   ) as tbl_ave GROUP BY Date ORDER BY aveWt ASC) as tbl_medCnt"));

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
        $median = DB::table(DB::select("SELECT * FROM view_stringers"));
        $medianCount = DB::table(DB::select("SELECT COUNT(Date) as aveCount FROM view_stringers "));

        $medianCountVal = $medianCount->from[0]->aveCount;
       
        if($medianCountVal == 0){
            return "no data.";
        }else{
            $enddate = $median->from[0]->Date ;
            $startdate = $median->from[$medianCountVal-1]->Date ;
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
    public function getList4percentile($ave,$str,$side,$percentdec){
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."'   ) as tbl_ave GROUP BY Date ORDER BY aveWt ASC) as tbl_medCnt"));
        $wtAveList = DB::table(DB::select("SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM stringers WHERE Date IN (SELECT * FROM view_stringers) AND Stringer = '".$str."' AND Side = '".$side."'   ) as tbl_ave GROUP BY Date ORDER BY aveWt ASC"));
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
}
