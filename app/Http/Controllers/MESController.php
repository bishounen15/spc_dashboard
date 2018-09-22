<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mesData;

use DB;
use DataTables;

class MESController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('mes.reports.transactions');
    }

    public function load($start = '', $end = '')
    {
        $cond = [];

        // return $end;

        $sdate = $start == '' ? date('Y-m-d') : date('Y-m-d',strtotime($start));
        $edate = $end == '' ? date('Y-m-d') : date('Y-m-d',strtotime($end));

        $mes = DB::connection('web_portal')
                    ->select("SELECT A.SERIALNO, REPLACE(REPLACE(REPLACE(IFNULL(H.MODELNAME,E.PRODCODE),'[R]',CASE WHEN B.CELLCOLOR = 'E' AND B.CUSTOMER = 'GEN1' THEN 'M' ELSE B.CELLCOLOR END),'[C]',B.CELLCOUNT),'[P]',IFNULL(F.Bin,'XXX')) AS MODEL, B.CUSTOMER, DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) AS 'DATE', A.TRXDATE, CONCAT('Shift ',CASE WHEN TIME(A.TRXDATE) BETWEEN '06:00:00' AND '13:59:59' THEN 'A' WHEN TIME(A.TRXDATE) BETWEEN '14:00:00' AND '21:59:59' THEN 'B' ELSE 'C' END) AS SHIFT, CASE A.SNOSTAT WHEN 0 THEN 'GOOD' WHEN 1 THEN 'MRB' ELSE 'SCRAP' END AS STATUS, A.REMARKS, A.MODCLASS, IFNULL(CONCAT(C.LASTNAME,', ',C.FIRSTNAME),D.USERNAME) AS USER, A.LOCNCODE FROM mes01 A INNER JOIN lbl02 B ON A.SERIALNO = B.SERIALNO AND B.LBLTYPE = 1 LEFT JOIN hri01 C ON A.TRXUID = C.IDNUMBER INNER JOIN sys01 D ON A.TRXUID = D.USERID LEFT JOIN cus01 E ON B.CUSTOMER = E.CUSCODE LEFT JOIN ftd_upd F ON B.SERIALNO = F.ModuleID LEFT JOIN lbl02 G ON A.SERIALNO = G.SERIALNO AND G.LBLTYPE = 3 LEFT JOIN lbt00 H ON G.CUSTOMER = H.CUSTOMER AND G.TEMPLATE = H.TMPCODE WHERE DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) BETWEEN ? AND ? ORDER BY A.ROWID DESC",[$sdate,$edate]);

        return Datatables::of($mes)->make(true);
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
