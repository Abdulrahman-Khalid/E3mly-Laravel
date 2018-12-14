<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
