<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\MaterialLotDetail;

use DB;
use Response;
use Validator;

class LotAssignController extends Controller
{
    //
    protected $error_codes;

    public function __construct() {
        date_default_timezone_set('Asia/Manila');
        $this->error_codes = [
            1062 => "You are trying to enter a duplicate record. Please check your input."
        ];
    }

    public function index() {
        return view('mes.materials.lot');
    }

    public function getDetails($lot) {
        $parent_lot = DB::connection('web_portal')
                            ->select('SELECT A.LOTNUMBER AS lot_id, A.PARTNUMBER AS part_number, A.DESCRIPTION AS description, A.SPEC01 * 100 AS efficiency, A.RECQTY AS qty, B.conv_issue AS issue_qty FROM mat01 A LEFT JOIN im01 B ON A.PARTNUMBER = B.item_code WHERE LOTNUMBER = ?',[$lot]);

        $child_lot = DB::connection('web_portal')
                            ->select('SELECT child_lot AS child_id, qty FROM ml01 WHERE parent_lot = ?',[$lot]);

        return Response::json(['parent_lot' => $parent_lot, 'child_lot' => $child_lot]);
    }

    public function addChild($parent, $child, $qty) {
        $data = [];

        $data['parent_lot'] = $parent;
        $data['child_lot'] = $child;
        $data['qty'] = $qty;

        $validator = Validator::make($data, [
            'child_lot' => 'required|unique:web_portal.ml01',
        ], [
            'child_lot.unique' => 'Lot Number ['.$child.'] is already assigned.',
        ]);

        $err_msg = '';

        if ($validator->fails()) {
            $err_msg = $validator->messages()->first();
        } else {
            try {
                $results = MaterialLotDetail::create($data);
            } catch (\Throwable $th) {
                $results = $th;
                // dd($th);
                try {
                    $err_msg = $this->error_codes[$results->errorInfo[1]];
                } catch (\Throwable $th) {
                    $err_msg = $results->errorInfo[2];
                }
            } 
        }

        return Response::json(['msg' => $err_msg]);
    }
}
