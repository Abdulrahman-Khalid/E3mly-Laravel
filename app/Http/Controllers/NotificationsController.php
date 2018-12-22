<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notification; //for using model functions
use Carbon\Carbon;
Use App\Helpers\DB\CustomDB;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $unreadNotifications = CustomDB::getInstance()->get(array("N.*"), "notifications as N")->where("N.user_id = ? and N.read = ?  ", [$user_id, 0])->order("created_at DESC")->e()->results();
        $readNotifications = CustomDB::getInstance()->get(array("N.*"), "notifications as N")->where("N.user_id = ? and N.read = ?", [$user_id, 1])->order("created_at DESC")->e()->results();

        return view('notifications.index')->with(compact('unreadNotifications', 'readNotifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CustomDB::getInstance()->query("UPDATE notifications SET notifications.read = ? WHERE id = ?", [1, $request->input('id')]);

        return redirect($request->input('link'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $check = CustomDB::getInstance()->delete("notifications")->where("id = ?", [$id])->e();
        if($check)
        {
            //Evram: I change the redirecting path, 34an lma ymsa7 feedback
            return redirect('/notifications')->with('success', 'Notification Removed');
        } 
        else
        {
            return redirect('/notifications')->with('error', 'Notification Not Removed');
        }
    }
}
