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
        $posts = Pulltest::all(); 
        //$posts = Post::orderBy('created_at','desc')->paginate(2);
        return view('pages.pulltestdata')  
                    ->with('alldata',$posts);
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
            'ModuleID' => 'required|alpha_num|max:15|min:13',
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
        $pulltest->ModuleID = $request->input('ModuleID');
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
        return redirect('/pulltest')->with('success', 'Successfully Created');
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
}
