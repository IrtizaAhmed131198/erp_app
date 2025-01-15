<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'user_img' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('user_img')) {
            $image = $request->file('user_img');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imagename);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'add_by' => Auth::user()->id,
            'department' => $request->input('department'),
            'phone' => $request->input('phone'),
            'user_img' => $imagename ?? null,
            'status_column' => $request->filled('status_column') ? 1 : 0,
            'stock_finished_column' => $request->filled('stock_finished_column') ? 1 : 0,
            'part_number_column' => $request->filled('part_number_column') ? 1 : 0,
            'calendar_column' => $request->filled('calendar_column') ? 1 : 0,
            'user_maintenance' => $request->filled('user_maintenance') ? 1 : 0,
            'visual_input_screen' => $request->filled('visual_input_screen') ? 1 : 0,
            'input_screen_column' => $request->filled('input_screen_column') ? 1 : 0,
            'create_order' => $request->filled('create_order') ? 1 : 0,
            'View_1' => $request->filled('View_1') ? 1 : 0,
            'View_2' => $request->filled('View_2') ? 1 : 0,
            'View_3' => $request->filled('View_3') ? 1 : 0,
        ]);
        // dd($user);
        // auth()->login($user);
        return redirect()->back()->with('success', 'User added!');
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


        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }


        return redirect()->back()->with('success', 'You Login successfully!');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('error', 'You Logout successfully!');
    }
}


