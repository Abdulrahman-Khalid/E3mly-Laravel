<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB ;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;
use App\User;
=
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::guard('web')->check())
        {
           

        $user = Auth::user();
        $user_id = Auth::id();
        $posts = CustomDB::getInstance()->query("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC",[$user_id])->results();
        return view('home')->with('user', $user)->with('userPosts', $posts);
    }

    }

   
}
