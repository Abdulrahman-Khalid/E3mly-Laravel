<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB ;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(Auth::guard('admin')->check())
        {
            $user = CustomDB::getInstance()->get(array("*"),"users")->order("name DESC")->e()->results();
            return view('profile/index')->with('users', $user);
        }
        return redirect('/');
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if(Auth::guard('admin')->check())
        {
            $sql = CustomDB::getInstance()->get(array("*"), "users")->where("id = ?",[$id])->e();
            $user = $sql->results();
            return view('profile.show')->with('user', $user[0]);
        }
        if(Auth::guard('moderator')->check())
        {
            $post_id = (int)$id;
           // die(var_dump($post_id));
            $sql = CustomDB::getInstance()->query("SELECT user_id FROM `posts` WHERE id = ?", [$post_id])->results();
            
            $user_id = $sql;
            //die(var_dump($user_id[0]->user_id));
            $sql2 = CustomDB::getInstance()->get(array("*"), "users")->where("id = ?",[$user_id[0]->user_id])->e();
            $user = $sql2->results();
            return view('profile.show')->with('user', $user[0]);
        }


        else
         return redirect('/');
      
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

        $user_id = (int)$id;

       // $sql = CustomDB::getInstance()->get(["user_id"], "posts")->where("id = ?" ,[$post_id])->e();
        //$sql = CustomDB::getInstance()->query("SELECT user_id FROM `posts` WHERE  {id = $post_id}");
       // $user_id = $sql->results();
       // $user_id =(int) $user_ids[0];    
       // $idd = "1";
       // [$user_id[0]->user_id]
       //die(var_dump($user_id[0]));

   // die(var_dump($post_id));
        //die(var_dump([$user_id[0]->user_id]));

        $check = CustomDB::getInstance()->delete("users")->where("id = ?", [$user_id])->e();
        //$check = CustomDB::getInstance()->delete("users")->where("id = ?", [$user_id[0]->user_id])->e();
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
