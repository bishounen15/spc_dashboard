<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assets;
use App\NetInterface;
use App\HDDPartitions;
use App\Software;

use DataTables;
use Response;

class AssetsController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }
    //
    public function index() {
        return view('assets.computers.index');
    }

    public function load()
    {
        $assets = Assets::selectRaw("tbl_general.id, tbl_general.serial, tbl_general.type, tbl_general.status, tbl_general.brand, IFNULL(tbl_model.model, tbl_general.model) AS model, tbl_general.host_name, tbl_general.os, tbl_general.proc, tbl_general.ram, tbl_general.hdd, IFNULL((SELECT ip FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Ethernet') ORDER BY interface DESC LIMIT 1),'-') AS lan_ip, IFNULL((SELECT mac FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Ethernet') ORDER BY interface DESC LIMIT 1),'-') AS lan_mac, IFNULL((SELECT ip FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Wireless80211') ORDER BY interface DESC LIMIT 1),'-') AS wifi_ip, IFNULL((SELECT mac FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Wireless80211') ORDER BY interface DESC LIMIT 1),'-') AS wifi_mac, tbl_general.id_number, tbl_general.name, tbl_general.dept, CONCAT(tbl_general.site,CASE IFNULL(sub_site,'') WHEN '' THEN '' ELSE CONCAT(' - ',tbl_general.sub_site) END) AS site, tbl_general.device_status, tbl_general.gfx_card, tbl_general.remarks")
        ->leftJoin("tbl_model",[
            ["tbl_general.model","=","tbl_model.mc_model"],
            ["tbl_general.brand","=","tbl_model.brand"],
        ])
        ->orderByRaw("status, type, model");

        return Datatables::of($assets)->make(true);
    }

    public function load_software($id)
    {
        $sw = Software::selectRaw("rowid, install_date, app_name, version, install_type")
                            ->where("id",$id)
                            ->orderByRaw("app_name");

        return Datatables::of($sw)->make(true);
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
        $data = [];
        $data['asset'] = Assets::find($id);

        return view('assets.computers.view', $data);
    }

    public function create() {
        return view('assets.computers.create');
    }

    public function edit($id) {
        $data = [
            "id" => $id,
        ];

        return view('assets.computers.edit',$data);
    }

    public function getDetails($id)
    {
        //
        $details = Assets::find($id);

        return Response::json($details);
    }

    public function saveAsset(Request $request) {
        $asset_item = Assets::updateOrCreate(
                            [
                                'serial' => $request->serial
                            ],
                            [
                                'type' => $request->type, 
                                'brand' => $request->brand,
                                'model' => $request->model,
                                'os' => $request->os,
                                'host_name' => $request->host_name,
                                'id_number' => $request->id_number,
                                'name' => $request->name,
                                'dept' => $request->dept,
                                'site' => $request->site,
                                'sub_site' => $request->sub_site,
                                'status' => $request->status,
                                'device_status' => $request->device_status,
                                'proc' => $request->proc,
                                'ram' => $request->ram,
                                'hdd' => $request->hdd,
                                'gfx_card' => $request->gfx_card,
                                'remarks' => $request->remarks,
                            ]
                        );

        return Response::json($asset_item);
    }

    public function saveNetwork(Request $request) {
        $asset_network = NetInterface::updateOrCreate(
                    [
                        'id' => $request->id,
                        'mac' => $request->mac,
                    ],
                    [
                        'ip' => $request->ip, 
                        'name' => $request->name,
                        'descr' => $request->descr,
                        'interface' => $request->interface,
                    ]
                );

        return Response::json($asset_network);
    }

    public function deleteNetwork(Request $request) {
        $deleted = NetInterface::whereNotIn("rowid",$request->IDs)->delete();
        return Response::json($deleted);
    }

    public function saveDisks(Request $request) {
        $asset_disk = HDDPartitions::updateOrCreate(
                    [
                        'id' => $request->id,
                        'root_dir' => $request->root_dir,
                    ],
                    [
                        'capacity' => $request->capacity, 
                        'free_space' => $request->free_space,
                    ]
                );

        return Response::json($asset_disk);
    }

    public function deleteDisks(Request $request) {
        $deleted = HDDPartitions::whereNotIn("rowid",$request->IDs)->delete();
        return Response::json($deleted);
    }

    public function saveApps(Request $request) {
        $asset_apps = Software::updateOrCreate(
                    [
                        'id' => $request->id,
                        'app_name' => $request->app_name,
                    ],
                    [
                        'install_date' => $request->install_date, 
                        'version' => $request->version,
                        'install_type' => $request->install_type,
                    ]
                );

        return Response::json($asset_apps);    
    }

    public function deleteApps(Request $request) {
        $deleted = Software::whereNotIn("rowid",$request->IDs)->delete();
        return Response::json($deleted);
    }

    public function check($serial) {
        $exists = Assets::where("serial",$serial)->exists();
        $msg = ($exists ? "This serial already exists" : "");

        return Response::json($msg);
    }
}
