<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Proposal; 
use Carbon\Carbon;
use DB;
Use App\Helpers\DB\CustomDB;


class ProposalController extends Controller
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
        return view('home')->with('user', $user)->with('userPosts', $posts)->with('userProjects',$projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->Validate($request, [
            'body' => 'required',
            'cost' => 'required',
            'description_file' => 'nullable|max:1999', //< 2mb as apache doesn't allow         
        ]);
        //Handle File Upload
        if($request->hasFile('description_file'))
        {
            $file = $request->file('description_file');
            //get file name with ext
            $fileNameWithExt = $file->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $file->guessClientExtension();
            if($extension == 'pdf')
            {
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                $fileNameToStore = urlencode($fileNameToStore);
                //upload file
                $path = $file->storeAs('public/ProjectDescriptions', $fileNameToStore);
            }
            else
            {
                $fileNameToStore = 'nofile.pdf';
            }
        }
        else    
        {
            $fileNameToStore = 'nofile.pdf';
        }
        $body = $request->input('body');
        $cost = (int)$request->input('cost');
        $user_id = Auth::id();
        $post_id = $_POST['post_id'];
        $created_at = Carbon::now('Africa/Cairo')->toDateTimeString();
        
        
        $check = CustomDB::getInstance()->insert("proposals", array(
            'user_id' => $user_id,
            'post_id' => $post_id,
            'body' => $body,
            'cost' => $cost,
            'details_file' => $fileNameToStore,
            'created_at' => $created_at,
        ))->e();
        if($check) {
            //for notifications
            //$result = CustomDB::getInstance()->get(["max(id) as id"], "proposals")->e()->first();
            //$last_id = (int)$result->id;

            //get the user id of the one who posted the post
            $result = CustomDB::getInstance()->get(["user_id"], "posts")->where("id = ?", [$post_id])->e()->first();
            $user_id_post = $result->user_id;
            
            //notifications
            //type 1 is proposal is sent
            CustomDB::getInstance()->insert("notifications", array(
                'user_id' => $user_id_post,
                'post_id' => $post_id,
                'type' => 1,
                'created_at' => $created_at,
            ))->e();

            return redirect('/posts')->with('success', 'Proposal Sent');
        }
        return redirect('/posts')->with('error', 'Proposal not created successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::id();
        $sql = CustomDB::getInstance()->query("SELECT title, name, proposals.body as body, proposals.created_at as created_at, proposals.id as id, cost, details_file FROM `proposals`,`posts`,`users` WHERE posts.id = ? and post_id = posts.id and posts.user_id = ? and proposals.user_id = users.id ORDER BY proposals.created_at DESC",[$id, $user_id]);
        $proposals = $sql->results();
        return view('proposals.show')->with('proposals', $proposals);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposal = CustomDB::getInstance()->query("SELECT * FROM proposals WHERE id = ?",[$id])->results();
        $proposal = $proposal[0];
        return view('proposals.edit')->with('proposal',$proposal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation
        $this->Validate($request, [
            'body' => 'required',
            'cost' => 'required',        
        ]);
        $body = $request->input('body');
        $cost = (int)$request->input('cost');

        $check = CustomDB::getInstance()->query("UPDATE proposals SET body = ?, cost = ? WHERE id = ? ",[$body, $cost, $id])->results();
        return redirect('/home')->with('success', 'Proposal updated successfully');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $id = (int)$id;
       $post_id = CustomDB::getInstance()->query("SELECT posts.id as id from posts, proposals where posts.id = post_id and proposals.id = ?", [$id])->results();
        $check = CustomDB::getInstance()->delete("proposals")->where("id = ?", [$id])->e();
        var_dump($post_id);
        if($check) {
            return back()->with('success', 'Proposal declined successfully');
        } 
            return back()->with('error', 'Failed to decline proposal');
    }
}
