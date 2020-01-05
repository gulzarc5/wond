<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function adminLogin(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
// dd(Hash::make($request->input('password')));
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect()->intended('/admin/deshboard');
        }
        return back()->withInput($request->only('email', 'remember'))->with('login_error','Username or password incorrect');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
