<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        return view('welcome');

    }

    public function data_center()
    {
        return view('data-center');
    }

    public function calender()
    {
        return view('calender');
    }

    public function input_screen()
    {
        return view('input-screen');
    }

    public function notifications()
    {
        return view('notifications');
    }

    public function visual_screen()
    {
        return view('visual-queue-screen');
    }
    public function visual_screen_1()
    {
        return view('visual-queue-screen-1');
    }

    public function visual_screen_2()
    {
        return view('visual-queue-screen-2');
    }

    public function add_user()
    {
        if (auth()->user()->role == 1) {
            return view('add-user');
        }
        return redirect()->route('index');
    }
}

