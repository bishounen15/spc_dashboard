<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view ('pages.index');
    }

    public function Summary(){
        return view ('pages.Summary');
    }
    public function pulltest(){
        return view ('pages.pulltest');
    }
    public function lamdata(){
        return view ('pages.lamdata');
    }
}
