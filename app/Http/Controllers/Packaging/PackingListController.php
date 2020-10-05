<?php

namespace App\Http\Controllers\Packaging;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Packaging\PackingLists;
use App\Models\Packaging\PackingListItems;
use App\Models\WebPortal\ProductionLine;
use App\SerialInfo;
use App\Pallets;
use App\mesData;
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
        $data = [];

        if (Auth::user()->mes_role == 'QUAL') {
            $data['mrb'] = true; 
        } else {
            $data['mrb'] = false;
        }

        return view("mes.packaging.list",$data);
    }

    public function load($start = '', $end = '')
    {
        $cond = [];

        // return $end;

        $sdate = $start == '' ? date('Y-m-d') : date('Y-m-d',strtotime($start));
        $edate = $end == '' ? date('Y-m-d') : date('Y-m-d',strtotime($end));

        if (Auth::user()->mes_role == "ADMIN" || Auth::user()->sysadmin == 1) {
            $query = "SELECT A.ROWID, A.PALLETNO, A.REGISTRATION, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, COUNT(B.SERIALNO) AS TOTALMODS, C.CABINETNO, A.PALLETSNO FROM epl01 A LEFT JOIN epl02 B ON A.PALLETNO = B.PALLETNO AND A.CARTONNO = B.CARTONNO LEFT JOIN cab02 C ON A.PALLETNO = C.PALLETNO WHERE TRXDATE BETWEEN ? AND ? GROUP BY A.ROWID, A.PALLETNO, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, C.CABINETNO, A.PALLETSNO ORDER BY A.CUSTOMER ASC, A.PALLETNO DESC";
        } else if (Auth::user()->mes_role == "QUAL") {
            $query = "SELECT A.ROWID, A.PALLETNO, A.REGISTRATION, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, COUNT(B.SERIALNO) AS TOTALMODS, C.CABINETNO, A.PALLETSNO FROM epl01 A LEFT JOIN epl02 B ON A.PALLETNO = B.PALLETNO AND A.CARTONNO = B.CARTONNO LEFT JOIN cab02 C ON A.PALLETNO = C.PALLETNO WHERE TRXDATE BETWEEN ? AND ? AND A.PALLETNO LIKE 'MRB%' GROUP BY A.ROWID, A.PALLETNO, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, C.CABINETNO, A.PALLETSNO ORDER BY A.CUSTOMER ASC, A.PALLETNO DESC";
        } else {
            $query = "SELECT A.ROWID, A.PALLETNO, A.REGISTRATION, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, COUNT(B.SERIALNO) AS TOTALMODS, C.CABINETNO, A.PALLETSNO FROM epl01 A LEFT JOIN epl02 B ON A.PALLETNO = B.PALLETNO AND A.CARTONNO = B.CARTONNO LEFT JOIN cab02 C ON A.PALLETNO = C.PALLETNO WHERE TRXDATE BETWEEN ? AND ? AND A.PALLETNO NOT LIKE 'MRB%' GROUP BY A.ROWID, A.PALLETNO, A.CUSTOMER, A.PRODUCTNO, A.MODELNAME, C.CABINETNO, A.PALLETSNO ORDER BY A.CUSTOMER ASC, A.PALLETNO DESC";
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
        if (Auth::user()->mes_role == 'QUAL') {
            $mrb = true; 
        } else {
            $mrb = false;
        }

        $serial = $request->input('serial');
        $currModel = $request->input('model');
        $currClass = $request->input('class');
        $trxDate = $request->input('date');

        $serialInfo = SerialInfo::where("SERIALNO",$serial)->first();
        $modelInfo = SerialInfo::where("SERIALNO",$serial)->orderBy("LBLTYPE","DESC")->first();
        
        $data = [];
        $data['errors'] = ['error_msg' => ''];

        if ($serialInfo != null) {
            if ($serialInfo->mes->whereNotIn('LOCNCODE', DB::connection('web_portal')->table('lts02')->where("EXEMPTROUTE",1)->pluck('STNCODE'))->last()->LOCNCODE != 'FG-PROD' && $mrb == false) {
                $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is not yet scanned in FG-PROD.<br>Current Location is at ['.$serialInfo->mes->last()->LOCNCODE.']'];
            } else {
                if ($serialInfo->palletInfo != null) {
                    $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is already scanned in Pallet No. ['.$serialInfo->palletInfo->PALLETNO.']'];
                } else {
                    if ($serialInfo->mrb->first() != null && $mrb == false) {
                        $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is currently in MRB Status.<br>Date inserted to MRB: ['.$serialInfo->mrb->first()->DTINSRT.']'];
                    } else {
                        if ($modelInfo->modelName() != $currModel && $currModel != "") {
                            $data['errors'] = ['error_msg' => 'Product Code Mismatach.<br>The serial number\'s ['.$serial.'] Product Code ['.$modelInfo->modelName().'] does not match with the current transaction ['.$currModel.'].'];
                        } else {
                            if ($serialInfo->MODCLASS != $currClass && $currClass != "") {
                                $data['errors'] = ['error_msg' => 'Module Class Mismatach.<br>The serial number\'s ['.$serial.'] Module Class ['.$serialInfo->MODCLASS.'] does not match with the current transaction ['.$currClass.'].'];
                            } else {
                                if ($mrb && $serialInfo->MODCLASS == "A") {
                                    $data['errors'] = ['error_msg' => 'Module Serial Number ['.$serial.'] is of Class A Status.'];
                                }
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
            $data['PRODUCTNO'] = $modelInfo->itemDetails() != null ? $modelInfo->itemDetails()->ITMCODE : "-";
            $data['MODELNAME'] = $modelInfo->modelName();
            $data['MODCLASS'] = $serialInfo->MODCLASS;
            $data['MAXPALLET'] = $serialInfo->customerInfo->MAXPALLET;
            $data['BIN'] = $serialInfo->ftd->count() > 0 ? $serialInfo->ftd->last()->Bin : "XXX";
            
            if ($serialInfo->workOrder() == null) {
                $reg = ProductionLine::where("LINCODE",$serialInfo->PRODLINE)->first()->LINCAT;
            } else {
                $reg = $serialInfo->workOrder()->WOCATEGORY;
            }
            
            $data['REGISTRATION'] = $reg;

            $pno = $serialInfo->customerInfo->PALLETFORMAT;

            $pno = str_replace('[YY]',date('y',strtotime($trxDate)),$pno);
            $pno = str_replace('[MM]',date('m',strtotime($trxDate)),$pno);
            $pno = str_replace('[DD]',date('d',strtotime($trxDate)),$pno);
            $pno = str_replace('[G]',substr($data['REGISTRATION'],0,1),$pno);

            $data['PALLETFORMAT'] = ($mrb ? "MRB" : "") . $pno;
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

        if (Auth::user()->mes_role == 'QUAL') {
            $data['mrb'] = true; 
        } else {
            $data['mrb'] = false;
        }

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
        $phead['PALLETSNO'] = $request->input('PALLETSNO');
        $phead['CARTONNO'] = 'N/A';
        $phead['CUSTOMER'] = $request->input('CUSTOMER');
        $phead['TRXDATE'] = $request->input('TRXDATE');
        $phead['PRODUCTNO'] = $request->input('PRODUCTNO');
        $phead['MODELNAME'] = $request->input('MODELNAME');
        $phead['REGISTRATION'] = $request->input('REGISTRATION');
        $phead['UIDCREATE'] = Auth::user()->user_id;
        $phead['PALLETSTAT'] = 0;
        $SERIALNO = $request->input('SERIALNO');

        $snos = explode(',',$SERIALNO[0]);

        $validator = Validator::make($request->all(), [
            'PALLETNO' => 'required|unique:web_portal.epl01',
            'PALLETSNO' => 'required',
        ], [
            'PALLETNO.unique' => 'Pallet Number ['.$pallet.'] already exists.',
            'PALLETSNO.required' => 'Pallet Serial Number field is required.',
        ]);

        $serr = [];

        if ($validator->fails()) {
            array_push($serr, $validator->messages()->first());
            // array_push($serr, $pallet." already exists.");
            // array_push($serr, $request->input('PALLETNO')." already exists.");
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
            $pdate = date('Y-m-d H:i:s');
            $ix = 1;
            
            foreach($snos as $sno) {
                $pdetails = [];
                $pdetails["PALLETNO"] = $phead['PALLETNO'];
                $pdetails["CARTONNO"] = $phead['CARTONNO'];
                $pdetails["ITMIX"] = $ix;
                $pdetails["SERIALNO"] = $sno;
                $ix++;

                PackingListItems::create($pdetails);

                $info = SerialInfo::selectRaw("(SELECT CONCAT(DATE_FORMAT(now(),'%Y%m'),LPAD(IFNULL(SUBSTR(MAX(MESCNO),7,6),'000000') + 1,6,0)) AS MESCNO FROM spmmc00.mes01 WHERE MESCNO LIKE CONCAT(DATE_FORMAT(now(),'%Y%m'),'%')) AS CNO, lbl02.MODCLASS, cls01.MODSTATUS")
                            ->join("cls01", function ($join) {
                                $join->on("lbl02.MODCLASS","=","cls01.MCLCODE"); 
                                $join->on("lbl02.CUSTOMER","=","cls01.CUSTOMER");
                            })->where([
                                ["lbl02.SERIALNO",$sno],
                                ["lbl02.LBLTYPE",1]
                            ])->first();

                mesData::insert([
                    'SERIALNO' => $sno,
                    'LOCNCODE' => 'PACKAGING',
                    'MODCLASS' => $info->MODCLASS,
                    'SNOSTAT' => $info->MODSTATUS,
                    'REMARKS' => 'Pallet Number: ' . $phead['PALLETNO'],
                    'MESCNO' => $info->CNO,
                    'TRXUID' => Auth::user()->user_id,
                    'TRXDATE' => $pdate,
                ]);
            }
        }

        // return redirect('mes/packaging')->with("success","Transaction [".$phead["PALLETNO"]."] successfully created.");

        return Response::json($data);
    }

    public function export($id) {
        $pallet = PackingLists::find($id);
        
        if (Auth::user()->mes_role == 'QUAL') {
            $mrb = true;
        } else {
            $mrb = false;
        }

        $inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
        $inputFileName = 'storage/Templates/' . ($pallet->customer->TEMPLATE == null ? "Packing List" . ($mrb ? " - MRB" : "") . ".xls" : $pallet->customer->TEMPLATE);

        // dd($inputFileName);

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($inputFileName);
        
        $sheet = $spreadsheet->getActiveSheet();
        
        if ($pallet->customer->TEMPLATE == null || $pallet->customer->TEMPLATE == "Packing List - 32.xls") {
            $sheet->setCellValue('A1', "Model Name : " . $pallet->MODELNAME);
            $sheet->setCellValue('D4', $pallet->PALLETNO);
            $sheet->setCellValue('D8', $pallet->PRODUCTNO);
            $sheet->setCellValue('I6', $pallet->details()->count().'pcs');
        } else {
            $sheet->SetCellValue('H3', $pallet->MODELNAME);
			$sheet->SetCellValue('H4', $pallet->PALLETNO);
        }

        // $settings = DB::connection('web_portal')
        //             ->table("epl00")
        //             ->select("COLCOUNT", "COL1", "COL2")
        //             ->first();

        $settings = DB::connection('web_portal')->select("SELECT ROWID, COLCOUNT, COL1, COL2 FROM epl00 WHERE ROWID = 1 UNION ALL SELECT ROWID, COLCOUNT, COL1, COL2 FROM epl00 WHERE CUSTOMER = ? ORDER BY ROWID DESC LIMIT 1",[$pallet->CUSTOMER])[0];

        $i = ($pallet->customer->TEMPLATE == null || $pallet->customer->TEMPLATE == "Packing List - 32.xls") ? 13 : 10;
        $sc = 0;
        $col = $settings->COL1;

        foreach($pallet->details as $detail) {
            if ($pallet->customer->TEMPLATE == null || $pallet->customer->TEMPLATE == "Packing List - 32.xls") {
                $sheet->setCellValue($col.($i-1), '="*"&'.$col.$i.'&"*"');
                $sheet->setCellValue($col.$i, '="'.$detail->SERIALNO.'"');

                if ($mrb) {
                    if ($detail->serialInfo->first()->ftd()->count() == 0) {
                        $pwr = 0;
                    } else {
                        $pwr = $detail->serialInfo->first()->ftd()->orderBy("InspectionTime","DESC")->first()->Bin;
                    }

                    $sheet->setCellValue($this->increment($col).$i, '="'.$pwr.'"');
                }

                $i+=2;
                $sc++;

                if ($sc == $settings->COLCOUNT) {
                    $i = 13;
                    $col = $settings->COL2;
                }
            } else {
                if ($i == 10) {
                    $sheet->SetCellValue('H6', $detail->serialInfo->first()->itemDetails()->ITMSPECS);
                }

                $sheet->SetCellValue("B".$i, '="'.strtoupper($detail->SERIALNO).'"');
                $sheet->SetCellValue("C".$i, '="*'.strtoupper($detail->SERIALNO).'*"');

                $i++;
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

    private function increment($val, $increment = 3)
    {
        for ($i = 1; $i <= $increment; $i++) {
            $val++;
        }

        return $val;
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
