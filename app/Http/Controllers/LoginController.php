<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {

        return view('authlogin.login');
    }
    public function loginuser(Request $request)
    {

        $auth = $request->validate([
            'email' => 'required|email|max:250',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt(['email' => $auth['email'], 'password' => $auth['password']])) {
            $request->session()->regenerate();

            session()->flash('success', 'Sign In Successfully!');
            return redirect()->intended('/');
        }

        session()->flash('error', 'Invalid Credentials!');
        return redirect()->back();
    }
}
