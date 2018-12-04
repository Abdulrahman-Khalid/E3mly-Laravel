<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB ;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;
use App\feedback;

class FeedbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //$this->middleware('auth');
       // $this->middleware('auth:admin');
        //redirect to login page if not logged in 
    }

    public function index()
    {
        //Only admins and moderators has the right to access the feedback
        //so, when a user attempts to access it, he gets redirected to the home page



        if(Auth::guard('admin')->check()||Auth::guard('moderator')->check())
           { 
                $feedbacks = CustomDB::getInstance()->get(array("*"),"feedbacks")->order("created_at DESC")->e()->results();
                return  view('feedback.index')->with('feedbacks', $feedbacks);
            }       
        else
           return redirect('/');
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
     
        $id = $request->input('post_id');   
       if(Auth::guard('web')->check()||Auth::guard('moderator')->check())
            return view('feedback.createfeedback')->with('post_id',$id);
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


        //I need the post_id and user_id from its relation
        //first , i need post_id from as a POST method
        $this->Validate($request, [
            'name' => 'required',
            'body' => 'required'
        ]);

        $user_id = Auth::id();
        $created_at = Carbon::now()->toDateTimeString();  
        $title = $request->input('name');
        $body = $request->input('body');    
        $post_id = $request->input('post_id');
        $check = CustomDB::getInstance()->insert("feedbacks", array(
           'type' => $title,
            'body' => $body,
            'user_id' => $user_id,
            'post_id'=> $post_id,            
            'created_at' => $created_at

        ))->e();
        
/*
        DB::insert('insert into feedbacks (type,body,user_id,created_at) values (?,?,?,?)', [$title,$body,$user_id,$created_at]);
*/
        if($check) {
            return redirect('/')->with('success', 'Feedback submitted');
        }
        return redirect('/')->with('error', 'Feedback Failed to be Submitted');
        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sql = CustomDB::getInstance()->get(array("*"), "feedbacks")->where("id = ?",[$id])->e();
        $feedback = $sql->results();
       // return $feedback;
        return view('feedback.showfeedback')->with('fb', $feedback);
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
        //
    }
}
