<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;
Use App\Helpers\Files\file;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = CustomDB::getInstance()->get(array("*"),"messages")->order("created_at")->e()->results();
        return view('project.index')->with('messages', $messages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id)
    {
        $this->Validate($request, [
            'body' => 'required',
            'description_file' => 'nullable|max:1999', //< 2mb as apache doesn't allow         
        ]);
        //Handle File Upload
        $body = $request->input('body');
        $user_id = Auth::id();
        $created_at = Carbon::now()->toDateTimeString();
        $fileNameToStore = file::upload($request->hasFile('description_file'));
        $check = CustomDB::getInstance()->insert("messages", array(
            'body' => $body,
            'user_id' => $user_id,
            'project_id' => $project_id,
            'created_at' => $created_at,
            'description_file' => $fileNameToStore,
        ))->e();
        if($check) {
            return redirect('/messages')->with('success', 'Message Created'); //will change
        }
        return redirect('/messages')->with('error', 'Message Failed'); //will change
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = CustomDB::getInstance()->get(array("*"), "messages")->where("id = ?",[$id])->e()->results();
        return view('message.show')->with('messages', $messages);
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
        //$check = CustomDB::getInstance()->query("DELETE FROM posts WHERE id = ?", [$id]);
        $check = CustomDB::getInstance()->delete("messages")->where("id = ?", [$id])->e();
        if($check) {
            return redirect('/project')->with('success', 'Message Removed');
        } 
        return redirect('/project')->with('error', 'Message Not Removed');
    }
}
