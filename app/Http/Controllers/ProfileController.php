<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;    
use DB ;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;
use Illuminate\Support\Facades\Hash;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        
        if(Auth::guard('admin')->check())
        {
            $user = CustomDB::getInstance()->get(array("*"),"moderators")->order("name DESC")->e()->results();
            return view('profile/index2')->with('users', $user);
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
            $posts = CustomDB::getInstance()->query("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC",[$id])->results();
            $projects = CustomDB::getInstance()->query("SELECT * FROM projects WHERE customer_id = ? OR craftman_id = ?",[$id,$id])->results();
            $sentProposals = CustomDB::getInstance()->query("SELECT proposals.id as id, title, proposals.created_at as created_at FROM proposals, posts WHERE proposals.user_id = ? and posts.id = proposals.post_id ORDER BY proposals.created_at DESC",[$id])->results();
            return view('profile.show')->with('user', $user[0])->with('userPosts', $posts)->with('userProjects',$projects)->with('sentProposals',$sentProposals);
        }
        if(Auth::guard('moderator')->check())
        {
            $post_id = (int)$id;
           
            $sql =  CustomDB::getInstance()->query("SELECT 
                 user_id
                FROM (`posts`)
                WHERE posts.id = ? ", [$post_id]);
            $user_id = $sql->results();
            $user_id = $user_id[0]->user_id;
            $posts = CustomDB::getInstance()->query("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC",[$user_id])->results();

            $projects = CustomDB::getInstance()->query("SELECT * FROM projects WHERE customer_id = ? OR craftman_id = ?",[$user_id,$user_id])->results();

            $sentProposals = CustomDB::getInstance()->query("SELECT proposals.id as id, title, proposals.created_at as created_at FROM proposals, posts WHERE proposals.user_id = ? and posts.id = proposals.post_id ORDER BY proposals.created_at DESC",[$user_id])->results();
            
           
            $sql2 = CustomDB::getInstance()->get(array("*"), "users")->where("id = ?",[$user_id])->e();
            $user = $sql2->results();

            return view('profile.show')->with('user', $user[0])->with('userPosts', $posts)->with('userProjects',$projects)->with('sentProposals',$sentProposals);
        }


        else
         return redirect('/');
      
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 public function show2($id)
    {
         if(Auth::guard('admin')->check())
        {
            $sql = CustomDB::getInstance()->get(array("*"), "moderators")->where("id = ?",[$id])->e();
            $user = $sql->results();
            return view('profile.show2')->with('user', $user[0]);
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
         if(Auth::guard('admin')->check())
        {
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
        else 
            return redirect('/');
             
    }

     /**
     * Remove the specified User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy2($id)
    {
        //this id is the post_id in my feedback case
         if(Auth::guard('admin')->check())
        {
            $user_id = (int)$id;
            $check = CustomDB::getInstance()->delete("moderators")->where("id = ?", [$user_id])->e();
            if($check)
                {
                    return redirect('/feedback')->with('success', 'Moderator Removed');
                } 
                else
                return redirect('/feedback')->with('error', 'Moderator Not Removed');
              
         }
        else 
            return redirect('/');
                 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
             
      if(Auth::guard('admin')->check())
      {
           
           $user_id = $_GET['user_id']; 
           $sql = CustomDB::getInstance()->get(array("*"), "users")->where("id = ?",[$user_id])->e();
           $user = $sql->results();
          // die(var_dump($user));
           return view('profile.create')->with('user',$user[0]);
      }
       else
         return redirect('/');  
      
    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //store the moderator
        //delete the user

       
        $id = $_POST['user_id'];
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        //a query to get these by the id

        $sql =  CustomDB::getInstance()->query("SELECT 
                birthdate,gender,profile_picture,country,bio
                FROM (`users`)
                WHERE users.id = ? ", [$id]);
        $userdata = $sql->results();
       
        $birthdate=$userdata[0]->birthdate;
        $gender = $userdata[0]->gender;
        $profile_picture=$userdata[0]->profile_picture;
        $country=$userdata[0]->country;
        $bio=$userdata[0]->bio;
        $created_at = Carbon::now()->toDateTimeString();
      
    if(Auth::guard('admin')->check())
      {
           $check = CustomDB::getInstance()->insert("moderators", array(
                'email'=> $email,
                'password' => Hash::make($password),
                'name' => $name,
                'birthdate'=> $birthdate, 
                'gender' => $gender, 
                'profile_picture' => $profile_picture,  
                'country' => $country,
                'bio' => $bio,       
                'created_at' => $created_at
        ))->e();
               
        
         
        if($check) {
         CustomDB::getInstance()->delete("users")->where("id = ?", [$id])->e();
            return redirect('/')->with('success', 'Moderator cretaed');
        }
        return redirect('/')->with('error', 'Something wrong');
    }
    else 
         return redirect('/');  


    }











}
