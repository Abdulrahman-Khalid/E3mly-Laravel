<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB ;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin'); //only admin can access
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //some statistics 
        /*
        1-users
        2-moderators
        3-posts
        4-projects
        */
        $sql =  CustomDB::getInstance()->query("SELECT count(*)as posts_count   FROM (`posts`) ") ;
        $posts = $sql->results();
        $posts_count = $posts[0]->posts_count;
        
        $sql0 =  CustomDB::getInstance()->query("SELECT count(*)as project_count   FROM (`projects`) ") ;
        $projects = $sql0->results();
        $project_count = $projects[0]->project_count;

        $sql1 =  CustomDB::getInstance()->query("SELECT count(*)as users_count   FROM (`users`) ") ;
        $users = $sql1->results();
        $users_count = $users[0]->users_count;
                
        $sql2 =  CustomDB::getInstance()->query("SELECT count(*)as mod_count   FROM (`moderators`) ") ;
        $moderators = $sql2->results();
        $mod_count = $moderators[0]->mod_count;

        $sql3 =  CustomDB::getInstance()->query("SELECT count(*)as feeds   FROM (`feedbacks`) ") ;
        $feedbacks = $sql3->results();
        $feeds = $feedbacks[0]->feeds;

        $sql4 =  CustomDB::getInstance()->query("SELECT count(*)as running_projects   FROM (`projects`) WHERE status = 0") ;
        $projects1 = $sql4->results();
        $running_projects= $projects1[0]->running_projects;

        $sql4 =  CustomDB::getInstance()->query("SELECT count(*)as pending_projects   FROM (`projects`) WHERE status = 1") ;
        $projects2 = $sql4->results();
        $pending_projects = $projects2[0]->pending_projects;

        $sql5 =  CustomDB::getInstance()->query("SELECT count(*)as finished_projects   FROM (`projects`) WHERE status = 2") ;
        $projects3 = $sql5->results();
        $finished_projects = $projects3[0]->finished_projects;

        $counts=array("posts_count"=>$posts_count,
                      "project_count"=>$project_count,
                      "users_count"=>$users_count,
                      "mod_count"=>$mod_count, 
                      "feeds"=>$feeds,
                      "running_projects"=>$running_projects,
                      "pending_projects"=>$pending_projects,
                      "finished_projects"=>$finished_projects  );

        return view('admin')->with('counts',$counts);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function event()
    {
        //here we need admin's id 
        $admin_id = Auth::guard('admin')->id();
        $sql =  CustomDB::getInstance()->query("SELECT admins.announcement as adminevent  FROM (`admins`) WHERE id = ?",[$admin_id]) ;
        $admin_event = $sql->results();
      //  die (var_dump($admin_event[0]->adminevent));
        $event = array ("body"=>$admin_event[0]->adminevent,
                          "id"=>$admin_id);
       // die (var_dump($event['body']));
        return view ('adminEvent')->with ('event',$event);

    }
    
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addevent(Request $request)
    {


    if(Auth::guard('admin')->check())
      {
       
        $event = $request->input('event');
        $id = $_POST['admin_id'];
       // die (var_dump($event));
        
        //$sql =  CustomDB::getInstance()->query("UPDATE admins SET (`event=?`) WHERE id = ?",[$event,$id]) ;
        $check = CustomDB::getInstance()->query("UPDATE admins SET admins.announcement = ? WHERE id = ? ",[$event, $id])->results();
        
      
            return redirect('/')->with('success', 'Event updated');
        
    }
    else 
         return redirect('/');  
    }

}
