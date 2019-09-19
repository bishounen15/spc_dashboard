<?php

namespace App\Http\Controllers\Planning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\BOM;
use App\Models\WebPortal\BOMComponent;

use DB;
use Response;

class BOMController extends Controller
{
    //
    public function index() {
        return view('planning.bom.index');
    }

    public function getBOM($prodtype) {
        $bom_rm = DB::connection('web_portal')
                    ->select("SELECT A.bom_index, A.category, A.item_class, B.item_code, C.item_desc, A.bom_qty, C.uofm_base, C.supplier, (SELECT COUNT(item_code) FROM bm02 WHERE bom_id = A.id) AS rowspan FROM bm01 A INNER JOIN bm02 B ON A.id = B.bom_id INNER JOIN im01 C ON B.item_code = C.item_code WHERE A.product_type = ? AND A.category = ? ORDER BY A.bom_index, B.item_code",[$prodtype,"rawmat"]);

        $bom_pk = DB::connection('web_portal')
                    ->select("SELECT A.bom_index, A.category, A.item_class, B.item_code, C.item_desc, A.bom_qty, C.uofm_base, C.supplier, (SELECT COUNT(item_code) FROM bm02 WHERE bom_id = A.id) AS rowspan FROM bm01 A INNER JOIN bm02 B ON A.id = B.bom_id INNER JOIN im01 C ON B.item_code = C.item_code WHERE A.product_type = ? AND A.category = ? ORDER BY A.bom_index, B.item_code",[$prodtype,"box packaging"]);

        $bom_hr = DB::connection('web_portal')
                    ->select("SELECT A.bom_index, A.category, A.item_class, B.item_code, C.item_desc, A.bom_qty, C.uofm_base, C.supplier, (SELECT COUNT(item_code) FROM bm02 WHERE bom_id = A.id) AS rowspan FROM bm01 A INNER JOIN bm02 B ON A.id = B.bom_id INNER JOIN im01 C ON B.item_code = C.item_code WHERE A.product_type = ? AND A.category = ? ORDER BY A.bom_index, B.item_code",[$prodtype,"horizontal packaging"]);

        return Response::json(["rm"=>$bom_rm,"pk"=>$bom_pk,"hr"=>$bom_hr]);
    }

    public function checkBOMItem($product_type, $item_code) {
        $info = DB::connection('web_portal')
                        ->select("SELECT C.item_desc, C.uofm_base, C.uofm_issue, C.conv_issue FROM spmmc00.bm01 A INNER JOIN spmmc00.bm02 B ON A.id = B.bom_id INNER JOIN spmmc00.im01 C ON B.item_code = C.item_code WHERE A.product_type = ? AND B.item_code = ?",[$product_type,$item_code]);
        
        return Response::json(['data' => $info]);
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

            if (strpos($kvp[0], '[]') !== false) {
                try {
                    $data[str_replace('[]','',$kvp[0])];
                } catch (\Throwable $th) {
                    $data[str_replace('[]','',$kvp[0])] = [];
                } finally {
                    array_push($data[str_replace('[]','',$kvp[0])],$kvp[1]);
                }
                // echo 'true';
            } else {
                $data[$kvp[0]] = $kvp[1];
            }
        }
        
        $err_msg = "";

        if ($data['bom_qty'] <= 0) {
            $err_msg = "Usage is a required field.";
        } else {
            try {
                if (count($data['selected_items']) <= 0) {
                    $err_msg = "No item selected.";
                }
            } catch (\Throwable $th) {
                $err_msg = "No item selected.";
            }
        }

        if ($err_msg == "") {
            try {
                $bom_index = BOM::where([
                    ["product_type",$data['product_type']],
                    ["category",$data['category']],
                ])->count() + 1;

                $d = [
                    'product_type' => $data['product_type'],
                    'category' => $data['category'],
                    'item_class' => $data['item_class'],
                    'bom_qty' => $data['bom_qty'],
                    'bom_index' => $bom_index,
                ];

                $results = BOM::create($d);
                
                $bom_id = $results->id;

                foreach($data['selected_items'] as $item) {
                    $c = [
                        'bom_id' => $bom_id,
                        'item_code' => $item,
                    ];

                    $results = BOMComponent::create($c);
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
        } else {
            return Response::json($err_msg);
        }
    }
}
