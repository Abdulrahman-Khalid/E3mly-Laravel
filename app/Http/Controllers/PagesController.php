<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Proposal; //for using model functions(me)
//use DB; //for using queries(me)

class PagesController extends Controller
{
    public function index() {
        return view('pages.index');
    }

    public function createproject() {
        return view('pages.createproject');
    }
/*
    public function feedback() {
        return view('pages.feedback');
    }
*/
}
