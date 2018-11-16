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
 
    $arrField = array();
//  $settings = process::where($items_match)->get(); //Making use of Eloquent
$posts = \DB::connection()->getSchemaBuilder()->getColumnListing("parameters"); 
 $arrAve = array();
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
     ->with('getbom',$getBom)
     ->with('tbl','SPC Chart Indicator Specs ')
     ->with('controllerUp','parameterController@update')
     ->with('controllerDel','parameterController@destroy')
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
            $process->paramID = "0";
            $process->UOM = $txt[0];
            $process->targetVal = $txt[1];
            $process->ULVal = $txt[2];
            $process->LLVal = $txt[3];
            $process->CL = $txt[4];
            $process->UCL = $txt[5];
            $process->LCL = $txt[6];
            $process->frameType = $request->input('frameType');
            $process->BOMType = $request->input('bom');
            $process->subProcessName = $request->input('subPro');
            $process->cellType = $request->input('cellType');
            $process->sealantType = $request->input('sealantType');
            $process->JBOXType = $request->input('jboxType');
            $process->BBno = $request->input('bbno');
            $process->save();
       
      

      
        return redirect('/parameter/create')
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
    
            $process = parameter::find($id);
            $process->paramID = "0";
            $process->UOM = $txt[0];
            $process->targetVal = $txt[1];
            $process->ULVal = $txt[2];
            $process->LLVal = $txt[3];
            $process->CL = $txt[4];
            $process->UCL = $txt[5];
            $process->LCL = $txt[6];
            $process->frameType = $request->input('frameType');
            $process->BOMType = $request->input('bom');
            $process->subProcessName = $request->input('subPro');
            $process->cellType = $request->input('cellType');
            $process->sealantType = $request->input('sealantType');
            $process->JBOXType = $request->input('jboxType');
            $process->BBno = $request->input('bbno');
            $process->save();
       
      

      
        return redirect('/parameter/create')
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
        $post = parameter::find($id);
        $post->delete();
        return redirect('/parameter/create')
        ->with('success', 'Successfully Deleted');
    }

}
