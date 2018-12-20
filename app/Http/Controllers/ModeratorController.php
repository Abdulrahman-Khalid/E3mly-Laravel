<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Moderator; //for using model functions
use Carbon\Carbon;
use DB;
Use App\Helpers\DB\CustomDB;

class ModeratorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:moderator'); //only moderator can access
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //view all posts for him
        $sql =  CustomDB::getInstance()->query("SELECT 
                posts.id as id,posts.title as title,posts.created_at as created_at,
                users.id as user_id, users.name as user_name
                FROM (`users` JOIN `posts`)
                WHERE  users.id = posts.user_id
                order by(posts.created_at ) " 
            );

         $posts = $sql->results();
        return view('moderator')->with('posts', $posts);
    }
}
