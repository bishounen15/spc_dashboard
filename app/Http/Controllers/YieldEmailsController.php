<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\YieldEmail;

use DataTables;
use Response;

class YieldEmailsController extends Controller
{
    //
    public function list() {
        $data = [];

        $data['email'] = null;

        return view('yield.setup.email.form', $data);
    }

    public function load()
    {
        $emails = YieldEmail::selectRaw("id, email")
        ->orderByRaw("id ASC");

        return Datatables::of($emails)->make(true);
    }

    public function store(Request $request) {
        $data = [];

        $data['email'] = $request->input("email");

        $this->validate($request, [
            'email' => 'required|email|unique:yield.emails',
        ]);

        YieldEmail::create($data);

        $return = [];
        $return["success"] = true;

        return redirect('/yield/email')->with("success","Email Successfully Added.");
    }

    public function destroy($id) {
        // dd($id);
        $email = YieldEmail::find($id);
        $email->delete($id);
        
        return redirect('/yield/email')->with("success","Email Successfully Removed.");
    }
}
