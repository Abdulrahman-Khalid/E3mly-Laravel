<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ModeratorLoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest:moderator')->except('logout'); //elle y3rafo y access de hma el nas elle m4 login in as moderator
    }

    public function showLoginForm() {
        return view('auth.moderator-login');
    }   

    public function login(Request $request) {
        $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:6',
        ]);

        if(Auth::guard('moderator')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('moderator.dashboard')); //intended btwadeh b3d lma y login 3ala el page elle kan ray7ha f login page zahrtlo
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('moderator')->logout();
        return redirect('/');
    }
}