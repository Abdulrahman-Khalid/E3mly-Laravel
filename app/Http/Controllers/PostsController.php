<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Post; //for using model functions
use Carbon\Carbon;
use DB;
Use App\Helpers\DB\CustomDB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //From Evram:
            //I have to remove this main previlage, and type a certain previlage for each function,
            //34an Mod. and admin y2dro y-access Destroy function
            $this->middleware('auth'); //redirect to login page if not logged in 
            $this->middleware('auth:admin')->only('destroy');
    }

    public function index()
    {
       
            $posts = CustomDB::getInstance()->get(array("*"),"posts")->order("created_at DESC")->e()->results();
            return view('posts.index')->with('posts', $posts);
            //another code
            //$posts = Post::orderBy('created_at', 'desc')->paginate(5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
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
            'title' => 'required',
            'body' => 'required',
            'min_cost' => 'required',
            'max_cost' => 'required',
            'period' => 'required',
            'category' => 'required',
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
        $title = $request->input('title');
        $body = $request->input('body');
        $min_cost = (int)$request->input('min_cost');
        $max_cost = (int)$request->input('max_cost');
        $period = (int)$request->input('period');
        $user_id = Auth::id();
        $category = htmlspecialchars($request->input('category'),ENT_NOQUOTES, 'UTF-8'); //to avoid xxs attacks
        $created_at = Carbon::now()->toDateTimeString();
        
        /*$check = CustomDB::getInstance()->query(
           "INSERT INTO `posts`(`title`, `body`, `min_cost`, `max_cost`, `description_file`, `period`, `user_id`, `category`, `created_at`) 
        VALUES (?, ? , ?, ? , ?, ?, ?, ? ,?)", [$title, $body, $min_cost, $max_cost, $fileNameToStore, $period, $user_id, $category, $created_at]);*/
        $check = CustomDB::getInstance()->insert("posts", array(
            'title' => $title,
            'body' => $body,
            'min_cost' => $min_cost,
            'max_cost' => $max_cost,
            'description_file' => $fileNameToStore,
            'period' => $period,
            'user_id' => $user_id,
            'category' => $category,
            'created_at' => $created_at
        ))->e();
        return redirect('/posts')->with('success', 'Post Created');

        if($check) {
            return redirect('/posts')->with('success', 'Post Created');
        }
        return redirect('/posts')->with('error', 'Post Failed');
        
        //another way
       /* DB::insert("INSERT INTO `posts`(`title`, `body`, `min_cost`, `max_cost`, `description_file`, `period`, `user_id`, `category`, `created_at`) 
        VALUES (?, ? , ?, ? , ?, ?, ?,  ? ,?)",[$title, $body, $min_cost, $max_cost, $fileNameToStore, $period, $user_id, $category, $created_at]);*/

        //another way
        /*
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->min_cost = (int)$request->input('min_cost');
        $post->max_cost = (int)$request->input('max_cost');
        $post->period = (int)$request->input('period');
        $post->category = $request->input('category');
        $post->user_id = Auth::id();
        $post->save();  
        */      
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $sql = CustomDB::getInstance()->get(array("*"), "posts")->where("id = ?",[$id])->e();
            $post = $sql->results();
            return view('posts.show')->with('post', $post);
            //another code
            //$post = Post::find($id);  
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            //$check = CustomDB::getInstance()->query("DELETE FROM posts WHERE id = ?", [$id]);
            $check = CustomDB::getInstance()->delete("posts")->where("id = ?", [$id])->e();
            if($check)
            {
                //Evram: I change the redirecting path, 34an lma ymsa7 feedback
                return redirect('/')->with('success', 'Post Removed');
            } 
            else
                return redirect('/')->with('error', 'Post Not Removed');
            //another code
            /*
            $post = Post::find($id);
            $post->getInstance()->delete();
            */
       
      
    
}
