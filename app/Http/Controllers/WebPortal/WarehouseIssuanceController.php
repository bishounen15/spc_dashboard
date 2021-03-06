<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Models\WebPortal\WarehouseIssuance;
use App\Models\WebPortal\WarehouseIssuanceDetails;

use DB;
use Response;
use Validator;

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
        $req = json_decode(json_decode($request->params));
        // dd($req);

        $data = [
            "trx_type" => $req->trx_type,
            "production_date" => $req->production_date,
            "production_line" => $req->production_line,
            "registration" => $req->registration,
            "product_type" => $req->product_type,
            "mits_number" => $req->mits_number,
            "requestor" => $req->requestor,
        ];

        $trx_type = $data['trx_type'];
        $mits_number = $data['mits_number'];

        $validator = Validator::make($data, [
            'mits_number' => [
                'required',
                Rule::unique('web_portal.wi01')->where(function ($query) use ($trx_type,$mits_number) {
                    return $query->where('trx_type', $trx_type)
                        ->where('mits_number', $mits_number);
                }),
            ],
        ], [
            'mits_number.unique' => 'MITS Number ['.$mits_number.'] is already exist.',
        ]);

        $err_msg = '';

        if ($validator->fails()) {
            $err_msg = $validator->messages()->first();
        } else {
            try {
                $header = WarehouseIssuance::create($data);
        
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
            } 
        }

        return Response::json($err_msg);
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
        $results = DB::connection('web_portal')
                        ->select("SELECT E.updated_at AS request_date, D.mits_number, D.production_date, F.LINDESC AS production_line, D.registration, D.product_type, E.item_code, C.item_desc AS description, E.base_qty AS rqty_base, E.issue_qty AS rqty_issue, E.remarks AS rremarks, A.updated_at AS issue_date, B.base_qty AS iqty_base, B.issue_qty AS iqty_issue, B.remarks AS iremarks, A.requestor as request_by, D.requestor AS issue_by FROM wi01 A INNER JOIN wi02 B ON A.id = B.issuance_id INNER JOIN im01 C ON B.item_code = C.item_code INNER JOIN wi01 D ON A.mits_number = D.mits_number AND D.trx_type = 'Request' INNER JOIN wi02 E ON D.id = E.issuance_id AND B.item_code = E.item_code INNER JOIN lin01 F ON D.production_line = F.LINCODE WHERE A.id = ? AND A.trx_type = 'Issue' ORDER BY E.id",[$id]);

        return Response::json(['results' => $results]);
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
        $req = json_decode(json_decode($request->params));
        
        $data = [
            "production_date" => $req->production_date,
            "production_line" => $req->production_line,
            "registration" => $req->registration,
            "product_type" => $req->product_type,
            "trx_type" => $req->trx_type,
            "mits_number" => $req->mits_number,
        ];

        $trx_id = $req->id;
        $trx_type = $data['trx_type'];
        $mits_number = $data['mits_number'];

        $validator = Validator::make($data, [
            'mits_number' => [
                'required',
                Rule::unique('web_portal.wi01')->where(function ($query) use ($trx_type,$mits_number,$trx_id) {
                    return $query->where('trx_type', $trx_type)
                        ->where('mits_number', $mits_number)
                        ->where('id','<>', $trx_id);
                }),
            ],
        ], [
            'mits_number.unique' => 'MITS Number ['.$mits_number.'] is already exist.',
        ]);

        $err_msg = '';

        if ($validator->fails()) {
            $err_msg = $validator->messages()->first();
        } else {
            try {
                $header = WarehouseIssuance::where("id",$req->id)
                                                ->update($data);
        
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
            } 
        }

        return Response::json($err_msg);
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
