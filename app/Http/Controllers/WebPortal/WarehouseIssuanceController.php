<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\WarehouseIssuance;
use App\Models\WebPortal\WarehouseIssuanceDetails;

use DB;
use Response;

class WarehouseIssuanceController extends Controller
{
    protected $error_codes;

    public function __construct() {
        date_default_timezone_set('Asia/Manila');
        $this->error_codes = [
            1062 => "You are trying to enter a duplicate record. Please check your input."
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('mes.materials.issuance');
    }

    public function list(Request $request) {
        $results = DB::connection("web_portal")
                        ->table("spmmc00.wi01 as A")
                        ->join("spmmc00.lin01 as B","A.production_line","B.LINCODE")
                        ->where($request->parameters)
                        ->whereNotExists(function($query)
                        {
                            $query->select(DB::raw(1))
                                ->from('spmmc00.wi01 as C')
                                ->whereRaw("C.mits_number = A.mits_number AND C.trx_type <> A.trx_type AND C.trx_type = 'Issue'");
                        })
                        ->orderBy("date", "DESC")
                        ->select(DB::raw("A.id, A.created_at as `date`, A.trx_type, A.production_date, B.LINDESC AS `production_line`, A.registration, A.mits_number, CASE A.status WHEN false THEN 'Open' ELSE CASE A.trx_Type WHEN 'Request' THEN 'Submitted' ELSE 'Issued' END END AS `status`"))
                        ->paginate(10);

        return Response::json($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $err_msg = '';

        $req = json_decode(json_decode($request->params));
        // dd($req);
        try {
            $header = WarehouseIssuance::create(
                [
                    "trx_type" => $req->trx_type,
                    "production_date" => $req->production_date,
                    "production_line" => $req->production_line,
                    "registration" => $req->registration,
                    "product_type" => $req->product_type,
                    "mits_number" => $req->mits_number,
                    "requestor" => $req->requestor,
                ]
            );
    
            foreach($req->items as $item) {
                $details = WarehouseIssuanceDetails::create(
                    [
                        "issuance_id" => $header->id,
                        "item_code" => $item->item_code,
                        "uofm_base" => $item->uofm_base,
                        "uofm_issue" => $item->uofm_issue,
                        "conv_issue" => $item->conv_issue,
                        "base_qty" => $item->base_qty,
                        "issue_qty" => $item->issue_qty,
                        "remarks" => $item->remarks,
                    ]
                );
            }
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

    public function submitTransaction($id) {
        $results = WarehouseIssuance::where("id",$id)
                                    ->update([
                                        "status" => 1
                                    ]);

        return Response::json(["results" => $results]);
    }

    public function deleteTransaction($id) {
        $results = WarehouseIssuance::where("id",$id)
                                    ->delete();

        return Response::json(["results" => $results]);
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
        $header = WarehouseIssuance::find($id);
        $details = WarehouseIssuanceDetails::join("im01", "wi02.item_code", "im01.item_code")
                                                ->where("wi02.issuance_id",$id)
                                                ->select("wi02.id","wi02.item_code","im01.item_desc","wi02.uofm_base","wi02.uofm_issue","wi02.conv_issue","wi02.base_qty","wi02.issue_qty","wi02.remarks")
                                                ->get();

        return Response::json([
            "transaction" => $header,
            "items" => $details,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $err_msg = '';

        $req = json_decode(json_decode($request->params));
        
        try {
            $header = WarehouseIssuance::where("id",$req->id)
                                            ->update(
                                                [
                                                    "production_date" => $req->production_date,
                                                    "production_line" => $req->production_line,
                                                    "registration" => $req->registration,
                                                    "product_type" => $req->product_type,
                                                    "mits_number" => $req->mits_number,
                                                ]
                                            );
    
            foreach($req->items as $item) {
                $details = WarehouseIssuanceDetails::where("id",$item->id)->update(
                    [
                        "item_code" => $item->item_code,
                        "uofm_base" => $item->uofm_base,
                        "uofm_issue" => $item->uofm_issue,
                        "conv_issue" => $item->conv_issue,
                        "base_qty" => $item->base_qty,
                        "issue_qty" => $item->issue_qty,
                        "remarks" => $item->remarks,
                    ]
                );
            }
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
