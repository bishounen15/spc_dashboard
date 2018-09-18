<?php

namespace App\Http\Controllers;
use App\parameter;
use DB;
use Illuminate\Http\Request;

class parameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $getall = DB::select("SELECT * FROM parameters ORDER BY subProcessName ASC"); 
       $getSubPro = DB::select("SELECT subProcessName FROM subprocess  ORDER BY subProcessName ASC");
       $getBom = DB::select("SELECT bomType FROM bomtype ORDER BY bomType ASC"); 
        $posts = \DB::connection()->getSchemaBuilder()->getColumnListing("parameters");
        
    // $settings = SomeModel::where($items_match)->get(); //Making use of Eloquent
    $arrAve = array();
    $arrField = array();
//  $settings = process::where($items_match)->get(); //Making use of Eloquent
   
    $columns = DB::connection()
                ->getDoctrineSchemaManager()
                ->listTableDetails("parameters");
foreach ( $posts as $key => $value) {
    array_push($arrAve,$columns->getColumn($value)->getComment());
}
              

                    
                
   
     return view('inc.targetCreateParam')
     ->with('alldata',$arrAve)
     ->with('getdata',$getall)
     ->with('getSubPro',$getSubPro)
     ->with('fields',$posts)
     ->with('bom',$getBom)
     ->with('tbl','SPC Chart Indicators')
     ->with('controller','parameterController@store');
        // dd($posts);          

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //$posts = \DB::connection()->getSchemaBuilder()->getColumnListing("process");
        $txt = $request->input('txt');
    
            $process = New parameter();
            $process->ProcessName = $txt[0];
            $process->ProcessDesc = $txt[1];
            $process->save();
       
      

      
        return redirect('/process/create')
        ->with('success', 'Successfully Created');
        
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
