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
        return \DataTables::of(DB::query('Select * FROM Stringers'))->make(true);
    }

    public function index()
    {
    
    // --------------STRINGER 1A---------------------------------//
        //AVE(IND) FRONT
        $avefront = number_format(DB::table('stringers')
        ->where([['Side','=','Front'],
                ['PeelTest','>',0],])
        ->avg('PeelTest'),2);
        //AVE(IND) BACK
        $aveback = number_format(DB::table('stringers')
        ->where([['side','=','Back'],
                ['PeelTest','>',0],])
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
        ->groupBy('date')
        ->get();
        $xbbfront = number_format($xbbfront->avg('PeelTest'),2);
         //XBB AVE OF AVE (BACK)
        $xbbback = DB::table('stringers')
        ->select(DB::raw('AVG(PeelTest) as PeelTest'))
        ->whereBetween('Date', [Date('Y-m-d',strtotime("-30 days")), Date('Y-m-d')])
        ->where([['Side','=','Back']])
        ->groupBy('date')
        ->get();
        $xbbback = number_format($xbbback->avg('PeelTest'),2);
        //STD AVE (FRONT)
        $stdavg = DB::table(DB::raw("(SELECT AVG(PeelTest) as PeelTest FROM stringers WHERE Side = 'Front' and Date BETWEEN '".Date('Y-m-d',strtotime("-30 days"))."' AND '".Date('Y-m-d')."' GROUP BY Date) as temp"))
        //date BETWEEN from AND to
        ->select(DB::raw('STDDEV(PeelTest) as PeelTest'))
        ->get();
        $stdavg = number_format($stdavg->avg('PeelTest'),2);
        //STD AVE (BACK)
        $stdavgback = DB::table(DB::raw("(SELECT AVG(PeelTest) as PeelTest FROM Stringers WHERE Side = 'Back' and Date BETWEEN '".Date('Y-m-d',strtotime("-30 days"))."' AND '".Date('Y-m-d')."' GROUP BY Date) as temp"))
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
        

        return view('pages.stringerdata')  
                    ->with('avefront',$avefront)
                    ->with('aveback',$aveback)
                    ->with('stdfront',$stdfront)
                    ->with('stdback',$stdback)
                    ->with('xbbfront',$xbbfront)
                    ->with('xbbback',$xbbback)
                    ->with('stdavg',$stdavg)
                    ->with('stdavgback',$stdavgback)
                    ->with('medianfront',$medianfront)
                    ->with('medianback',$medianback);
     // --------------END STRINGER 1A-----------------------------------------------------------------//
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $this->validate($request, [
            'Date' => 'required',
            'Stringer' => 'required',
            'Shift' => 'required',
            'Cell' => 'required',
            'Ribbon' => 'required',
            'Side' => 'required',
            'CellNo' => 'required',
            'PeeltestA' => 'required',

            
        ]);

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
