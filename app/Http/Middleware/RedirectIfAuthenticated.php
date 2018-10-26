<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        switch ($guard) { //to redirect u if you type for example .com/admin/login while you logged in as admin it redirects u to admin dashboard
            case 'web': //try to access as user .com/login
            if(Auth::guard($guard) ->check()) { // if you are user it will redirects u to home page if you are not it will let you enter .com/login
                return redirect('/home');
            }
            break;
            case 'moderator':
                if(Auth::guard($guard) ->check()) {
                    return redirect(route('moderator.dashboard'));
                }
                break;
            case 'admin':
                if(Auth::guard($guard) ->check()) {
                    return redirect(route('admin.dashboard'));
                }
                break;
        }

        return $next($request);
    }
}
