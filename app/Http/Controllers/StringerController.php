<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stringer;
use DB;

class StringerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avefront = number_format(DB::table('stringers')->where('side','=','Front')->avg('PeelTest'),2);
        $aveback = number_format(DB::table('stringers')->where('side','=','Back')->avg('PeelTest'),2); 
        //$posts = Post::orderBy('created_at','desc')->paginate(2);
        return view('pages.stringerdata')  
                    ->with('avefront',$avefront)
                    ->with('aveback',$aveback);

        
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
