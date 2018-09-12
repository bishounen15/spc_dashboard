<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assets;

use DataTables;

class AssetsController extends Controller
{
    //
    public function index() {
        return view('assets.computers.index');
    }

    public function load()
    {
        $assets = Assets::selectRaw("tbl_general.id, tbl_general.serial, tbl_general.type, tbl_general.status, tbl_general.brand, IFNULL(tbl_model.model, tbl_general.model) AS model, tbl_general.host_name, tbl_general.os, tbl_general.proc, tbl_general.ram, tbl_general.hdd, IFNULL((SELECT ip FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Ethernet') ORDER BY interface DESC LIMIT 1),'-') AS lan_ip, IFNULL((SELECT mac FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Ethernet') ORDER BY interface DESC LIMIT 1),'-') AS lan_mac, IFNULL((SELECT ip FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Wireless80211') ORDER BY interface DESC LIMIT 1),'-') AS wifi_ip, IFNULL((SELECT mac FROM tbl_network WHERE id = tbl_general.id AND interface IN ('Wireless80211') ORDER BY interface DESC LIMIT 1),'-') AS wifi_mac, tbl_general.id_number, tbl_general.name, tbl_general.dept")
        ->leftJoin("tbl_model",[
            ["tbl_general.model","=","tbl_model.mc_model"],
            ["tbl_general.brand","=","tbl_model.brand"],
        ])
        ->orderByRaw("status, type, model");

        return Datatables::of($assets)->make(true);
    }
}
