<?php

namespace App\Http\Controllers;

use App\Models\Parts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PartnumberController extends Controller
{
    public function index()
    {

        $parts = DB::table('parts')->paginate(10);
        $customer = DB::table('customers')->paginate(10);
        $department = DB::table('department')->get();

        // dd($parts);
        return view('partsnumber.index', compact('parts', 'customer', 'department'));
    }

}
