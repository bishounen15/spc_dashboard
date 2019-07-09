<?php

namespace App\Http\Controllers\Trina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;
use Response;
use Validator;

class DatasetController extends Controller
{
    //
    protected $error_codes;

    public function __construct() {
        $this->error_codes = [
            1062 => "You are trying to enter a duplicate record. Please check your input."
        ];
    }

    public function getList(Request $request) {
        // $sql = "SELECT DISTINCT ".$request->field." FROM ".$request->table." WHERE factory = ? ORDER BY ".$request->field;
        $list = DB::connection('trina')
                    ->table($request->table)
                    ->select($request->fields)
                    ->where($request->lookup)
                    ->paginate(10);

        return Response::json($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];

        foreach($request->data as $d) {
            $kvp = [];

            foreach($d as $k => $v) {
                array_push($kvp,$v);
            }

            $data[$kvp[0]] = $kvp[1];
        }
        
        //
        // $validator = null;

        // $validator = Validator::make($request->all(), [
        //     'description' => 'required|unique:sites,description,'.$request->input('id').',id,parent_id,'.$request->input('parent_id'),
        //     'parent_id' => 'required|integer',
        // ], [
        //     'description.required' => 'The site field is required',
        //     'description.unique' => 'This site already exists',
        // ]);
        
        // if ($validator->fails()) {
        //     return Response::json(['Errors' => $validator->errors()]);
        // } else {
            $err_msg = "";

            try {
                $results = DB::connection('trina')
                            ->table($request->table)
                            ->insert($data);

                $req = [];
                $req['table'] = $request->table;
                $req['data'] = $data;
                $req['type'] = "INSERT";
                $req['user_id'] = $request->user_id;
                
                $res = $this->auditTrail($req);
                $err_msg = $res;
            } catch (\Throwable $th) {
                $results = $th;

                try {
                    $err_msg = $this->error_codes[$results->errorInfo[1]];
                } catch (\Throwable $th) {
                    $err_msg = $results->errorInfo[2];
                }
            } finally {
                return Response::json($err_msg);
            }
    //     }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $err_msg = "";

        try {
            $results = DB::connection('trina')
                            ->table($request->table)
                            ->where($request->data)
                            ->delete();

            $req = [];
            $req['table'] = $request->table;
            $req['data'] = $request->data;
            $req['type'] = "DELETE";
            $req['user_id'] = $request->user_id;
            
            $res = $this->auditTrail($req);
            $err_msg = $res;
        } catch (\Throwable $th) {
            $results = $th;

            try {
                $err_msg = $this->error_codes[$results->errorInfo[1]];
            } catch (\Throwable $th) {
                $err_msg = $results->errorInfo[2];
            }
        } finally {
            return Response::json($err_msg);
        }
    }

    public function auditTrail($request) {
        $data = [];
        $err_msg = "";
        
        try {
            $data['table_name'] = $request['table'];
            $data['trx_type'] = $request['type'];

            if ($request['type'] == "INSERT") {
                $data['new_value'] = json_encode($request['data']);
            } elseif ($request['type'] == "DELETE") {
                $data['old_value'] = json_encode($request['data']);
            }

            $data['user_id'] = $request['user_id'];
        
            $results = DB::connection('trina')
                        ->table('solarph.audit_trail')
                        ->insert($data);
        } catch (\Throwable $th) {
            $results = $th;

            try {
                $err_msg = $this->error_codes[$results->errorInfo[1]];
            } catch (\Throwable $th) {
                $err_msg = $results->errorInfo[2];
            }
        } finally {
            return $err_msg;
        }
    }
}
