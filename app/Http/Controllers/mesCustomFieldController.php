<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mesCustomFieldController extends Controller
{
    //

    public function index() {
        return view('mes.setup.fields.index');
    }
}
