<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parts;
use App\Models\Entries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        // return $data = DB::connection('sqlsrv')->table('Users')->get();
        $query = Entries::query();

        // Apply department filter
        if ($request->has('department') && $request->department != 'All') {
            $query->where('department', $request->department);
        }

        // Apply status filter
        if ($request->has('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        $entries = $query->get();

        // Check if the request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.entries', compact('entries'))->render()
            ]);
        }

        return view('welcome', compact('entries'));
    }

    public function manual_imput(Request $request)
    {
        $dataId = $request->input('id');
        $fieldName = $request->input('field');
        $value = $request->input('value');

        // Find the entry by its ID
        $entry = Entries::find($dataId);

        if ($entry) {
            // Update the specific field
            $entry->{$fieldName} = $value;
            $entry->save();

            return response()->json(['message' => 'Field updated successfully.']);
        } else {
            return response()->json(['message' => 'Entry not found.'], 404);
        }
    }

    public function data_center()
    {
        $parts = Parts::all();
        $customer = DB::table('customers')->get();
        return view('data-center', compact('parts', 'customer'));
    }

    public function post_data_center(Request $request)
    {
        $validatedData = $request->validate([
            'part_number' => 'required|unique:entries,part_number',
            'customer' => 'required|string|max:255',
            'revision' => 'required|string|max:255',
            'ids' => 'required|string|max:255',
            'process' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'work_centre_1' => 'nullable',
            'work_centre_2' => 'nullable',
            'work_centre_3' => 'nullable',
            'work_centre_4' => 'nullable',
            'work_centre_5' => 'nullable',
            'work_centre_6' => 'nullable',
            'work_centre_7' => 'nullable',
            'outside_processing_1' => 'nullable',
            'outside_processing_2' => 'nullable',
            'outside_processing_3' => 'nullable',
            'outside_processing_4' => 'nullable',
            'material' => 'nullable|string|max:255',
            'pc_weight' => 'nullable|numeric',
            'safety_shock' => 'nullable|numeric',
            'moq' => 'nullable|numeric',
            'order_notes' => 'nullable|string',
            'part_notes' => 'nullable|string',
            'future_raw' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $existingEntry = Entries::where('customer', $validatedData['customer'])
            ->where('part_number', $validatedData['part_number'])
            ->first();

        if ($existingEntry) {
            return redirect()->back()->with('error', 'This Part Number already exists.');
        }
        try {
            Entries::create($validatedData);
            return redirect()->back()->with('success', 'Part created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function calender()
    {
        return view('calender');
    }

    public function input_screen()
    {
        $parts = Parts::all();
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

