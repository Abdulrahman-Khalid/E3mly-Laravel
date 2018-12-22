<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirct('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->Validate($request, [
            'body' => 'required',
            'work_file' => 'nullable|max:1999', //< 2mb as apache doesn't allow         
        ]);
        //Handle File Upload
        if($request->hasFile('work_file'))
        {   
            $file = $request->file('work_file');
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
                $path = $file->storeAs('public/MessageDescriptions', $fileNameToStore);
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
        $user_id = Auth::id();
        $project_id = (int)$request->input('project_id');
        $created_at = Carbon::now('Africa/Cairo')->toDateTimeString();
        $check = CustomDB::getInstance()->insert("messages", array(
            'body' => $body,
            'user_id' => $user_id,
            'project_id' => $project_id,
            'created_at' => $created_at,
            'work_file' => $fileNameToStore,
        ))->e();

        if($check) {
            //for notifcations
            //$result = CustomDB::getInstance()->get(["max(id) as id"],"messages")->e()->first();
            //$last_id = (int)$result->id;
            //notifications
            $result = CustomDB::getInstance()->get(['craftman_id','customer_id'], "projects")->where("id = ?",[$project_id])->e()->first();
            if((int)$result->customer_id == $user_id)
            {
                $result = CustomDB::getInstance()->get(['id'], "users")->where("id = ?",[$result->craftman_id])->e()->first();
            }
            else
            {
                $result = CustomDB::getInstance()->get(['id'], "users")->where("id = ?",[$result->customer_id])->e()->first();
            }
            $userIDToNotify = $result->id;
            CustomDB::getInstance()->insert("notifications", array(
                'user_id' => $userIDToNotify,
                'project_id' => $project_id,
                'type' => 3,
                'created_at' => $created_at,
            ))->e();

            return back()->with('success', 'Message Created'); //will change
        }
        return back()->with('error', 'Message Failed'); //will change
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$messages = CustomDB::getInstance()->get(array("*"), "messages")->where("id = ?",[$id])->e()->results();
        //return view('message.show')->with('messages', $messages);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        //$check = CustomDB::getInstance()->query("DELETE FROM messages WHERE id = ?", [$id]);
        $check = CustomDB::getInstance()->delete("messages")->where("id = ?", [$id])->e();
        if($check) {
            return back()->with('success', 'Message Removed');
        } 
        return back()->with('error', 'Message Not Removed');
    }
}
