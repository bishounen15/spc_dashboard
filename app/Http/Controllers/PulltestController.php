<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pulltest;
use DB;

class PulltestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //eto kapagwala kang nilagay kundi /pulltestdata lang
    //Dito showing ng lahat ng list
    public function index()
    {
       
        $USL = 0;
        $LSL = 0.6;
        $target = 0;
        $UCL=0;
        $LCL=0;
        $CL = (($UCL-$LCL)/2)+$LCL;

     

        
        $ave = "PTEBA";  
        $aveIndLXM = $this->getAveInd($ave,"Laminator 1");
        $stdIndLXM = $this->getStdInd($ave,"Laminator 1");      
        $aveOfAveLXM = $this->getAveOfAve($ave,"Laminator 1");      
        $stdOfStdLXM = $this->getStdOfStd($ave,"Laminator 1");
        $medianLXM = $this->getMedian($ave,"Laminator 1");          
        $perc1LXM = $this->getList4percentile($ave,"Laminator 1",0.00135);     
        $perc2LXM = $this->getList4percentile($ave,"Laminator 1",0.99865);

        
        $zLXM = ABS($this->divideByZeroExempt(($aveOfAveLXM-$CL),$stdOfStdLXM));
        $CpLLXM = ABS($this->divideByZeroExempt(($aveOfAveLXM-$LCL),(3*$stdOfStdLXM) ));
        $CpULXM = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveLXM),(3*$stdOfStdLXM) ));      
        $arrValForCpkLXM = array( $CpULXM,$CpLLXM);  
        $CpkLXM = min($arrValForCpkLXM);
        $CpnULXM =$this->divideByZeroExempt(($USL - $medianLXM ),( $perc2LXM - $medianLXM));
        $CpnLLXM = $this->divideByZeroExempt(($medianLXM  - $LSL),( $medianLXM -  $perc1LXM));
        $arrValForCpnLXM = array( $CpnULXM,  $CpnLLXM);         
        $CpnLXM = min($arrValForCpnLXM);


       
        $ave2 =   "PTEGA";
        $aveIndRelGel = $this->getAveInd($ave2,"Laminator 1");
        $stdIndRelGel = $this->getStdInd($ave2,"Laminator 1");      
        $aveOfAveRelGel = $this->getAveOfAve($ave2,"Laminator 1");      
        $stdOfStdRelGel = $this->getStdOfStd($ave2,"Laminator 1");
        $medianRelGel = $this->getMedian($ave2,"Laminator 1");          
        $perc1RelGel = $this->getList4percentile($ave2,"Laminator 1",0.00135);     
        $perc2RelGel = $this->getList4percentile($ave2,"Laminator 1",0.99865);

        $zRelGel = ABS($this->divideByZeroExempt(($aveOfAveRelGel-$CL),$stdOfStdRelGel));
        $CpLRelGel = ABS($this->divideByZeroExempt(($aveOfAveRelGel-$LCL),(3*$stdOfStdRelGel) ));
        $CpURelGel = ABS( $this->divideByZeroExempt(($UCL-$aveOfAveRelGel),(3*$stdOfStdRelGel) ));      
        $arrValForCpkRG = array( $CpURelGel,$CpLRelGel);  
        $CpkRG = min($arrValForCpkRG);
        $CpnURG =$this->divideByZeroExempt(($USL - $medianRelGel ),( $perc2RelGel - $medianRelGel));
        $CpnLRG = $this->divideByZeroExempt(($medianRelGel  - $LSL),( $medianRelGel -  $perc1RelGel));
        $arrValForCpnRG = array( $CpnURG,  $CpnLRG);         
        $CpnRG = min($arrValForCpnRG);



        $L2ave =  "PTEBA";       
        $L2aveIndLXM = $this->getAveInd($L2ave,"Laminator 2");
        $L2stdIndLXM = $this->getStdInd($L2ave,"Laminator 2");      
        $L2aveOfAveLXM = $this->getAveOfAve($L2ave,"Laminator 2");      
        $L2stdOfStdLXM = $this->getStdOfStd($L2ave,"Laminator 2");
        $L2medianLXM = $this->getMedian($L2ave,"Laminator 2");          
        $L2perc1LXM = $this->getList4percentile($L2ave,"Laminator 2",0.00135);     
        $L2perc2LXM = $this->getList4percentile($L2ave,"Laminator 2",0.99865);

        
        $L2zLXM = ABS($this->divideByZeroExempt(($L2aveOfAveLXM-$CL),$L2stdOfStdLXM));
        $L2CpLLXM = ABS($this->divideByZeroExempt(($L2aveOfAveLXM-$LCL),(3*$L2stdOfStdLXM) ));
        $L2CpULXM = ABS( $this->divideByZeroExempt(($UCL-$L2aveOfAveLXM),(3*$L2stdOfStdLXM) ));      
        $L2arrValForCpkLXM = array( $L2CpULXM,$L2CpLLXM);  
        $L2CpkLXM = min($L2arrValForCpkLXM);
        $L2CpnULXM =$this->divideByZeroExempt(($USL - $L2medianLXM ),( $L2perc2LXM - $L2medianLXM));
        $L2CpnLLXM = $this->divideByZeroExempt(($L2medianLXM  - $LSL),( $L2medianLXM -  $L2perc1LXM));
        $L2arrValForCpnLXM = array( $L2CpnULXM,  $L2CpnLLXM);         
        $L2CpnLXM = min($L2arrValForCpnLXM);


            
        $L2ave2 =  "PTEGA";
        $L2aveIndRelGel = $this->getAveInd($L2ave2,"Laminator 2");
        $L2stdIndRelGel = $this->getStdInd($L2ave2,"Laminator 2");      
        $L2aveOfAveRelGel = $this->getAveOfAve($L2ave2,"Laminator 2");      
        $L2stdOfStdRelGel = $this->getStdOfStd($L2ave2,"Laminator 2");
        $L2medianRelGel = $this->getMedian($L2ave2,"Laminator 2");          
        $L2perc1RelGel = $this->getList4percentile($L2ave2,"Laminator 2",0.00135);     
        $L2perc2RelGel = $this->getList4percentile($L2ave2,"Laminator 2",0.99865);

        $L2zRelGel = ABS($this->divideByZeroExempt(($L2aveOfAveRelGel-$CL),$L2stdOfStdRelGel));
        $L2CpLRelGel = ABS($this->divideByZeroExempt(($L2aveOfAveRelGel-$LCL),(3*$L2stdOfStdRelGel) ));
        $L2CpURelGel = ABS( $this->divideByZeroExempt(($UCL-$L2aveOfAveRelGel),(3*$L2stdOfStdRelGel) ));      
        $L2arrValForCpkRG = array( $L2CpURelGel,$L2CpLRelGel);  
        $L2CpkRG = min($L2arrValForCpkRG);
        $L2CpnURG =$this->divideByZeroExempt(($USL - $L2medianRelGel ),( $L2perc2RelGel - $L2medianRelGel));
        $L2CpnLRG = $this->divideByZeroExempt(($L2medianRelGel  - $LSL),( $L2medianRelGel -  $L2perc1RelGel));
        $L2arrValForCpnRG = array( $L2CpnURG,  $L2CpnLRG);         
        $L2CpnRG = min($L2arrValForCpnRG);


        //LAM 3

        $L3ave ="PTEBA";  
        $L3aveIndLXM = $this->getAveInd($L3ave,"Laminator 3");
        $L3stdIndLXM = $this->getStdInd($L3ave,"Laminator 3");      
        $L3aveOfAveLXM = $this->getAveOfAve($L3ave,"Laminator 3");      
        $L3stdOfStdLXM = $this->getStdOfStd($L3ave,"Laminator 3");
        $L3medianLXM = $this->getMedian($L3ave,"Laminator 3");          
        $L3perc1LXM = $this->getList4percentile($L3ave,"Laminator 3",0.00135);     
        $L3perc2LXM = $this->getList4percentile($L3ave,"Laminator 3",0.99865);

        
        $L3zLXM = ABS($this->divideByZeroExempt(($L3aveOfAveLXM-$CL),$L3stdOfStdLXM));
        $L3CpLLXM = ABS($this->divideByZeroExempt(($L3aveOfAveLXM-$LCL),(3*$L3stdOfStdLXM) ));
        $L3CpULXM = ABS( $this->divideByZeroExempt(($UCL-$L3aveOfAveLXM),(3*$L3stdOfStdLXM) ));      
        $L3arrValForCpkLXM = array( $L3CpULXM,$L3CpLLXM);  
        $L3CpkLXM = min($L3arrValForCpkLXM);
        $L3CpnULXM =$this->divideByZeroExempt(($USL - $L3medianLXM ),( $L3perc2LXM - $L3medianLXM));
        $L3CpnLLXM = $this->divideByZeroExempt(($L3medianLXM  - $LSL),( $L3medianLXM -  $L3perc1LXM));
        $L3arrValForCpnLXM = array( $L3CpnULXM,  $L3CpnLLXM);         
        $L3CpnLXM = min($L3arrValForCpnLXM);


            
        $L3ave2 = "PTEGA";
        $L3aveIndRelGel = $this->getAveInd($L3ave2,"Laminator 3");
        $L3stdIndRelGel = $this->getStdInd($L3ave2,"Laminator 3");      
        $L3aveOfAveRelGel = $this->getAveOfAve($L3ave2,"Laminator 3");      
        $L3stdOfStdRelGel = $this->getStdOfStd($L3ave2,"Laminator 3");
        $L3medianRelGel = $this->getMedian($L3ave2,"Laminator 3");          
        $L3perc1RelGel = $this->getList4percentile($L3ave2,"Laminator 3",0.00135);     
        $L3perc2RelGel = $this->getList4percentile($L3ave2,"Laminator 3",0.99865);

        $L3zRelGel = ABS($this->divideByZeroExempt(($L3aveOfAveRelGel-$CL),$L3stdOfStdRelGel));
        $L3CpLRelGel = ABS($this->divideByZeroExempt(($L3aveOfAveRelGel-$LCL),(3*$L3stdOfStdRelGel) ));
        $L3CpURelGel = ABS( $this->divideByZeroExempt(($UCL-$L3aveOfAveRelGel),(3*$L3stdOfStdRelGel) ));      
        $L3arrValForCpkRG = array( $L3CpURelGel,$L3CpLRelGel);  
        $L3CpkRG = min($L3arrValForCpkRG);
        $L3CpnURG =$this->divideByZeroExempt(($USL - $L3medianRelGel ),( $L3perc2RelGel - $L3medianRelGel));
        $L3CpnLRG = $this->divideByZeroExempt(($L3medianRelGel  - $LSL),( $L3medianRelGel -  $L3perc1RelGel));
        $L3arrValForCpnRG = array( $L3CpnURG,  $L3CpnLRG);         
        $L3CpnRG = min($L3arrValForCpnRG);


    
       
        return view('pages.pulltestdataSum') 

        ->with('dateRange',$this->getDateRangeForSPC())
        //  ->with('productBuilt',$prod)
          ->with('USL',$USL)
          ->with('LSL',$LSL)
          ->with('UCL',$UCL)
          ->with('LCL',$LCL)
          ->with('CL',$CL)
          ->with('target',$target)

      ->with('aveIndLXM', $aveIndLXM)
      ->with('stdIndLXM', $stdIndLXM)         
      ->with('aveOfAveLXM', $aveOfAveLXM)   
      ->with('stdOfStdLXM', $stdOfStdLXM)
      ->with('medianLXM', $medianLXM)
      ->with('perc1LXM', $perc1LXM)
      ->with('perc2LXM', $perc2LXM)    

      ->with('aveIndRG', $aveIndRelGel)
      ->with('stdIndRG', $stdIndRelGel)         
      ->with('aveOfAveRG', $aveOfAveRelGel)   
      ->with('stdOfStdRG', $stdOfStdRelGel)
      ->with('medianRG', $medianRelGel)
      ->with('perc1RG', $perc1RelGel)
      ->with('perc2RG', $perc2RelGel)    
    
      ->with('zLXM',$zLXM)
      ->with('CpULXM',$CpULXM)
      ->with('CpLLXM',$CpLLXM)
      ->with('CpkLXM',$CpkLXM)
      ->with('CpnLXM',$CpnLXM)
      ->with('CpnULXM',$CpnULXM)     
      ->with('CpnLLXM',$CpnLLXM)

      ->with('zRelGel',$zRelGel)
      ->with('CpURG',$CpURelGel)
      ->with('CpLRG',$CpLRelGel)
      ->with('CpkRG',$CpkRG)
      ->with('CpnRG',$CpnRG)
      ->with('CpnURG',$CpnURG)     
      ->with('CpnLRG',$CpnLRG)

//L2
      ->with('L2aveIndLXM', $L2aveIndLXM)
      ->with('L2stdIndLXM', $L2stdIndLXM)         
      ->with('L2aveOfAveLXM', $L2aveOfAveLXM)   
      ->with('L2stdOfStdLXM', $L2stdOfStdLXM)
      ->with('L2medianLXM', $L2medianLXM)
      ->with('L2perc1LXM', $L2perc1LXM)
      ->with('L2perc2LXM', $L2perc2LXM)    

      ->with('L2aveIndRG', $L2aveIndRelGel)
      ->with('L2stdIndRG', $L2stdIndRelGel)         
      ->with('L2aveOfAveRG', $L2aveOfAveRelGel)   
      ->with('L2stdOfStdRG', $L2stdOfStdRelGel)
      ->with('L2medianRG', $L2medianRelGel)
      ->with('L2perc1RG', $L2perc1RelGel)
      ->with('L2perc2RG', $L2perc2RelGel)    
    
      ->with('L2zLXM',$L2zLXM)
      ->with('L2CpULXM',$L2CpULXM)
      ->with('L2CpLLXM',$L2CpLLXM)
      ->with('L2CpkLXM',$L2CpkLXM)
      ->with('L2CpnLXM',$L2CpnLXM)
      ->with('L2CpnULXM',$L2CpnULXM)     
      ->with('L2CpnLLXM',$L2CpnLLXM)

      ->with('L2zRelGel',$L2zRelGel)
      ->with('L2CpURG',$L2CpURelGel)
      ->with('L2CpLRG',$L2CpLRelGel)
      ->with('L2CpkRG',$L2CpkRG)
      ->with('L2CpnRG',$L2CpnRG)
      ->with('L2CpnURG',$L2CpnURG)     
      ->with('L2CpnLRG',$L2CpnLRG)

//L3
->with('L3aveIndLXM', $L3aveIndLXM)
->with('L3stdIndLXM', $L3stdIndLXM)         
->with('L3aveOfAveLXM', $L3aveOfAveLXM)   
->with('L3stdOfStdLXM', $L3stdOfStdLXM)
->with('L3medianLXM', $L3medianLXM)
->with('L3perc1LXM', $L3perc1LXM)
->with('L3perc2LXM', $L3perc2LXM)    

->with('L3aveIndRG', $L3aveIndRelGel)
->with('L3stdIndRG', $L3stdIndRelGel)         
->with('L3aveOfAveRG', $L3aveOfAveRelGel)   
->with('L3stdOfStdRG', $L3stdOfStdRelGel)
->with('L3medianRG', $L3medianRelGel)
->with('L3perc1RG', $L3perc1RelGel)
->with('L3perc2RG', $L3perc2RelGel)    

->with('L3zLXM',$L3zLXM)
->with('L3CpULXM',$L3CpULXM)
->with('L3CpLLXM',$L3CpLLXM)
->with('L3CpkLXM',$L3CpkLXM)
->with('L3CpnLXM',$L3CpnLXM)
->with('L3CpnULXM',$L3CpnULXM)     
->with('L3CpnLLXM',$L3CpnLLXM)

->with('L3zRelGel',$L3zRelGel)
->with('L3CpURG',$L3CpURelGel)
->with('L3CpLRG',$L3CpLRelGel)
->with('L3CpkRG',$L3CpkRG)
->with('L3CpnRG',$L3CpnRG)
->with('L3CpnURG',$L3CpnURG)     
->with('L3CpnLRG',$L3CpnLRG);   
      


        //$posts = Post::orderBy('created_at','desc')->paginate(2);
      
                    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //eto kapag /pulltestdata/create
    //Dito ang create form.
    public function create()
    {
       
        return view('posts.pulltest') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Dito mo isusubmit ung post mo sa form n gnawa mo sa create
    //PulltestController@store ung papasahan
    public function store(Request $request)
    {
        $this->validate($request, [
            'Date' => 'required',
            'Laminator' => 'required',
            'Shift' => 'required',
            'Recipe' => 'required|alpha_num|max:25',
            'Glass' => 'required|alpha_num|max:25',
            'EVA' => 'required',
            'Backsheet' => 'required|alpha_num|max:25',
            'Location' => 'required|alpha_num|max:25',
            'PTEG1' => 'required|not_in:0|numeric',
            'PTEG2' => 'required|not_in:0|numeric',
            'PTEG3' => 'required|not_in:0|numeric',
            'PTEG4' => 'required|not_in:0|numeric',
            'PTEG5' => 'required|not_in:0|numeric',
            'PTEG6' => 'required|not_in:0|numeric',
            'PTEG7' => 'required|not_in:0|numeric',
            'PTEG8' => 'required|not_in:0|numeric',
            'PTEG9' => 'required|not_in:0|numeric',
            'PTEG11' => 'required|not_in:0|numeric',
            'PTEG12' => 'required|not_in:0|numeric',
            'PTEG13' => 'required|not_in:0|numeric',
            'PTEG14' => 'required|not_in:0|numeric',
            'PTEG15' => 'required|not_in:0|numeric',
            'PTEGA' => 'required',
            'PTEB1' => 'required|not_in:0|numeric',
            'PTEB2' => 'required|not_in:0|numeric',
            'PTEB3' => 'required|not_in:0|numeric',
            'PTEB4' => 'required|not_in:0|numeric',
            'PTEB5' => 'required|not_in:0|numeric',
            'PTEB6' => 'required|not_in:0|numeric',
            'PTEB7' => 'required|not_in:0|numeric',
            'PTEB8' => 'required|not_in:0|numeric',
            'PTEB9' => 'required|not_in:0|numeric',
            'PTEB10' => 'required|not_in:0|numeric',
            'PTEB11' => 'required|not_in:0|numeric',
            'PTEB12' => 'required|not_in:0|numeric',
            'PTEB13' => 'required|not_in:0|numeric',
            'PTEB14' => 'required|not_in:0|numeric',
            'PTEB15' => 'required|not_in:0|numeric',
            'PTEBA' => 'required',
        ]);

        //Create
        $pulltest = new Pulltest();
        $pulltest->Date = $request->input('Date');
        $pulltest->Laminator = $request->input('Laminator');
        $pulltest->Shift = $request->input('Shift');
        $pulltest->Recipe = $request->input('Recipe');
        $pulltest->Glass = $request->input('Glass');
        $pulltest->EVA = $request->input('EVA');
        $pulltest->Backsheet = $request->input('Backsheet');
        $pulltest->Location = $request->input('Location');
        $pulltest->PTEG1 = $request->input('PTEG1');
        $pulltest->PTEG2 = $request->input('PTEG2');
        $pulltest->PTEG3 = $request->input('PTEG3');
        $pulltest->PTEG4 = $request->input('PTEG4');
        $pulltest->PTEG5 = $request->input('PTEG5');
        $pulltest->PTEG6 = $request->input('PTEG6');
        $pulltest->PTEG7 = $request->input('PTEG7');
        $pulltest->PTEG8 = $request->input('PTEG8');
        $pulltest->PTEG9 = $request->input('PTEG9');    
        $pulltest->PTEG10 = $request->input('PTEG10');
        $pulltest->PTEG11 = $request->input('PTEG11');
        $pulltest->PTEG12 = $request->input('PTEG12');
        $pulltest->PTEG13 = $request->input('PTEG13');
        $pulltest->PTEG14 = $request->input('PTEG14');
        $pulltest->PTEG15 = $request->input('PTEG15');
        $pulltest->PTEGA = $request->input('PTEGA');
        $pulltest->PTEB1 = $request->input('PTEB1');
        $pulltest->PTEB2 = $request->input('PTEB2');
        $pulltest->PTEB3 = $request->input('PTEB3');
        $pulltest->PTEB4 = $request->input('PTEB4');
        $pulltest->PTEB5 = $request->input('PTEB5');
        $pulltest->PTEB6 = $request->input('PTEB6');
        $pulltest->PTEB7 = $request->input('PTEB7');
        $pulltest->PTEB8 = $request->input('PTEB8');
        $pulltest->PTEB9 = $request->input('PTEB9');
        $pulltest->PTEB10 = $request->input('PTEB10');
        $pulltest->PTEB11 = $request->input('PTEB11');
        $pulltest->PTEB12 = $request->input('PTEB12');
        $pulltest->PTEB13 = $request->input('PTEB13');
        $pulltest->PTEB14 = $request->input('PTEB14');
        $pulltest->PTEB15 = $request->input('PTEB15');
        $pulltest->PTEBA = $request->input('PTEBA');
        $pulltest->save();
        return redirect('/pulltest_view')->with('success', 'Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Dito kapag individual showing
    //for example ung unang item need mo iview ung details.
    //kaya sya may $id.
    public function show($id)
    {
        //Pre eto syntax nyan Model::where('anongcolumn ung gagamitin mo s where','= or like or between basta eto ung operand','tpos ung value nahahanapin mo')
        //$variable = Model::where('column','=','value')
        //->get();
        //sample
        //$employeenapogi = Employee::where('name','LIKE','%Jhay%')->get();

        //sample ng OR statement
        //$employeenapogi = Employee::where('name','LIKE','%Jhay%')
        //->orWhere('name','LIKE','%Jerremy%')
        //->get();

        //sample ng AND statement
        //$employeenapogi = Employee::where('name','LIKE','%Jhay%')
        //->where('name','LIKE','%Jerremy%')
        //->get();  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Dito kapag edit nmn. parang create+show form. kse maguupdate k ng info
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
    //Dito mo ipopost ung gnawa mo sa edit.
    //PulltestController@update ung action
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

     //Dito kung delete
    public function destroy($id)
    {
        //
    }

    
    public function getAveInd($ave,$lam)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."' ) as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->aveWt,6);
        return $wtAve;
    }
    public function getStdInd($ave,$lam)
    {
        $weightAve = DB::table(DB::select("SELECT  STDDEV_SAMP(".$ave.") as StdWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."'   ) as tbl_ave"));
        $wtAve = number_format($weightAve->from[0]->StdWt,6);
        return $wtAve;
    }
    public function getAveOfAve($ave,$lam)
    {
        $weightAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM(SELECT date,AVG(".$ave.") as aveWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."'   ) as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->aveOfAve,6);
        return $wtAve;
    }
    public function getStdOfStd($ave,$lam)
    {
        $weightAve = DB::table(DB::select("SELECT STDDEV_SAMP(aveWt) as stdOfStd FROM(SELECT date,AVG(".$ave.") as aveWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."'   ) as tbl_ave GROUP BY date) as tbl_aveOfave"));
        $wtAve = number_format($weightAve->from[0]->stdOfStd,6);
        return $wtAve;
    }
    public function getMedian($ave,$lam)
    {
        $median = DB::table(DB::select("SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."'   ) as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."'   ) as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));

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
        $median = DB::table(DB::select("SELECT * FROM view_pulltests"));
        $medianCount = DB::table(DB::select("SELECT COUNT(date) as aveCount FROM view_pulltests "));

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
    public function getList4percentile($ave,$lam,$percentdec){
        $medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM(SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."'   ) as tbl_ave GROUP BY date ORDER BY aveWt ASC) as tbl_medCnt"));
        $wtAveList = DB::table(DB::select("SELECT AVG(".$ave.") as aveWt FROM (SELECT * FROM pull_tests WHERE date IN (SELECT * FROM view_pulltests) AND Laminator = '".$lam."'   ) as tbl_ave GROUP BY date ORDER BY aveWt ASC"));
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
