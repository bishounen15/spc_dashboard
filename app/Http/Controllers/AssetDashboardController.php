<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Assets;

use ConsoleTVs\Charts\Classes\Chartjs\Chart as Charts;

class AssetDashboardController extends Controller
{
    //
    private $rgb = [
        '0,0,255','255,0,0','0,255,0','200,55,0','0,200,55','55,0,200','150,105,0','0,150,105','105,0,150','100,155,0',
        '0,100,155','155,0,100','50,205,0','0,50,205','50,0,205','100,100,100','255,150,50','50,150,255','255,255,0','0,255,255',
        '255,0,255','150,150,150','255,150,255','255,255,150','150,255,255',
    ];

    public function index() {
        $charts = [];

        $query_results = DB::connection('assets')->table('tbl_general')
        ->selectRaw("tbl_general.dept as category, COUNT(*) AS total")
        ->groupBy("tbl_general.dept")
        ->orderBy('total','desc')
        ->get();

        array_push($charts,$this->generateChart($query_results,'Total Computers per Department','bar', false, false));

        $query_results = DB::connection('assets')->table('tbl_general')
                                        ->selectRaw("CONCAT(tbl_general.status,' ',tbl_general.type) as category, COUNT(*) AS total")
                                        ->groupBy(DB::raw("CONCAT(tbl_general.status,' ',tbl_general.type)"))
                                        ->orderBy('category','desc')
                                        ->get();

        array_push($charts,$this->generateChart($query_results,'Computing Equipments per Type','pie', false, false));

        $query_results = DB::connection('assets')->table('tbl_general')
        ->selectRaw("tbl_general.brand as category, COUNT(*) AS total")
        ->groupBy("tbl_general.brand")
        ->orderBy('total','desc')
        ->get();

        array_push($charts,$this->generateChart($query_results,'Computers per Brand','bar', false, false));

        return view('assets.computers.dashboard',['charts' => $charts]);
    }

    private function generateChart($query_results, $title, $type, $minimalist = false, $legend = true) {
        $results = json_decode($query_results);
        $chart = new Charts;
        // Add the dataset (we will go with the chart template approach)
        $chart->title($title, 34);
        $chart->minimalist($minimalist);
        $chart->barWidth(0.75); 
        $chart->displayLegend($legend);

        $colors = [];
        $bgcolors = [];
        $data = [];
        $labels = [];
        
        $i = 0;

        foreach($results as $result) {
            array_push($colors,'rgb('.$this->rgb[$i].')');
            array_push($bgcolors,'rgba('.$this->rgb[$i].',0.6)');
            
            array_push($data,$result->total);
            array_push($labels,$result->category);
            
            // array_push($labels,$result->category . " [" . $result->total . "]");
            
            if ($i == 24) {
                $i = 0;
            } else {
                $i++;
            }
        }

        $chart->dataset('',$type, $data)->color($colors)->backgroundColor($bgcolors);
        $chart->labels($labels);
        
        return $chart;
    }
}
