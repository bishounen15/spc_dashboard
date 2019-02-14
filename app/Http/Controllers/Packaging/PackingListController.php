<?php

namespace App\Http\Controllers\Packaging;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Packaging\PackingLists;
use App\Models\Packaging\PackingListItems;
use App\SerialInfo;
use App\Pallets;
use Illuminate\Support\Facades\Auth;

use Validator;
use DB;
use DataTables;
use Response;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class PackingListController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("mes.packaging.list");
    }

    public function load($start = '', $end = '')
    {
        $cond = [];

        // return $end;

        $sdate = $start == '' ? date('Y-m-d') : date('Y-m-d',strtotime($start));
        $edate = $end == '' ? date('Y-m-d') : date('Y-m-d',strtotime($end));

        if (Auth::user()->mes_role == "QUAL") {
            $query = "SELECT A.ROWID, A.PALLETNO, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, COUNT(B.SERIALNO) AS TOTALMODS FROM epl01 A LEFT JOIN epl02 B ON A.PALLETNO = B.PALLETNO AND A.CARTONNO = B.CARTONNO WHERE TRXDATE BETWEEN ? AND ? AND A.PALLETNO LIKE 'MRB%' GROUP BY A.ROWID, A.PALLETNO, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME ORDER BY A.CUSTOMER ASC, A.PALLETNO DESC";
        } else {
            $query = "SELECT A.ROWID, A.PALLETNO, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, COUNT(B.SERIALNO) AS TOTALMODS FROM epl01 A LEFT JOIN epl02 B ON A.PALLETNO = B.PALLETNO AND A.CARTONNO = B.CARTONNO WHERE TRXDATE BETWEEN ? AND ? AND A.PALLETNO NOT LIKE 'MRB%' GROUP BY A.ROWID, A.PALLETNO, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME ORDER BY A.CUSTOMER ASC, A.PALLETNO DESC";
        }

        $packing = DB::connection('web_portal')->select($query,[$sdate,$edate]);

        return Datatables::of($packing)->make(true);
    }

    public function GetTrxInfo(Request $request) {
        $trx_info = [];
        $data = [];
        $trx = PackingLists::find($request->input('transaction_id'));

        $data["id"] = $trx->ROWID;
        $data["PALLETNO"] = $trx->PALLETNO;
        $data["CUSTOMER"] = $trx->CUSTOMER;
        $data["PRODUCTNO"] = $trx->PRODUCTNO;
        $data["MODELNAME"] = $trx->MODELNAME;
        
        foreach($trx->details as $detail) {
            $data["trxid"] = $detail->ROWID;
            $data["SERIALNO"] = $detail->SERIALNO;
            $data["MODEL"] = $detail->serialInfo->last()->modelName();
            $data["BIN"] = $detail->serialInfo->first()->ftd->last()->Bin;
            array_push($trx_info, $data);
        }

        return Response::json($trx_info);
    }

    public function serialValidation(Request $request) {
        $serial = $request->input('serial');
        $currModel = $request->input('model');
        $currClass = $request->input('class');
        $trxDate = $request->input('date');

        $serialInfo = SerialInfo::where("SERIALNO",$serial)->first();
        
        $data = [];
        $data['errors'] = ['error_msg' => ''];

        if ($serialInfo != null) {
            if ($serialInfo->mes->last()->LOCNCODE != 'FG-PROD') {
                $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is not yet scanned in FG-PROD.<br>Current Location is at ['.$serialInfo->mes->last()->LOCNCODE.']'];
            } else {
                if ($serialInfo->palletInfo != null) {
                    $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is already scanned in Pallet No. ['.$serialInfo->palletInfo->PALLETNO.']'];
                } else {
                    if ($serialInfo->mrb->first() != null) {
                        $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is currently in MRB Status.<br>Date inserted to MRB: ['.$serialInfo->mrb->first()->DTINSRT.']'];
                    } else {
                        if ($serialInfo->modelName() != $currModel && $currModel != "") {
                            $data['errors'] = ['error_msg' => 'Product Code Mismatach.<br>The serial number\'s ['.$serial.'] Product Code ['.$serialInfo->modelName().'] does not match with the current transaction ['.$currModel.'].'];
                        } else {
                            if ($serialInfo->MODCLASS != $currClass && $currClass != "") {
                                $data['errors'] = ['error_msg' => 'Module Class Mismatach.<br>The serial number\'s ['.$serial.'] Module Class ['.$serialInfo->MODCLASS.'] does not match with the current transaction ['.$currClass.'].'];
                            } 
                        }
                    }
                }
            }
        } else {
            $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] does not exists.'];
        }

        if ($data['errors']['error_msg'] == '') {
            $data['CUSTOMER'] = $serialInfo->CUSTOMER;
            $data['PRODUCTNO'] = $serialInfo->itemDetails()->ITMCODE;
            $data['MODELNAME'] = $serialInfo->modelName();
            $data['MODCLASS'] = $serialInfo->MODCLASS;
            $data['MAXPALLET'] = $serialInfo->customerInfo->MAXPALLET;
            $data['BIN'] = $serialInfo->ftd->last()->Bin;

            $pno = $serialInfo->customerInfo->PALLETFORMAT;

            $pno = str_replace('[YY]',date('y',strtotime($trxDate)),$pno);
            $pno = str_replace('[MM]',date('m',strtotime($trxDate)),$pno);
            $pno = str_replace('[DD]',date('d',strtotime($trxDate)),$pno);

            $data['PALLETFORMAT'] = $pno;
        }

        return Response::json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [];

        $data['PALLETNO'] = "";
        
        $time = date('H:i');

        if ($time < date('H:i',strtotime('06:00'))) {
            $date = date('Y-m-d',strtotime('-1 days',strtotime('Today')));
        } else {
            $date = date('Y-m-d',strtotime('Today'));
        }

        $data['TRXDATE'] = $date;
        $data['CUSTOMER'] = "";
        $data['PRODUCTNO'] = "";
        $data['MODELNAME'] = "";
        $data['MODCLASS'] = "";

        return view('mes.packaging.form',$data);
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
        $data = [];

        $pallet = $request->input('PALLETNO');
        $pos = strpos($pallet,"[S");
        $pre = substr($pallet,0,$pos);
        $srs = substr($pallet,$pos,strlen($pallet));
        $pno = PackingLists::where("PALLETNO","LIKE",DB::raw("'".$pre."%'"))->orderBy("PALLETNO","DESC")->first();

        if ($pno == null) {
            $pallet = $pre . sprintf("%'.0".(strlen($srs)-2)."d",1);
        } else {
            $last = (int)(substr($pno->PALLETNO,$pos,strlen($pno->PALLETNO))) + 1;
            $pallet = $pre . sprintf("%'.0".(strlen($srs)-2)."d",$last);
        }

        $phead = [];
        $phead['PALLETNO'] = $pallet;
        $phead['CARTONNO'] = 'N/A';
        $phead['CUSTOMER'] = $request->input('CUSTOMER');
        $phead['TRXDATE'] = $request->input('TRXDATE');
        $phead['PRODUCTNO'] = $request->input('PRODUCTNO');
        $phead['MODELNAME'] = $request->input('MODELNAME');
        $phead['UIDCREATE'] = Auth::user()->user_id;
        $phead['PALLETSTAT'] = 0;
        $SERIALNO = $request->input('SERIALNO');

        $snos = explode(',',$SERIALNO[0]);

        $validator = Validator::make($request->all(), [
            'PALLETNO' => 'required|unique:web_portal.epl01',
        ]);

        $serr = [];

        if ($validator->fails()) {
            array_push($pallet." already exists.");
        } else {
            foreach($snos as $sno) {
                $req = ["SERIALNO" => $sno];
                $validator = Validator::make($req, [
                    'SERIALNO' => 'unique:web_portal.epl02',
                ]);

                if ($validator->fails()) {
                    array_push($serr,$sno." already exists.");
                }
            }
        }

        $data['errors'] = $serr;

        if (count($serr) == 0) {
            PackingLists::create($phead);

            $ix = 1;
            
            foreach($snos as $sno) {
                $pdetails = [];
                $pdetails["PALLETNO"] = $phead['PALLETNO'];
                $pdetails["CARTONNO"] = $phead['CARTONNO'];
                $pdetails["ITMIX"] = $ix;
                $pdetails["SERIALNO"] = $sno;
                $ix++;

                PackingListItems::create($pdetails);
            }
        }

        // return redirect('mes/packaging')->with("success","Transaction [".$phead["PALLETNO"]."] successfully created.");

        return Response::json($data);
    }

    public function export($id) {
        $pallet = PackingLists::find($id);
        
        $inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
        $inputFileName = 'storage/Templates/Packing List.xls';

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($inputFileName);
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Model Name : " . $pallet->MODELNAME);
        $sheet->setCellValue('D4', $pallet->PALLETNO);
        $sheet->setCellValue('D8', $pallet->PRODUCTNO);
        $sheet->setCellValue('I6', $pallet->details()->count().'pcs');

        $settings = DB::connection('web_portal')
                    ->table("epl00")
                    ->select("COLCOUNT", "COL1", "COL2")
                    ->first();

        $i = 13;
        $sc = 0;
        $col = $settings->COL1;

        foreach($pallet->details as $detail) {
            $sheet->setCellValue($col.($i-1), '="*"&'.$col.$i.'&"*"');
            $sheet->setCellValue($col.$i, '="'.$detail->SERIALNO.'"');
            $i+=2;
            $sc++;

            if ($sc == $settings->COLCOUNT) {
                $i = 13;
                $col = $settings->COL2;
            }
        }

        $sheet->getProtection()->setSheet(true);
        $sheet->getProtection()->setSort(true);
        $sheet->getProtection()->setInsertRows(true);
        $sheet->getProtection()->setFormatCells(true);

        $sheet->getProtection()->setPassword('P@ssw0rd@01');

        $writer = new Xls($spreadsheet);
        // $writer->save($pallet->PALLETNO . '.xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$pallet->PALLETNO.'.xls"');
        $writer->save("php://output");

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    public function destroy($id)
    {
        //
        $pallet = PackingLists::find($id);
        $pno = $pallet->PALLETNO;
        $pallet->delete();

        return redirect('mes/packaging')->with("success","Transaction [".$pno."] successfully deleted.");
    }
}