<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OSTransaction;
use App\OSCategory;

Use DataTables;

class OSTransactionController extends Controller
{
    //
    public function list() {
        return view('osi.transactions.list');
    }

    public function load()
    {
        $trx = OSTransaction::selectRaw("transactions.id, transactions.control_no, transactions.type, '' as department, transactions.date, transactions.status, SUM(transaction_details.total_cost) as total_cost")
        ->join("transaction_details","transactions.id","=","transaction_details.transaction_id")
        ->orderByRaw("control_no ASC")
        ->groupBy("transactions.id", "transactions.control_no", "transactions.type", "transactions.date", "transactions.status");

        return Datatables::of($trx)->make(true);
    }

    public function create(Request $request, $tid) {
        $data = [];

        $data['trx'] = "New " . $tid;
        $data['control_no'] = OSTransaction::GenerateCode($tid);
        $data['type'] = $request->input('type') ? $request->input('type') : $tid;
        $data['date'] = date('Y-m-d');
        $data['status'] = $request->input('status') ? $request->input('status') : "Open" ;
        $data['remarks'] = $request->input('remarks');
                
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'control_no' => 'required|max:15|unique:osi.transactions',
                'type' => 'required',
                'date' => 'required|date',
                'status' => 'required',
                'remarks' => 'required',
            ]);

            OSTransactions::create($data);
            return redirect('os/transactions/list')->with("success","Item [".$data["description"]."] successfully added.");
        }

        $data['categories'] = OSCategory::orderBy("code","asc")->get();
        $data['modify'] = 0;

        // dd($data);

        return view('osi.transactions.form', $data);
    }
}
