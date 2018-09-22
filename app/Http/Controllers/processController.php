<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\process;
use DB;


class processController extends Controller
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
     
        $getall = DB::select("SELECT * FROM process ORDER BY ProcessName ASC"); 
        $posts = \DB::connection()->getSchemaBuilder()->getColumnListing("process");
        
    // $settings = SomeModel::where($items_match)->get(); //Making use of Eloquent
    $arrAve = array();
    $arrField = array();
//  $settings = process::where($items_match)->get(); //Making use of Eloquent
   
    $columns = DB::connection()
                ->getDoctrineSchemaManager()
                ->listTableDetails("process");
foreach ( $posts as $key => $value) {
    array_push($arrAve,$columns->getColumn($value)->getComment());
}
              

                    
                
   
            
           
         //   dd($arrAve);
     return view('inc.targetCreate')
     ->with('alldata',$arrAve)
     ->with('getdata',$getall)
     ->with('fields',$posts)
     ->with('tbl','Process')
     ->with('controller','processController@store')
     ->with('controllerUp','processController@update')
     ->with('controllerDel','processController@destroy');
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
    
            $process = New process();
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
        $process = process::find($id);
       // $process->ProcessName = $txt[0];
      $txt = $request->input('txt');
        $process->ProcessDesc = $txt[1];;
        $process->save();
        return redirect('/process/create')
        ->with('success', 'Successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = process::find($id);
        $post->delete();
        return redirect('/process/create')
        ->with('success', 'Successfully Deleted');
    }
}
