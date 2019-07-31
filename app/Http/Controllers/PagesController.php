<?php

namespace App\Http\Controllers;

use Request;

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

    public function apps(){
        return view ('pages.apps');
    }

    public function link(){
        return view ('pages.link');
    }
    
    public function lamdata(){
        return view ('pages.lamdata');
    }
    public function pulltestdata(){
        return view ('pages.pulltestdata');
    }

    public function myip() {
        return Request::ip();
    }
}
