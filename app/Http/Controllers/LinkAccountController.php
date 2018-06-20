<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User as User;

use Response;

class LinkAccountController extends Controller
{
    //
    public function index(){
        return view ('pages.link');
    }

    public function check(Request $request) {
        $existing = User::where("user_id",$request->input("USERID"))->count("user_id");
        $user = DB::connection("web_portal")
                    ->table("sys01")
                    ->leftJoin("hri01","sys01.USERID","=","hri01.IDNUMBER")
                    ->leftJoin("hrs01","hri01.DEPCODE","=","hrs01.DEPCODE")
                    ->select("sys01.USERNAME",DB::raw("IFNULL(hrs01.DEPDESC,'-') as DEPDESC"),DB::raw($existing . " as EXISTING"))
                    ->where([
                        ["sys01.USERID","=",$request->input("USERID")],
                        ["sys01.PASSWORD","=",DB::raw("MD5('".$request->input("PASSWORD")."')")],
                    ])
                    ->first();
        
        return Response::json($user); 
    }

    public function link(Request $request) {
        $data = [];

        $data['user_id'] = $request->input('uid');
        $data['password'] = bcrypt($request->input('pwd'));
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('-');

        User::create($data);
        return redirect('/login')->with("success","You have successfully linked your web portal account. You can now login to the app.");
    }
}
