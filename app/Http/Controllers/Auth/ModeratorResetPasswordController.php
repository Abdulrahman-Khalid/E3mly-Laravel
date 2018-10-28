<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Password;
use Auth; //login and redirect moderators
use Illuminate\Http\Request;

class ModeratorResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/moderator';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:moderator');
    }

    protected function broker() {
        return Password::broker('moderators');
    }

    protected function guard() {
        return Auth::guard('moderator');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset-moderator')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
