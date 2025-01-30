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
        $work_center_selector = DB::table('work_center_selector')->paginate(10);
        $vendor = DB::table('vendor')->paginate(10);
        $package = DB::table('package')->paginate(10);


        // dd($parts);
        return view('partsnumber.index', compact('parts', 'customer', 'department', 'work_center_selector', 'vendor', 'package'));
    }


    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $parts = DB::table('parts')->paginate(10);
            $customer = DB::table('customers')->paginate(10);
            $department = DB::table('department')->get();
            $work_center_selector = DB::table('work_center_selector')->paginate(10);
            $vendor = DB::table('vendor')->paginate(10);
            $package = DB::table('package')->paginate(10);


            // dd($parts);
            return view('partsnumber.index', compact('parts', 'customer', 'department', 'work_center_selector', 'vendor', 'package'))->render();
        }
    }

}
