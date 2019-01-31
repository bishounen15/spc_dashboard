<?php

namespace App\Http\Controllers\Planning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Planning\ProductionSchedule;
use App\Models\Planning\ProductionSceduleProduct;

use DataTables;

class ProductionSchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("planning.schedule.list");
    }

    public function load()
    {
        $scheds = ProductionSchedule::selectRaw("sch01.production_date, sch01.work_week, sch01.weekday, SUM(sch02.qty) AS qty, SUM(CASE sch02.production_line WHEN 1 THEN sch02.qty ELSE 0 END) AS line_1, SUM(CASE sch02.production_line WHEN 2 THEN sch02.qty ELSE 0 END) AS line_2, sch02.model_name, sch02.cell, sch02.backsheet, sch01.shifts")
                        ->join("sch02","sch01.id","sch02.schedule_id")
                        ->groupBy("sch01.production_date", "sch01.work_week", "sch01.weekday", "sch02.model_name", "sch02.cell", "sch02.backsheet", "sch01.shifts")
                        ->orderByRaw("sch01.production_date ASC");

        return Datatables::of($scheds)->make(true);
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
