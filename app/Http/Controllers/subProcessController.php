<?php

namespace App\Http\Controllers;
use App\subProcess;
use DB;
use Illuminate\Http\Request;

class subProcessController extends Controller
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
     
        $getall = DB::select("SELECT * FROM subprocess ORDER BY subProcessName ASC"); 
        $getBom = DB::select("SELECT ProcessName FROM process ORDER BY ProcessName ASC"); 
        $posts = \DB::connection()->getSchemaBuilder()->getColumnListing("subprocess");
        
    // $settings = SomeModel::where($items_match)->get(); //Making use of Eloquent
    $arrAve = array();
    $arrField = array();
//  $settings = process::where($items_match)->get(); //Making use of Eloquent
   
    $columns = DB::connection()
                ->getDoctrineSchemaManager()
                ->listTableDetails("subprocess");
foreach ( $posts as $key => $value) {
    array_push($arrAve,$columns->getColumn($value)->getComment());
}
              

                    
                
   
            
           
         //   dd($arrAve);
     return view('inc.targetCreateSelect')
     ->with('alldata',$arrAve)
     ->with('getdata',$getall)
     ->with('getbom',$getBom)
     ->with('selectVal','Process Name')
     ->with('selectVal2','ProcessName')
     ->with('fields',$posts)
     ->with('tbl','Critical Nodes')
     ->with('controllerUp','subProcessController@update')
     ->with('controllerDel','subProcessController@destroy')
     ->with('controller','subProcessController@store');
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
    
            $process = New subProcess();
            $process->subProcessName = $txt[0];
            $process->subProcessDesc = $txt[1];
            $process->ProcessName = $request->input('bom');
            $process->save();
       
      

      
        return redirect('/subprocess/create')
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
    
        $process = subProcess::find($id);
       // $process->subProcessName = $txt[0];
        $process->subProcessDesc = $txt[1];
        $process->ProcessName = $request->input('bom');
        $process->save();
   
  

  
    return redirect('/subprocess/create')
    ->with('success', 'Successfully Created');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = subProcess::find($id);
        $post->delete();
        return redirect('/subprocess/create')
        ->with('success', 'Successfully Deleted');
    }
}
