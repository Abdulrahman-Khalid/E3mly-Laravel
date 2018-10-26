<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException; //important for the added part bellow

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof AuthenticationException) { // to redirect if i typed .com/admin and i am not logged in as an admin to .com/admin/login not .com/login
             $guard = array_get($exception->guards(), 0); 
             switch($guard) {
                case 'web':
                    return redirect(route('login'));
                    break;
                case 'moderator':
                    return redirect(route('moderator.login'));
                    break;
                case 'admin':
                    return redirect(route('admin.login'));
                    break;
            } 
        }

        return parent::render($request, $exception);
    }
}
