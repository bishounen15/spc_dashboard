<?php

namespace App\Http\Controllers;
use App\productType;
use DB;

use Illuminate\Http\Request;

class productTypeController extends Controller
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
     
        $getall = DB::select("SELECT * FROM producttype ORDER BY prodName ASC"); 
        $getBom = DB::select("SELECT bomType FROM bomtype ORDER BY bomType ASC"); 
        $posts = \DB::connection()->getSchemaBuilder()->getColumnListing("producttype");
        
    // $settings = SomeModel::where($items_match)->get(); //Making use of Eloquent
    $arrAve = array();
    $arrField = array();
//  $settings = process::where($items_match)->get(); //Making use of Eloquent
   
    $columns = DB::connection()
                ->getDoctrineSchemaManager()
                ->listTableDetails("producttype");
foreach ( $posts as $key => $value) {
    array_push($arrAve,$columns->getColumn($value)->getComment());
}
              

                    
                
   
            
           
         //   dd($arrAve);
     return view('inc.targetCreateSelect')
     ->with('alldata',$arrAve)
     ->with('getdata',$getall)
     ->with('getbom',$getBom)
     ->with('selectVal','BOM Type')
     ->with('selectVal2','bomType')
     ->with('fields',$posts)
     ->with('tbl','Product Type')
     ->with('controller','productTypeController@store');
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
    
            $process = New productType();
            $process->prodName = $txt[0];
            $process->docBomNo = $txt[1];
            $process->bomType = $request->input('bom');
            $process->save();
       
      

      
        return redirect('/product/create')
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
