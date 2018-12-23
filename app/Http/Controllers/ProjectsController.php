<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
Use App\Helpers\DB\CustomDB;

class ProjectsController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth'); //redirect to login page if not logged in 
    }

    public function index()
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $posts = CustomDB::getInstance()->query("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC",[$user_id])->results();
        $projects = CustomDB::getInstance()->query("SELECT * FROM projects WHERE customer_id = ? OR craftman_id = ?",[$user_id,$user_id])->results();
        $sentProposals = CustomDB::getInstance()->query("SELECT proposals.id as id, title, proposals.created_at as created_at FROM proposals, posts WHERE proposals.user_id = ? and posts.id = proposals.post_id ORDER BY proposals.created_at DESC",[$user_id])->results();
        return view('home')->with('user', $user)->with('userPosts', $posts)->with('userProjects',$projects)->with('sentProposals',$sentProposals);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //first, copy the needed data to initialize the project
        $Proposal_id = $_POST['proposal_id'];
        $info = CustomDB::getInstance()->query("SELECT title,posts.body as body, proposals.cost as cost, description_file, period, proposals.user_id as craftman, category, posts.id as post_id_original FROM proposals,posts WHERE posts.id = post_id and proposals.id = ?",[$Proposal_id])->results();
        
        $title = $info[0]->title;
        $body = $info[0]->body;
        $cost = $info[0]->cost;
        $description_file = $info[0]->description_file;
        $period = $info[0]->period;
        //calculate suppose_to_finish date
        $created_at = Carbon::now('Africa/Cairo')->toDateTimeString();
        $info2 = CustomDB::getInstance()->query("SELECT DATE_ADD(?, INTERVAL ? day) AS DateAdd",[$created_at,$period])->results();
        $suppose_to_finish = $info2[0]->DateAdd;
        $customer_id = Auth::id();
        $craftman_id = $info[0]->craftman;
        $category = $info[0]->category;

        $post_id_to_be_deleted = $info[0]->post_id_original;

        //second, take the points from the customer
        $user_id = Auth::id();
        $project_cost = (int)($cost);
        $customers_current_points = CustomDB::getInstance()->query("SELECT points FROM users WHERE id = ?",[$user_id])->results();
        $customers_current_points = (int)($customers_current_points[0]->points);
        $customers_current_points = $customers_current_points - $project_cost;
        $sql = CustomDB::getInstance()->query("UPDATE users SET points = ? WHERE id = ?",[$customers_current_points, $user_id])->results();

        //third, create the project

        $check = CustomDB::getInstance()->insert("projects", array(
            'title' => $title,
            'body' => $body,
            'cost' => $cost,
            'description_file' => $description_file,
            'suppose_to_finish' => $suppose_to_finish,
            'craftman_id' => $craftman_id,
            'customer_id' => $customer_id,
            'category' => $category,
            'created_at' => $created_at
        ))->e();

        $id = CustomDB::getInstance()->query("SELECT id FROM projects WHERE craftman_id = ? and customer_id = ? and created_at = ?", [$craftman_id,$customer_id,$created_at])->results();
        $id = $id[0]->id;
        //finally, delete the post with its proposals
        $check1 = CustomDB::getInstance()->delete("posts")->where("id = ?", [$post_id_to_be_deleted])->e();

        if($check && $check1) {
            //notification porposal is accepted
            //type 1 proposal is sent, 2 porposal is accepted, 3 message 
            CustomDB::getInstance()->insert("notifications", array(
                'user_id' => $craftman_id,
                'project_id' => $id,
                'type' => 2,
                'created_at' => $created_at,
            ))->e();
            return redirect()->route('projects.show', $id)->with('success', 'Project Initiated Successfully');
        }
        return redirect()->route('projects.show', $id)->with('error', 'Project Initiation Unsuccessfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::id();
        $projects = CustomDB::getInstance()->query("SELECT * FROM projects WHERE id = ?",[$id])->results();
        $craftman = CustomDB::getInstance()->query("SELECT * FROM users WHERE id = ?",[$projects[0]->craftman_id])->results();
        $customer = CustomDB::getInstance()->query("SELECT * FROM users WHERE id = ?",[$projects[0]->customer_id])->results();
        $messages_users = CustomDB::getInstance()->get(array("messages.*",'users.name'),"messages,users")->where("messages.project_id = ? and messages.user_id = users.id",[$id])->order("messages.created_at")->e()->results();
        return view('projects.show')->with('project',$projects[0])->with('user_id',$user_id)->with('craftman',$craftman[0])->with('customer',$customer[0])->with('messages_users', $messages_users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $projects = CustomDB::getInstance()->query("SELECT * FROM projects WHERE id = ?",[$id])->results();
        $project = $projects[0];

        if($project->status == 0){
            $check = CustomDB::getInstance()->query("UPDATE projects SET status = 1 WHERE id = ?",[$id])->results();
            return redirect()->route('projects.show', $id)->with('success', "Wait for the customer's acceptance");
        }

        if($project->status == 1){
            $this->Validate($request, [
            'rating' => 'required',       
            ]);
            $rating = (float)($request->input('rating'));
            $craftsman_points = $project->cost;
            $craftsman_current_points = CustomDB::getInstance()->query("SELECT points FROM users WHERE id = ?",[$project->craftman_id])->results();
            $craftsman_current_points = $craftsman_current_points[0]->points;
            $craftsman_points = $craftsman_points + $craftsman_current_points;
            $finish_date = Carbon::now('Africa/Cairo')->toDateTimeString();

            $sql = CustomDB::getInstance()->query("UPDATE projects SET finish_date = ? , status = 2, rating = ? WHERE id = ?",[$finish_date,$rating,$id])->results();
            $sql1 = CustomDB::getInstance()->query("UPDATE users SET points = ? WHERE id = ?",[$craftsman_points, $project->craftman_id])->results();
            $sql2 = Customdb::getInstance()->query("UPDATE users SET num_finished_projects = num_finished_projects + 1 WHERE id = ?",[$project->craftman_id])->results();
            $sql3 = Customdb::getInstance()->query("UPDATE users SET num_finished_projects = num_finished_projects + 1 WHERE id = ?",[$project->customer_id])->results();
            $sql4 = Customdb::getInstance()->query("UPDATE users SET rating = rating + ? / num_finished_projects WHERE id = ?",[$rating,$project->craftman_id])->results();
           
            return redirect()->route('projects.show', $id)->with('success', 'Congratulations on finishing the project');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}