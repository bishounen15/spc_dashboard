<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BOMtype;
use DB;

class BOMtypeController extends Controller
{
   
   
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
     
        $getall = DB::select("SELECT * FROM bomtype ORDER BY bomType ASC"); 
        $posts = \DB::connection()->getSchemaBuilder()->getColumnListing("bomtype");
        
    // $settings = SomeModel::where($items_match)->get(); //Making use of Eloquent
    $arrAve = array();
    $arrField = array();
//  $settings = process::where($items_match)->get(); //Making use of Eloquent
   
    $columns = DB::connection()
                ->getDoctrineSchemaManager()
                ->listTableDetails("bomtype");
foreach ( $posts as $key => $value) {
    array_push($arrAve,$columns->getColumn($value)->getComment());
}
              

                    
                
   
            
           
         //   dd($arrAve);
     return view('inc.targetCreate')
     ->with('alldata',$arrAve)
     ->with('getdata',$getall)
     ->with('fields',$posts)
     ->with('tbl','Bom Type')
     ->with('controller','BOMtypeController@store');
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
    
            $process = New BOMtype();
            $process->bomType = $txt[0];
            $process->bomDesc = $txt[1];
            $process->save();
       
      

      
        return redirect('/bom/create')
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
