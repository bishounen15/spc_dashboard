<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SerialInfo;
use App\ftdData;
use App\mesData;

use App\Models\WebPortal\ProductionLine;
use App\Models\WebPortal\MESAdditional;

use DB;
use DataTables;
use Response;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('mes/reports/inquiry');
    }

    public function inquire(Request $request)
    {
        //
        $module = SerialInfo::where('SERIALNO',DB::raw("'" . $request->input('SERIALNO') . "'"));

        $data = [];

        if ($module->count() > 0) {
            $mod = $module->first();
            $prd = $module->orderBy('LBLTYPE','DESC')->first();
            $mes = $mod->mes->last();

            $data['SERIALNO'] = $mod->SERIALNO;
            $data['CUSTOMER'] = $mod->CUSTOMER;
            $data['PARTNO'] = $mod->itemDetails() == null ? "Not Found" : $mod->itemDetails()->ITMCODE;
            $data['MODEL'] = $prd->modelName();
            $data['COLOR'] = $mod->COLOR;
            $data['MODCLASS'] = $mod->MODCLASS;
            $data['STATUS'] = $mod->mes->count() > 0 ? $mes->moduleStatus() : '';
            $data['PRODLINE'] = ProductionLine::where("LINCODE",$mod->PRODLINE)->first()->LINDESC;
            $data['PALLETNO'] = $mod->palletInfo != null ? $mod->palletInfo->PALLETNO : '';
            $data['CONTAINER'] = '';
            $data['BOM'] = $mod->BOM;
        }

        return Response::json($data);
    }

    public function ftd($serial)
    {
        $ftd = ftdData::selectRaw("ROWID, ModuleID, InspectionTime, Isc, Uoc, Impp, Umpp, Pmpp, ShuntResistance, FF, Bin, CASE WHEN ModuleID LIKE '%*%' THEN 1 ELSE 0 END AS skip")
                        ->where('ModuleID','LIKE',DB::raw("'" . $serial . "%'"))
                        ->orderByRaw("InspectionTime DESC");

        return Datatables::of($ftd)->make(true);
    }

    public function mes($serial)
    {
        $mes = mesData::selectRaw("mes01.ROWID, mes01.SERIALNO, lin01.LINDESC AS PRODLINE, mes01.LOCNCODE, mes01.TRXDATE, CASE mes01.SNOSTAT WHEN 0 THEN 'Good' WHEN 1 THEN 'MRB' WHEN 2 THEN 'Scrap' ELSE '-' END AS STATUS, mes01.MODCLASS, mes01.REMARKS, sys01.USERNAME AS TRXUSER")
                        ->join("sys01","mes01.TRXUID","=","sys01.USERID")
                        ->join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
                        ->join("lin01",DB::raw("IFNULL(mes01.PRODLINE,lbl02.PRODLINE)"),"=","lin01.LINCODE")
                        ->where([
                            ['mes01.SERIALNO','=',$serial],
                            ['lbl02.LBLTYPE','=',1],
                        ])
                        ->orderByRaw("mes01.TRXDATE DESC");

        return Datatables::of($mes)->make(true);
    }

    public function lot($serial)
    {
        $lot = MESAdditional::selectRaw("mes02.SERIALNO, mes02.FIELDNAME, UPPER(mes02.FIELDVALUE) AS FIELDVALUE, mat01.PARTNUMBER, mat01.DESCRIPTION")
                        ->leftJoin("mat01","mes02.FIELDVALUE","=","mat01.LOTNUMBER")
                        ->where([
                            ['mes02.SERIALNO','=',$serial],
                            ['mes02.INFOTYPE','=','LOT'],
                        ])
                        ->orderByRaw("mes02.ROWID ASC");

        return Datatables::of($lot)->make(true);
    }

    public function trinaLookup(Request $request) {
        $module_id = DB::connection('trina')
                        ->select("SELECT COUNT(*) AS isExisting FROM omes.rt_wo_mid WHERE Module_ID = ?",[$request->lookup_value]);
        
        if ($module_id[0]->isExisting > 0) {
            $result = DB::connection('web_portal')
                        ->select("SELECT LBLCNO, LBLTYPE, PRODTYPE, CELLCOUNT, CELLCOLOR, CUSTOMER, ORDERNO, PRODLINE, COLOR FROM lbl02 WHERE SERIALNO < ? ORDER BY SERIALNO DESC LIMIT 1",[$request->lookup_value]);
        } else {
            $result = [];
        }

        return Response::json($result);
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
    }
}
