<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function signin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|max:250',
            'password' => 'required|min:6',
            'department' => 'required',
            'phone' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->password,
            'department' => $request->input('department'),
            'phone' => $request->input('phone'),
            'successful_payments' => $request->filled('successful_payments') ? 1 : 0,
            'payouts' => $request->filled('payouts') ? 1 : 0,
            'fee_collection' => $request->filled('fee_collection') ? 1 : 0,
            'customer_payment_dispute' => $request->filled('customer_payment_dispute') ? 1 : 0,
            'refund_alerts' => $request->filled('refund_alerts') ? 1 : 0,
            'invoice_payments' => $request->filled('invoice_payments') ? 1 : 0,
            'webhook_api_endpoints' => $request->filled('webhook_api_endpoints') ? 1 : 0,
        ]);

        // dd($user);

        auth()->login($user);

        return redirect()->route('index');
    }


    public function login()
    {
        return view('authlogin.login');
    }


    public function loginuser(Request $request)
    {

        $auth = $request->validate([
            'email' => 'required|email|max:250',
            'password' => 'required',
        ]);


        if (Auth::attempt($auth)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }


        return redirect()->back();
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}


