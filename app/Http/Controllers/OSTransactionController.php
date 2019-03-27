<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OSTransaction;
use App\OSTransactionDetail;
use App\OSCategory;
use App\OfficeSupplies;
use App\OSTrxStatus;
use Illuminate\Support\Facades\Auth;

Use DataTables;
Use Response;

class OSTransactionController extends Controller
{
    //
    public function __construct( OSTrxStatus $status )
    {
        $this->status = $status->all();
    }  

    public function list() {
        return view('osi.transactions.list');
    }

    public function load()
    {
        $cond = Auth::user()->osi_role == "CUST" || Auth::user()->sysadmin == 1 ? "transactions.type IN ('Incoming','Request')" : "transactions.type = 'Request' AND transactions.user_id = " . Auth::user()->id;
        $trx = OSTransaction::selectRaw("transactions.id, transactions.control_no, transactions.type, sp_admin.users.name, sp_admin.departments.description as department, transactions.date, transactions.status, FORMAT(SUM(transaction_details.total_cost),2) as total_cost")
                    ->join("sp_admin.users","transactions.user_id","=","sp_admin.users.id")
                    ->join("sp_admin.departments","sp_admin.users.dept_id","=","sp_admin.departments.id")
                    ->join("transaction_details","transactions.id","=","transaction_details.transaction_id")
                    ->whereRaw($cond)
                    ->orderByRaw("control_no ASC")
                    ->groupBy("transactions.id", "transactions.control_no", "transactions.type", "sp_admin.users.name", "sp_admin.departments.description", "transactions.date", "transactions.status");

        return Datatables::of($trx)->make(true);
    }

    public function create(Request $request, $tid) {
        $data = [];

        $data['trx'] = "New " . $tid;
        $data['control_no'] = OSTransaction::GenerateCode($tid);
        $data['type'] = $request->input('type') ? $request->input('type') : $tid;
        $data['user_id'] = Auth::user()->id;
        $data['date'] = date('Y-m-d');
        $data['status'] = $request->input('status') ? $request->input('status') : "Open" ;
        $data['remarks'] = $request->input('remarks');
                
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'control_no' => 'required|max:15|unique:osi.transactions',
                'type' => 'required',
                'date' => 'required|date',
                'status' => 'required',
                // 'remarks' => 'required',
            ]);
            
            // dd($data);

            OSTransaction::create($data);

            $trx = OSTransaction::where("control_no",$data['control_no'])->first();
            $item = $request->input('item');
            $qty = $request->input('qty');
            $unit_cost = $request->input('unit-cost');
            $total_cost = $request->input('total-cost');

            foreach( $item as $key => $n ) {
                $details = [];
                $details["transaction_id"] = $trx->id;
                $details["item_id"] = $n;
                $details["qty"] = $qty[$key];
                $details["unit_cost"] = $unit_cost[$key];
                $details["total_cost"] = $total_cost[$key];

                OSTransactionDetail::create($details);
            }

            return redirect('os/transaction/list')->with("success","Transaction [".$data["control_no"]."] successfully created.");
        }

        $data['categories'] = OSCategory::orderBy("code","asc")->get();
        $data['modify'] = 0;

        // dd($data);

        return view('osi.transactions.form', $data);
    }

    public function updateStatus(Request $request) {
        $id = $request->input('transaction_id');
        $status = $request->input('status');
        $new_status = '';

        $trx_statuses = $this->status;

        $qty = explode(",",$request->input('qty'));
        $cost = explode(",",$request->input('total-cost'));
        $trxid = explode(",",$request->input('trxid'));

        $ix = 0;
        
        foreach($qty as $q) {
            $detail = OSTransactionDetail::find($trxid[$ix]);
            $detail->qty = $q;
            $detail->total_cost = $cost[$ix];
            $detail->save();

            $ix++;
        }

        // return Response::json($request->input('remarks'));

        foreach ($trx_statuses as $trx_status) {
            if ($trx_status['status'] == $status) {
                $new_status = $trx_status['next'];
                break;
            }
        }

        $trx = OSTransaction::find($id);
        $trx->status = $new_status;

        if (count($qty) > 0 && $request->input('remarks') != null) {
            $trx->remarks = $request->input('remarks');
        }

        $trx->save();
    }

    public function GetTrxInfo(Request $request) {
        $trx_info = [];
        $data = [];
        $trx = OSTransaction::find($request->input('transaction_id'));

        $data["id"] = $trx->id;
        $data["control_no"] = $trx->control_no;
        $data["user_id"] = $trx->user_id;
        $data["date"] = $trx->date;
        $data["type"] = $trx->type;
        $data["status"] = $trx->status;

        foreach($trx->details as $detail) {
            $data["trxid"] = $detail->id;
            $data["category"] = $detail->item->category->description;
            $data["item"] = $detail->item->description;
            $data["current_stock"] = $detail->item->current_stock;
            $data["qty"] = number_format($detail->qty);
            $data["unit_cost"] = number_format($detail->unit_cost,2);
            $data["total_cost"] = number_format($detail->total_cost,2);
            array_push($trx_info, $data);
        }

        return Response::json($trx_info);
    }

    public function GetItems(Request $request) {
        $items = OSCategory::find($request->input('category_id'))->items->all();
        return Response::json($items);
    }

    public function GetItemDetails(Request $request) {
        $item = OfficeSupplies::find($request->input('item_id'));
        return Response::json($item);
    }
}
