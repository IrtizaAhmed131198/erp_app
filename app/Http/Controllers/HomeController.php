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
        // $array_1 = Weeks::where('user_id', Auth::user()->id)->where('part_number', $partNumber)->first();

        // $array_2 = [];
        // foreach ($datesArray as $key => $value) {
        //     if (strpos($key, '_date') === false) {
        //         $date_key = $key . '_date';
        //         $array_2[$key] = $value;
        //         if (isset($datesArray[$date_key])) {
        //             $array_2[$date_key] = $datesArray[$date_key];
        //         }
        //     }
        // }

        // $keys_to_remove = ['id', 'user_id', 'part_number', 'created_at', 'updated_at'];

        // foreach ($keys_to_remove as $key) {
        //     unset($array_1[$key]);
        // }
        // return $array_2;
        $array_1 = [
            "week_1" => "1000",
            "week_1_date" => "2024-12-15",
            "week_2" => "1000",
            "week_2_date" => "2024-12-22",
            "week_3" => "100",
            "week_3_date" => "2024-12-29",
            "week_4" => "10000",
            "week_4_date" => "2025-01-05",
            "week_5" => "156465",
            "week_5_date" => "2025-01-12",
            "week_6" => "32131",
            "week_6_date" => "2025-01-19",
            "week_7" => "465",
            "week_7_date" => "2025-01-26",
            "week_8" => "54",
            "week_8_date" => "2025-02-02",
            "week_9" => "321",
            "week_9_date" => "2025-02-09",
            "week_10" => "684",
            "week_10_date" => "2025-02-16",
            "week_11" => "321",
            "week_11_date" => "2025-02-23",
            "week_12" => "684",
            "week_12_date" => "2025-03-02",
            "week_13" => "345",
            "week_13_date" => "2025-03-09",
            "week_14" => "897",
            "week_14_date" => "2025-03-16",
            "week_15" => "100",
            "week_15_date" => "2025-03-23",
            "week_16" => "520",
            "week_16_date" => "2025-03-30",
            "month_5" => "215",
            "month_5_date" => "2025-04-06",
            "month_6" => "2500",
            "month_6_date" => "2025-05-07",
            "month_7" => "22250",
            "month_7_date" => "2025-06-07",
            "month_8" => "451",
            "month_8_date" => "2025-07-08",
            "month_9" => "21",
            "month_9_date" => "2025-08-08",
            "month_10" => "102",
            "month_10_date" => "2025-09-08",
            "month_11" => "120",
            "month_11_date" => "2025-10-09",
            "month_12" => "12",
            "month_12_date" => "2025-11-09"
        ];

        $array_2 = [
            "week_1" => "1000",
            "week_1_date" => "2024-12-22",
            "week_2" => "1000",
            "week_2_date" => "2024-12-29",
            "week_3" => "100",
            "week_3_date" => "2025-01-05",
            "week_4" => "10000",
            "week_4_date" => "2025-01-12",
            "week_5" => "156465",
            "week_5_date" => "2025-01-19",
            "week_6" => "32131",
            "week_6_date" => "2025-01-26",
            "week_7" => "465",
            "week_7_date" => "2025-02-02",
            "week_8" => "54",
            "week_8_date" => "2025-02-09",
            "week_9" => "321",
            "week_9_date" => "2025-02-16",
            "week_10" => "684",
            "week_10_date" => "2025-02-23",
            "week_11" => "321",
            "week_11_date" => "2025-03-02",
            "week_12" => "684",
            "week_12_date" => "2025-03-09",
            "week_13" => "345",
            "week_13_date" => "2025-03-16",
            "week_14" => "897",
            "week_14_date" => "2025-03-23",
            "week_15" => "100",
            "week_15_date" => "2025-03-30",
            "week_16" => "520",
            "week_16_date" => "2025-04-06",
            "month_5" => "215",
            "month_5_date" => "2025-04-13",
            "month_6" => "2500",
            "month_6_date" => "2025-05-14",
            "month_7" => "22250",
            "month_7_date" => "2025-06-14",
            "month_8" => "451",
            "month_8_date" => "2025-07-15",
            "month_9" => "21",
            "month_9_date" => "2025-08-15",
            "month_10" => "102",
            "month_10_date" => "2025-09-15",
            "month_11" => "120",
            "month_11_date" => "2025-10-16",
            "month_12" => "12",
            "month_12_date" => "2025-11-16"
        ];

        foreach ($array_1 as $key => $value) {
            if (strpos($key, '_date') !== false) { // Check if the key ends with '_date'
                $base_key = str_replace('_date', '', $key); // Get the base key (e.g., 'week_1' or 'month_5')
                if (isset($array_2[$key]) && $value !== $array_2[$key]) { // Compare dates
                    // Calculate the next key
                    preg_match('/(\d+)/', $base_key, $matches);
                    $next_key = preg_replace('/\d+/', $matches[1] + 1, $base_key);

                    // Update $array_1's value or set to null if not found in $array_2
                    $array_1[$base_key] = $array_2[$next_key] ?? null;

                    // Update the _date value in array_1 with the corresponding value in array_2
                    $array_1[$key] = $array_2[$key];
                }
            }
        }

        $array_1['month_12'] = null;

        return $array_1;


        // Update weeks
        // echo '<pre>';
        // echo $data;
        // echo '</pre>';

        // foreach ($datesArray as $key => $value) {
        //     echo $key;
        //     echo $dateKey = str_replace('_', '_date_', $key);

        //     if ($value->$dateKey != $data->$dateKey) {
        //         $nextWeekKey = str_replace('week_', 'week_', $key);
        //         $nextWeekDateKey = str_replace('week_', 'week_', $dateKey);

        //         $data->$key = $data->$nextWeekKey;
        //         $data->$dateKey = $value->$nextWeekDateKey;
        //     }
        // }
        // return 213;

        // // Save the changes
        // $data->save();

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

