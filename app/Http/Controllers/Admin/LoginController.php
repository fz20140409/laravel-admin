<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/admin/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //重写
    public function showLoginForm()
    {
        return view('admin.login.login');
    }

    protected function attemptLogin(Request $request)
    {
        if ($this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        )
        ) {
            $user = Auth::user();
            $user->ip = ip2long($request->getClientIp());
            $user->last_time=date('Y-m-d H:i:s',time());
            $user->save();
            return true;
        }
        return false;
    }
}
