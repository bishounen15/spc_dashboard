<?php

namespace App\Http\Controllers;
use App\flashsetup;
use DB;
use Illuminate\Http\Request;

class flashsetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getall = DB::select("SELECT * FROM flashsetup ORDER BY id ASC"); 
         $getBom = DB::select("SELECT * FROM producttype ORDER BY prodName ASC"); 
         $posts = \DB::connection()->getSchemaBuilder()->getColumnListing("flashsetup");
         
     // $settings = SomeModel::where($items_match)->get(); //Making use of Eloquent
     $arrAve = array();
     $arrField = array();
 //  $settings = process::where($items_match)->get(); //Making use of Eloquent
    
     $columns = DB::connection()
                 ->getDoctrineSchemaManager()
                 ->listTableDetails("flashsetup");
 foreach ( $posts as $key => $value) {
     array_push($arrAve,$columns->getColumn($value)->getComment());
 }
               
 
                     
             
      return view('inc.targetCreateSelect')
      ->with('alldata',$arrAve)
      ->with('getdata',$getall)
      ->with('getbom',$getBom)
      ->with('selectVal','Product/Module Type')
      ->with('selectVal2','prodName')
      ->with('fields',$posts)
      ->with('tbl','Flash test Target Cal')
      ->with('controllerUp','flashsetupController@update')
      ->with('controllerDel','flashsetupController@destroy')
      ->with('controller','flashsetupController@store');
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
        $txt = $request->input('txt');
    
        $process = New flashsetup();
        $process->SNno = $txt[0];
        $process->Pmpp = $txt[1];
        $process->Vmpp = $txt[2];
        $process->Voc = $txt[3];
        $process->Impp = $txt[4];
        $process->Isc = $txt[5];
        $process->FF = $txt[6];
        $process->ProductType = $request->input('bom');
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
        $txt = $request->input('txt');
    
        $process = flashsetup::find($id);
        $process->SNno = $txt[0];
        $process->Pmpp = $txt[1];
        $process->Vmpp = $txt[2];
        $process->Voc = $txt[3];
        $process->Impp = $txt[4];
        $process->Isc = $txt[5];
        $process->FF = $txt[6];
        $process->ProductType = $request->input('bom');
        $process->save();
   
  

  
    return redirect('/product/create')
    ->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = flashsetup::find($id);
        $post->delete();
        return redirect('/product/create')
        ->with('success', 'Successfully Deleted');
    }
}
