<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB ;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;
use App\User;
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
            $posts = $user->posts();
            return view('home')->with('user', $user); // $user->posts from the relationship
        }
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //this id is the post_id in my feedback case

        $post_id = (int)$id;

        $sql = CustomDB::getInstance()->get(["user_id"], "posts")->where("id = ?" ,[$post_id])->e();
        //$sql = CustomDB::getInstance()->query("SELECT user_id FROM `posts` WHERE  {id = $post_id}");
        $user_id = $sql->results();
       // $user_id =(int) $user_ids[0];    
       // $idd = "1";
       // [$user_id[0]->user_id]
       //die(var_dump($user_id[0]));

   // die(var_dump($post_id));
        //die(var_dump([$user_id[0]->user_id]));


        $check = CustomDB::getInstance()->delete("users")->where("id = ?", [$user_id[0]->user_id])->e();
       // $check = CustomDB::getInstance()->query("DELETE from 'users' where {id = $idd}");
        //$check = CustomDB::getInstance()->query("DELETE from 'users as u,posts as p' where {p.id = $post_id}");

        if($check)
        {
            return redirect('/feedback')->with('success', 'User Removed');
        } 
        else

        return redirect('/feedback')->with('error', 'User Not Removed');
      
    }
}
