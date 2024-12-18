<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parts;
use App\Models\Entries;
use App\Models\Weeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $parts = Parts::all();
        $weeks = [
            'Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8',
            'Week 9', 'Week 10', 'Week 11', 'Week 12', 'Week 13', 'Week 14', 'Week 15', 'Week 16',
            'Month 5', 'Month 6', 'Month 7', 'Month 8', 'Month 9', 'Month 10', 'Month 11', 'Month 12'
        ];
        return view('calender', compact('parts', 'weeks'));
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

    public function get_part_no_detail(Request $request)
    {
        $partNumber = $request->get('part_number');

        $entries = DB::table('entries')->where('part_number', $partNumber)->where('user_id', Auth::user()->id)->first();

        if (!$entries) {
            return response()->json(['message' => 'No entry found for the provided part number.']);
        }

        return response()->json([
            'existing_amount' => $entries->in_stock_finish
        ]);
    }

    public function update_production_total(Request $request)
    {
        $existingAmount = $request->input('existing_amount');
        $addProduction = $request->input('add_production');
        $newTotal = $request->input('new_total');
        $part_no = $request->input('part_no');

        $data = Entries::where('part_number', $part_no)->where('user_id', Auth::user()->id)->first();

        $data->in_stock_finish = $newTotal;
        $data->save();

        return response()->json([
            'message' => 'Production total updated successfully!',
            'new_total' => $newTotal
        ]);
    }

    public function create_order(Request $request)
    {
        $request->validate([
            'weeks' => 'required|array',
            'weeks.*' => 'nullable|string',
            'part_number' => 'required'
        ]);

        $exist_data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
        if($exist_data){
            return response()->json(['error' => true, 'message' => 'This part number order already exist']);
        }

        $data = new Weeks();
        $data->user_id = Auth::user()->id;
        $data->part_number = $request->part_number;

        $temp = $this->getWeekArr(date('Y-m-d'));

        foreach ($request->weeks as $key => $value) {
            $data->$key = $value;
            $data->{$key.'_date'} = $temp[$key];
        }
        $data->save();

        return response()->json(['message' => 'Shipment Order Created', 'data' => $data]);
    }

    public function add_shipment(Request $request)
    {
        $request->validate([
            'weeks' => 'required|array',
            'weeks.*' => 'nullable|string',
            'part_number' => 'required'
        ]);

        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();

        foreach ($request->weeks as $key => $value) {
            if($value != '' && $value != null){
                $data->$key = $value;
            }
        }
        $data->save();

        return response()->json(['message' => 'Shipment Order Created', 'data' => $data]);
    }

    public function get_weeks(Request $request)
    {
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
        $entries = Entries::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();

        $Arr = [
            "week_1" => $data->week_1,
            "week_2" => $data->week_2,
            "week_3" => $data->week_3,
            "week_4" => $data->week_4,
            "week_5" => $data->week_5,
            "week_6" => $data->week_6,
            "week_7" => $data->week_7,
            "week_8" => $data->week_8,
            "week_9" => $data->week_9,
            "week_10" => $data->week_10,
            "week_11" => $data->week_11,
            "week_12" => $data->week_12,
            "week_13" => $data->week_13,
            "week_14" => $data->week_14,
            "week_15" => $data->week_15,
            "week_16" => $data->week_16,
            "month_5" => $data->month_5,
            "month_6" => $data->month_6,
            "month_7" => $data->month_7,
            "month_8" => $data->month_8,
            "month_9" => $data->month_9,
            "month_10" => $data->month_10,
            "month_11" => $data->month_11,
            "month_12" => $data->month_12,
        ];

        return response()->json(['message' => 'Get Weeks', 'in_stock_finish' => $entries->in_stock_finish, 'data' => $Arr]);
    }

    public function update_past_due(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'dates_array' => 'required|array',
            'part_number' => 'required|string',
        ]);

        $datesArray = $validatedData['dates_array']; // Dates array containing week and month dates
        $partNumber = $validatedData['part_number'];

        // Fetch the record's data
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $partNumber)->first();

        // Update weeks

        foreach ($datesArray as $key => $value) {
            $dateKey = str_replace('_', '_date_', $key);

            if ($value->$dateKey != $data->$dateKey) {
                $nextWeekKey = str_replace('week_', 'week_', $key);
                $nextWeekDateKey = str_replace('week_', 'week_', $dateKey);

                $data->$key = $data->$nextWeekKey;
                $data->$dateKey = $value->$nextWeekDateKey;
            }
        }

        // Save the changes
        $data->save();

        return response()->json(['message' => 'Weeks and months updated successfully.']);
    }

    private function getWeekArr($recordDate)
    {
        $today = $recordDate;
        $dayOfWeek = date('w', strtotime($today)); // 0 (Sunday) to 6 (Saturday)
        $mondayOfWeek = date('Y-m-d', strtotime('-'.$dayOfWeek.' days', strtotime($today)));
        $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

        // Calculate the end date of week 16
        $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

        // Initialize an array to store week and month start dates
        $datesArray = [];

        // Calculate week start dates and store in array
        for ($week = 1; $week <= 16; $week++) {
            $startOfWeek = date('Y-m-d', strtotime('+'.(($week - 1) * 7).' days', strtotime($mondayOfWeek)));
            $datesArray["week_$week"] = $startOfWeek;
        }

        // Calculate month start dates and store in array
        $month5StartDate = date('Y-m-d', strtotime('+1 day', strtotime($week16EndDate)));
        for ($month = 5; $month <= 12; $month++) {
            $endOfMonth = date('Y-m-d', strtotime('+30 days', strtotime($month5StartDate)));
            $datesArray["month_$month"] = $month5StartDate;
            $month5StartDate = date('Y-m-d', strtotime('+31 days', strtotime($month5StartDate)));
        }

        return $datesArray;
    }
}

