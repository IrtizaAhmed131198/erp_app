<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parts;
use App\Models\Entries;
use App\Models\Weeks;
use App\Models\Notification;
use App\Models\WorkCenter;
use App\Models\OutSource;
use App\Models\Visual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\NotificationService;

class HomeController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Entries::with('weeks_months', 'work_center_one');

        // Apply department filter
        if ($request->has('department') && $request->department != 'All') {
            $query->where('department', $request->department);
        }

        // Apply status filter
        if ($request->has('filter') && $request->filter != 'All') {
            $query->where('filter', $request->filter);
        }

        $entries = $query->get();

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

            $this->notificationService->sendNotification(Auth::user()->id, 'add_manual_entries', ['message' => 'Manual entries has been added.']);

            return response()->json(['message' => 'Field updated successfully.']);
        } else {
            return response()->json(['message' => 'Entry not found.'], 404);
        }
    }

    public function data_center()
    {
        if(Auth::user()->part_number_column == 0){
            abort(403, 'You do not have permission to access this resource.');
        }
        $parts = Parts::all();
        $customer = DB::table('customers')->get();
        $material = DB::table('package')->get();
        return view('data-center', compact('parts', 'customer', 'material'));
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
            'work_centre_1' => 'required',
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
            'rev' => 'nullable',
            'wet_reqd' => 'nullable',
            'safety' => 'nullable',
            'min_ship' => 'nullable',
            'wt_pc' => 'required',
        ]);

        $existingEntry = Entries::where('customer', $validatedData['customer'])
            ->where('part_number', $validatedData['part_number'])
            ->first();

        if ($existingEntry) {
            return redirect()->back()->with('error', 'This Part Number already exists.');
        }
        try {
            $validatedData['user_id'] = Auth::user()->id;
            $entry = Entries::create($validatedData);

            $work_centres = [
                'work_centre_1' => $validatedData['work_centre_1'],
                'work_centre_2' => $validatedData['work_centre_2'],
                'work_centre_3' => $validatedData['work_centre_3'],
                'work_centre_4' => $validatedData['work_centre_4'],
                'work_centre_5' => $validatedData['work_centre_5'],
                'work_centre_6' => $validatedData['work_centre_6'],
                'work_centre_7' => $validatedData['work_centre_7'],
            ];

            $outside_processing = [
                'outside_processing_1' => $validatedData['outside_processing_1'],
                'outside_processing_2' => $validatedData['outside_processing_2'],
                'outside_processing_3' => $validatedData['outside_processing_3'],
                'outside_processing_4' => $validatedData['outside_processing_4'],
            ];

            // Get the entry ID
            $entryId = $entry->id;

            foreach ($work_centres as $centre => $value) {
                if (!empty($value)) {
                    $work_center = new WorkCenter();
                    $work_center->entry_id = $entryId;
                    $work_center->com = $value;
                    $work_center->save();
                }
            }

            foreach ($outside_processing as $centre => $value) {
                if (!empty($value)) {
                    $data = new OutSource();
                    $data->entry_id = $entryId;
                    $data->out = $value;
                    $data->save();
                }
            }

            $this->notificationService->sendNotification(Auth::user()->id, 'create_entries', ['message' => 'Entries has been added.']);
            return redirect()->back()->with('success', 'Part created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function calender()
    {
        if(Auth::user()->calendar_column == 0){
            abort(403, 'You do not have permission to access this resource.');
        }
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
        if(Auth::user()->input_screen_column == 0){
            abort(403, 'You do not have permission to access this resource.');
        }

        $com1 = WorkCenter::with('entries')
            ->where('com', 'COM 1')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $com2 = WorkCenter::with('entries')
            ->where('com', 'COM 2')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $com3 = WorkCenter::with('entries')
            ->where('com', 'COM 3')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $out1 = OutSource::with('entries_data')
            ->where('out', 'OUT 1')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries_data', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $out2 = OutSource::with('entries_data')
            ->where('out', 'OUT 2')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries_data', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $out3 = OutSource::with('entries_data')
            ->where('out', 'OUT 3')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries_data', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        return view('input-screen', compact('com1', 'com2', 'com3', 'out1', 'out2', 'out3'));
    }

    public function save_table_data(Request $request)
    {
        $validated = $request->validate([
            'entries' => 'required|array',
            'entries.*.status' => 'required|string',
            'entries.*.customer' => 'required|string',
            'entries.*.part_number' => 'required|string',
            'entries.*.quantity' => 'required|integer',
            'entries.*.job' => 'required|string',
            'entries.*.lot' => 'required|string',
            'entries.*.type' => 'required|string',
            'entries.*.type_id' => 'required|string',
        ]);

        foreach ($validated['entries'] as $entry) {
            $entry['user_id'] = Auth::user()->id;

            // Check if the record exists based on unique conditions
            $existingRecord = Visual::where([
                ['type_id', $entry['type_id']],
            ])->first();

            if ($existingRecord) {
                // Update only the status if the record exists
                $existingRecord->update(['status' => $entry['status']]);
            } else {
                // Create a new record if it doesn't exist
                Visual::create($entry);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
    }

    public function save_table_data_2(Request $request)
    {
        $validated = $request->validate([
            'entries_data' => 'required|array',
            'entries_data.*.status' => 'required|string',
            'entries_data.*.customer' => 'required|string',
            'entries_data.*.part_number' => 'required|string',
            'entries_data.*.quantity' => 'required|integer',
            'entries_data.*.job' => 'required|string',
            'entries_data.*.lot' => 'required|string',
            'entries_data.*.type' => 'required|string',
            'entries_data.*.type_id' => 'required|string',
        ]);

        foreach ($validated['entries_data'] as $entry) {
            $entry['user_id'] = Auth::user()->id;

            // Check if the record exists based on unique conditions
            $existingRecord = Visual::where([
                ['type_id', $entry['type_id']],
            ])->first();

            if ($existingRecord) {
                // Update only the status if the record exists
                $existingRecord->update(['status' => $entry['status']]);
            } else {
                // Create a new record if it doesn't exist
                Visual::create($entry);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
    }

    public function notifications()
    {
        $notifications = Notification::with('user')->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc') // Order by most recent first
            ->get();
        return view('notifications', compact('notifications'));
    }

    public function visual_screen()
    {
        if (Auth::user()->role == 1) {
            $visuals = Visual::all()->groupBy('status');
        } else {
            $visuals = Visual::where('user_id', Auth::user()->id)->get()->groupBy('status');
        }

        // Define the desired order
        $desiredOrder = ['Running', 'Pending Order', 'Pause', 'Closed'];

        // Sort the grouped visuals by the desired order
        $visuals = $visuals->sortBy(function ($entries, $status) use ($desiredOrder) {
            return array_search($status, $desiredOrder);
        });
        return view('visual-queue-screen', compact('visuals'));
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

        $part = Entries::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
        $part->filter = 'pending';
        $part->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'create_shipment_order', ['message' => 'Shipment Order Created.']);

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
            'current_date' => 'required|string',
        ]);

        $datesArray = $validatedData['dates_array']; // Dates array containing week and month dates
        $partNumber = $validatedData['part_number'];

        // Fetch the record's data
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $partNumber)->first();
        $keys_to_remove = ['id', 'user_id', 'part_number', 'created_at', 'updated_at'];
        foreach ($keys_to_remove as $key) {
            unset($data[$key]);
        }

        $week1date = $data->week_1_date;

        $array_1 = $data ? $data->toArray() : [];

        $array_2 = [];
        foreach ($datesArray as $key => $value) {
            if (strpos($key, '_date') === false) {
                $date_key = $key . '_date';
                $array_2[$key] = $value;
                if (isset($datesArray[$date_key])) {
                    $array_2[$date_key] = $datesArray[$date_key];
                }
            }
        }

        // return $array_2;
        // $array_1 = [
        //     "week_1" => "100",
        //     "week_1_date" => "2024-12-15",
        //     "week_2" => "1000",
        //     "week_2_date" => "2024-12-22",
        //     "week_3" => "100",
        //     "week_3_date" => "2024-12-29",
        //     "week_4" => "1000",
        //     "week_4_date" => "2025-01-05",
        //     "week_5" => "25646",
        //     "week_5_date" => "2025-01-12",
        //     "week_6" => "13489",
        //     "week_6_date" => "2025-01-19",
        //     "week_7" => "101",
        //     "week_7_date" => "2025-01-26",
        //     "week_8" => "20",
        //     "week_8_date" => "2025-02-02",
        //     "week_9" => "3218",
        //     "week_9_date" => "2025-02-09",
        //     "week_10" => "13",
        //     "week_10_date" => "2025-02-16",
        //     "week_11" => "2666",
        //     "week_11_date" => "2025-02-23",
        //     "week_12" => "900",
        //     "week_12_date" => "2025-03-02",
        //     "week_13" => "5500",
        //     "week_13_date" => "2025-03-09",
        //     "week_14" => "100",
        //     "week_14_date" => "2025-03-16",
        //     "week_15" => "220",
        //     "week_15_date" => "2025-03-23",
        //     "week_16" => "8990",
        //     "week_16_date" => "2025-03-30",
        //     "month_5" => "1100",
        //     "month_5_date" => "2025-04-06",
        //     "month_6" => "1851",
        //     "month_6_date" => "2025-05-07",
        //     "month_7" => "1321",
        //     "month_7_date" => "2025-06-07",
        //     "month_8" => "798",
        //     "month_8_date" => "2025-07-08",
        //     "month_9" => "2156",
        //     "month_9_date" => "2025-08-08",
        //     "month_10" => "1654",
        //     "month_10_date" => "2025-09-08",
        //     "month_11" => "3210",
        //     "month_11_date" => "2025-10-09",
        //     "month_12" => "100",
        //     "month_12_date" => "2025-11-09"
        // ];

        // $array_2 = [
        //     "week_1" => "100",
        //     "week_1_date" => "2024-12-22",
        //     "week_2" => "1000",
        //     "week_2_date" => "2024-12-29",
        //     "week_3" => "100",
        //     "week_3_date" => "2025-01-05",
        //     "week_4" => "1000",
        //     "week_4_date" => "2025-01-12",
        //     "week_5" => "25646",
        //     "week_5_date" => "2025-01-19",
        //     "week_6" => "13489",
        //     "week_6_date" => "2025-01-26",
        //     "week_7" => "101",
        //     "week_7_date" => "2025-02-02",
        //     "week_8" => "20",
        //     "week_8_date" => "2025-02-09",
        //     "week_9" => "3218",
        //     "week_9_date" => "2025-02-16",
        //     "week_10" => "13",
        //     "week_10_date" => "2025-02-23",
        //     "week_11" => "2666",
        //     "week_11_date" => "2025-03-02",
        //     "week_12" => "900",
        //     "week_12_date" => "2025-03-09",
        //     "week_13" => "5500",
        //     "week_13_date" => "2025-03-16",
        //     "week_14" => "100",
        //     "week_14_date" => "2025-03-23",
        //     "week_15" => "220",
        //     "week_15_date" => "2025-03-30",
        //     "week_16" => "8990",
        //     "week_16_date" => "2025-04-06",
        //     "month_5" => "1100",
        //     "month_5_date" => "2025-04-13",
        //     "month_6" => "1851",
        //     "month_6_date" => "2025-05-14",
        //     "month_7" => "1321",
        //     "month_7_date" => "2025-06-14",
        //     "month_8" => "798",
        //     "month_8_date" => "2025-07-15",
        //     "month_9" => "2156",
        //     "month_9_date" => "2025-08-15",
        //     "month_10" => "1654",
        //     "month_10_date" => "2025-09-15",
        //     "month_11" => "3210",
        //     "month_11_date" => "2025-10-16",
        //     "month_12" => "100",
        //     "month_12_date" => "2025-11-16"
        // ];

        $currentDate = $request->current_date;

        // Initialize new array for passed weeks
        $passedWeeks = [];

        $pas_due = 0;

        // Iterate through the array to check passed weeks
        foreach ($array_1 as $key => $value) {
            if (strpos($key, 'week_') === 0 && strpos($key, '_date') !== false) {
                $weekNumber = str_replace('_date', '', $key);
                if (strtotime($value) < strtotime($currentDate)) {
                    $passedWeeks[$weekNumber] = $array_1[$weekNumber];
                    $passedWeeks["{$weekNumber}_date"] = $value;
                    $pas_due += $array_1[$weekNumber];
                }
            }
        }

        foreach ($array_1 as $key => $value) {
            if (strpos($key, '_date') !== false) {
                $week_or_month_key = str_replace('_date', '', $key);
                if (isset($array_2[$key]) && $value !== $array_2[$key]) {
                    $next_key = strpos($week_or_month_key, 'week_') !== false
                        ? "week_" . (intval(str_replace('week_', '', $week_or_month_key)) + 1)
                        : "month_" . (intval(str_replace('month_', '', $week_or_month_key)) + 1);

                    $array_1[$week_or_month_key] = $array_2[$next_key] ?? $array_2["month_5"] ?? null;
                    $array_1[$key] = $array_2[$key];
                }
            }
        }

        $array_1['month_12'] = null;

        foreach($array_1 as $key => $val){
            $data->{$key} = $array_1[$key];
        }

        // // Save the changes
        // return $data->week_1_date.' '.$week1date;
        if($data->week_1_date != $week1date){
            $data->past_due = $pas_due;
        }
        $past_due_val = $data->past_due;
        $data->save();
        unset($data->past_due);

        return response()->json(['message' => 'Weeks and months updated successfully.', 'data' => $data, 'past_due_val' => $past_due_val]);
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

    public function save_shipment_data(Request $request)
    {
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();

        foreach ($request->shipmentData as $shipment) {
            if ($shipment['value'] != '' && $shipment['value'] != null) {
                // Assuming that $shipment->weekKey is a valid column in your Weeks table
                $data->{$shipment['weekKey']} = $shipment['value'];
            }
        }
        $data->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'save_shipment_data', ['message' => 'Shipment Amount Saved']);

        return response()->json(['message' => 'Shipment Amount Saved', 'data' => $data]);
    }

    public function change_past_due(Request $request)
    {
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();

        $data->past_due = $request->past_due;
        $data->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'change_past_due', ['message' => 'Past Due Changed']);

        return response()->json(['message' => 'Past Due Changed', 'past_due' => $data->past_due]);
    }

    public function update_week_or_month(Request $request)
    {
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
        $data->{$request->id} = $request->value;
        $data->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'update_week_or_month', ['message' => 'Weeks or Month Updated']);

        return response()->json([
            'success' => true,
            'id' => $request->id,
            'updated_value' => $request->value,
        ]);
    }

}
