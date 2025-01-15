<?php

namespace App\Http\Controllers;

use App\Models\TargetCell;
use App\Models\TargetRow;
use App\Models\User;
use App\Models\Parts;
use App\Models\Entries;
use App\Models\UserConfig;
use App\Models\Weeks;
use App\Models\Notification;
use App\Models\WorkCenter;
use App\Models\OutSource;
use App\Models\Visual;
use App\Models\Department;
use App\Models\Customer;
use App\Models\Material;
use App\Models\WorkCenterSelec;
use App\Models\Vendor;
use App\Models\ColumnPreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        //highlight cell with data change
        if ($request->has('target_cell')) {
            $target_cell = TargetCell::find($_GET['target_cell']);
            $map_result = master_data_editable_column_map($target_cell->field);
            $target_cell_id = ($map_result != '') ? ($target_cell->table . '_' . $target_cell->ref_id . '_' . $map_result) : '0';
        } else {
            $target_cell = null;
            $target_cell_id = '0';
        }

        //highlight row with data entry
        $target_row_id = $request->get('target_row') ?? '';
        if ($request->has('target_row')) {
            $target_row = TargetRow::find($_GET['target_row']);
            $target_row_id = $request->get('target_row') ?? '';
        } else {
            $target_row = null;
            $target_row_id = '0';
        }


        // return $request;
        $query = Entries::with([
            'part',
            'weeks_months',
            'work_center_one',
            'out_source_one',
            'get_department',
            'get_customer',
            'get_material'
        ]);

        // Apply department filter
        if ($request->has('department') && $request->department != 'All') {
            $query->where('department', $request->department);
        }

        // Apply status filter
        if ($request->has('filter') && $request->filter == 'prd') {
            // Filter where the sum of weeks 1 to 12 is greater than `in_stock_finish`
            $query->whereHas('weeks_months', function ($query) {
                $query->whereRaw("
                    (CAST(week_1 AS UNSIGNED) +
                    CAST(week_2 AS UNSIGNED) +
                    CAST(week_3 AS UNSIGNED) +
                    CAST(week_4 AS UNSIGNED) +
                    CAST(week_5 AS UNSIGNED) +
                    CAST(week_6 AS UNSIGNED) +
                    CAST(week_7 AS UNSIGNED) +
                    CAST(week_8 AS UNSIGNED) +
                    CAST(week_9 AS UNSIGNED) +
                    CAST(week_10 AS UNSIGNED) +
                    CAST(week_11 AS UNSIGNED) +
                    CAST(week_12 AS UNSIGNED)) > in_stock_finish
                ");
            });
        } else if ($request->has('filter') && $request->filter == 'pending') {
            $query->where('filter', $request->filter);
        }

        $entries = $query->get();

        $department = Department::get();

        $customers = Customer::get();

        $materials = Material::get();

        $work_selector = WorkCenterSelec::get();

        if ($request->ajax()) {
            //column configuration
            $region_1_column_configuration_record = get_user_config('master_screen_region_1_column_configuration');
            $region_1_column_configuration = json_decode($region_1_column_configuration_record->value);
            usort($region_1_column_configuration, function ($a, $b) {
                return $a->order < $b->order ? -1 : 1;
            });

            $region_2_column_configuration_record = get_user_config('master_screen_region_2_column_configuration');
            $region_2_column_configuration = json_decode($region_2_column_configuration_record->value);
            usort($region_2_column_configuration, function ($a, $b) {
                return $a->order < $b->order ? -1 : 1;
            });

            $singleton = ($request->department == 'All') ? false : true;

            return response()->json([
                'html' => view('partials.entries', compact('entries', 'department', 'customers', 'materials', 'work_selector', 'region_1_column_configuration', 'region_2_column_configuration', 'singleton'))->render()
            ]);
        }

        return view('welcome', compact('entries', 'department', 'customers', 'materials', 'work_selector', 'target_cell_id', 'target_row_id'));
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
            $old = $entry->{$fieldName};
            $entry->{$fieldName} = $value;
            $entry->save();

            $this->notificationService->sendNotification(Auth::user()->id, 'add_manual_entries', ['message' => 'Manual entries has been added.', 'entries', $entry->id], 'entries', $entry->id, $fieldName, $old, $value);

            return response()->json(['message' => 'Field updated successfully.']);
        } else {
            return response()->json(['message' => 'Entry not found.'], 404);
        }
    }

    public function manual_imput_work(Request $request)
    {
        $dataId = $request->input('id');
        $fieldName = $request->input('field');
        $value = $request->input('value');

        // Find the entry by its ID
        $entry = WorkCenter::find($dataId);

        if ($entry) {
            // Update the specific field
            $old = $entry->{$fieldName};
            $entry->{$fieldName} = $value;
            $entry->save();

            $this->notificationService->sendNotification(Auth::user()->id, 'add_manual_entries', ['message' => 'Manual entries has been added.'], 'work_center', $entry->id, $fieldName, $old, $value);

            return response()->json(['message' => 'Field updated successfully.']);
        } else {
            return response()->json(['message' => 'Entry not found.'], 404);
        }
    }

    public function manual_imput_out(Request $request)
    {
        $dataId = $request->input('id');
        $fieldName = $request->input('field');
        $value = $request->input('value');

        // Find the entry by its ID
        $entry = OutSource::find($dataId);

        if ($entry) {
            // Update the specific field
            $old = $entry->{$fieldName};
            $entry->{$fieldName} = $value;
            $entry->save();

            $this->notificationService->sendNotification(Auth::user()->id, 'add_manual_entries', ['message' => 'Manual entries has been added.'], 'outsource', $entry->id, $fieldName, $old, $value);

            return response()->json(['message' => 'Field updated successfully.']);
        } else {
            return response()->json(['message' => 'Entry not found.'], 404);
        }
    }

    public function data_center()
    {
        if (Auth::user()->part_number_column == 0) {
            abort(403, 'You do not have permission to access this resource.');
        }
        $parts = Parts::all();
        $customer = DB::table('customers')->get();
        $material = DB::table('package')->get();
        $department = Department::get();
        $work_center_select = WorkCenterSelec::get();
        $vendor = Vendor::get();
        return view('data-center', compact('parts', 'customer', 'material', 'department', 'work_center_select', 'vendor'));
    }

    public function data_center_edit($id)
    {
        if (Auth::user()->role != 1) {
            abort(403, 'You do not have permission to access this resource.');
        }
        $data = Entries::with('work_center', 'out_source')->where('id', $id)->first();
        $parts = Parts::all();
        $customer = DB::table('customers')->get();
        $material = DB::table('package')->get();
        $department = Department::get();
        $work_center_select = WorkCenterSelec::get();
        $vendor = Vendor::get();
        return view('data-center-edit', compact('data', 'parts', 'customer', 'material', 'department', 'work_center_select', 'vendor'));
    }

    public function post_data_center(Request $request)
    {
        $validatedData = $request->validate([
            'part_number' => 'required|unique:entries,part_number',
            'customer' => 'required',
            'revision' => 'required|string|max:255',
            // 'ids' => 'required|string|max:255',
            'process' => 'nullable|string|max:255',
            'department' => 'nullable',
            'work_centre_1' => 'required',
            'work_centre_2' => 'nullable',
            'work_centre_3' => 'nullable',
            'work_centre_4' => 'nullable',
            'work_centre_5' => 'nullable',
            'work_centre_6' => 'nullable',
            'work_centre_7' => 'nullable',
            'outside_processing_1' => 'required',
            'outside_processing_2' => 'nullable',
            'outside_processing_3' => 'nullable',
            'outside_processing_4' => 'nullable',
            'outside_processing_text_1' => 'required',
            'outside_processing_text_2' => 'nullable',
            'outside_processing_text_3' => 'nullable',
            'outside_processing_text_4' => 'nullable',
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
            'currency' => 'required'
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

            $outside_processing_text = [
                'outside_processing_text_1' => $validatedData['outside_processing_text_1'],
                'outside_processing_text_2' => $validatedData['outside_processing_text_2'],
                'outside_processing_text_3' => $validatedData['outside_processing_text_3'],
                'outside_processing_text_4' => $validatedData['outside_processing_text_4'],
            ];

            // Get the entry ID
            $entryId = $entry->id;

            foreach ($work_centres as $centre => $value) {
                if (!empty($value)) {
                    $work_center = new WorkCenter();
                    $work_center->entry_id = $entryId;
                    $work_center->com = $value;
                    $work_center->work_centre_id = $centre;
                    $work_center->save();
                }
            }

            foreach ($outside_processing as $centre => $value) {
                if (!empty($value)) {
                    $data = new OutSource();
                    $data->entry_id = $entryId;
                    $data->out = $value ?? 'OUT 1';
                    $textKey = str_replace('outside_processing_', 'outside_processing_text_', $centre);
                    $data->in_process_outside = $validatedData[$textKey] ?? null;
                    $data->outside_processing_id = $centre;
                    $data->outside_processing_text_id = $textKey ?? null;
                    $data->save();
                }
            }

            $this->notificationService->sendNotification(Auth::user()->id, 'create_entries', ['message' => 'Entries has been added.'], 'entries', $entryId);
            return redirect()->back()->with('success', 'Part created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function post_data_center_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'part_number' => 'required|unique:entries,part_number,' . $id,
            'customer' => 'required',
            'revision' => 'required|string|max:255',
            'process' => 'nullable|string|max:255',
            'department' => 'nullable',
            'work_centre_1' => 'required',
            'work_centre_2' => 'nullable',
            'work_centre_3' => 'nullable',
            'work_centre_4' => 'nullable',
            'work_centre_5' => 'nullable',
            'work_centre_6' => 'nullable',
            'work_centre_7' => 'nullable',
            'outside_processing_1' => 'required',
            'outside_processing_2' => 'nullable',
            'outside_processing_3' => 'nullable',
            'outside_processing_4' => 'nullable',
            'outside_processing_text_1' => 'required',
            'outside_processing_text_2' => 'nullable',
            'outside_processing_text_3' => 'nullable',
            'outside_processing_text_4' => 'nullable',
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
            'currency' => 'required',
        ]);

        try {
            $entry = Entries::findOrFail($id);

            // Update main entry data
            $validatedData['user_id'] = Auth::user()->id;
            $entry->update($validatedData);

            // Prepare work centers and outside processing data
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

            $outside_processing_text = [
                'outside_processing_text_1' => $validatedData['outside_processing_text_1'],
                'outside_processing_text_2' => $validatedData['outside_processing_text_2'],
                'outside_processing_text_3' => $validatedData['outside_processing_text_3'],
                'outside_processing_text_4' => $validatedData['outside_processing_text_4'],
            ];

            // Update work centers
            WorkCenter::where('entry_id', $id)->delete(); // Clear old records
            foreach ($work_centres as $centre => $value) {
                if (!empty($value) && $value !== 'Select') { // Check for null or 'Select'
                    $work_center = new WorkCenter();
                    $work_center->entry_id = $id;
                    $work_center->com = $value;
                    $work_center->work_centre_id = $centre;
                    $work_center->save();
                }
            }

            // Update outside processing
            OutSource::where('entry_id', $id)->delete(); // Clear old records
            foreach ($outside_processing as $centre => $value) {
                if (!empty($value) && $value !== 'Select') { // Check for null or 'Select'
                    $data = new OutSource();
                    $data->entry_id = $id;
                    $data->out = $value ?? 'OUT 1';
                    $textKey = str_replace('outside_processing_', 'outside_processing_text_', $centre);
                    $data->in_process_outside = $validatedData[$textKey] ?? null;
                    $data->outside_processing_id = $centre;
                    $data->outside_processing_text_id = $textKey ?? null;
                    $data->save();
                }
            }

            $this->notificationService->sendNotification(Auth::user()->id, 'update_entries', ['message' => 'Entries have been updated.'], 'entries', $entry->id);
            return redirect()->back()->with('success', 'Part updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function calender()
    {
        if (Auth::user()->calendar_column == 0 && Auth::user()->stock_finished_column == 0 && Auth::user()->create_order == 0) {
            abort(403, 'You do not have permission to access this resource.');
        }
        // $parts = Parts::all();
        $parts = Entries::with('part')->get();
        $weeks = [
            'Week 1',
            'Week 2',
            'Week 3',
            'Week 4',
            'Week 5',
            'Week 6',
            'Week 7',
            'Week 8',
            'Week 9',
            'Week 10',
            'Week 11',
            'Week 12',
            'Week 13',
            'Week 14',
            'Week 15',
            'Week 16',
            'Month 5',
            'Month 6',
            'Month 7',
            'Month 8',
            'Month 9',
            'Month 10',
            'Month 11',
            'Month 12'
        ];
        return view('calender', compact('parts', 'weeks'));
    }

    public function input_screen()
    {
        if (Auth::user()->input_screen_column == 0) {
            abort(403, 'You do not have permission to access this resource.');
        }

        $com1 = WorkCenter::with(['entries.get_customer', 'entries.part', 'work_select'])
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $com2 = WorkCenter::with(['entries.get_customer', 'entries.part'])
            ->where('com', 'COM 2')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $com3 = WorkCenter::with(['entries.get_customer', 'entries.part'])
            ->where('com', 'COM 3')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $out1 = OutSource::with(['entries_data.get_customer', 'entries_data.part', 'out_source'])
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries_data', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $out2 = OutSource::with(['entries_data.get_customer', 'entries_data.part'])
            ->where('out', 'OUT 2')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries_data', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $out3 = OutSource::with(['entries_data.get_customer', 'entries_data.part'])
            ->where('out', 'OUT 3')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries_data', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $customers = Customer::get();

        $parts = Parts::get();

        return view('input-screen', compact('com1', 'com2', 'com3', 'out1', 'out2', 'out3', 'customers', 'parts'));
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
                $existingRecord->update([
                    'status' => $entry['status'],
                    'customer' => $entry['customer'],
                    'part_number' => $entry['part_number'],
                    'quantity' => $entry['quantity'],
                    'job' => $entry['job'],
                    'lot' => $entry['lot'],
                ]);
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
                $existingRecord->update([
                    'status' => $entry['status'],
                    'customer' => $entry['customer'],
                    'part_number' => $entry['part_number'],
                    'quantity' => $entry['quantity'],
                    'job' => $entry['job'],
                    'lot' => $entry['lot'],
                ]);
            } else {
                // Create a new record if it doesn't exist
                Visual::create($entry);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
    }

    public function notifications(Request $request)
    {
        $users = User::where('role', 2)->get();
        $userId = $request->input('user_id');

        $notificationsQuery = Notification::with('user');

        if (Auth::user()->role != 1) {

            $notificationsQuery->where('user_id', Auth::id());
        } elseif ($userId && $userId !== 'all') {

            $notificationsQuery->where('user_id', $userId);
        }

        $notifications = $notificationsQuery->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            $html = view('partials.notification-ajax', ['notifications' => $notifications])->render();
            return response()->json(['html' => $html]);
        }

        return view('notifications', compact('notifications', 'users'));
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
        if ($exist_data) {
            return response()->json(['error' => true, 'message' => 'This part number order already exist']);
        }

        $data = new Weeks();
        $data->user_id = Auth::user()->id;
        $data->part_number = $request->part_number;

        $temp = $this->getWeekArr(date('Y-m-d'));

        foreach ($request->weeks as $key => $value) {
            $data->$key = $value;
            $data->{$key . '_date'} = $temp[$key];
        }
        $data->save();

        $part = Entries::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
        $part->filter = 'pending';
        $part->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'create_shipment_order', ['message' => 'Shipment Order Created.'], 'weeks', $data->id);

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
            if ($value != '' && $value != null) {
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

        foreach ($array_1 as $key => $val) {
            $data->{$key} = $array_1[$key];
        }

        // // Save the changes
        // return $data->week_1_date.' '.$week1date;
        if ($data->week_1_date != $week1date) {
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
        $mondayOfWeek = date('Y-m-d', strtotime('-' . $dayOfWeek . ' days', strtotime($today)));
        $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));

        // Calculate the end date of week 16
        $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));

        // Initialize an array to store week and month start dates
        $datesArray = [];

        // Calculate week start dates and store in array
        for ($week = 1; $week <= 16; $week++) {
            $startOfWeek = date('Y-m-d', strtotime('+' . (($week - 1) * 7) . ' days', strtotime($mondayOfWeek)));
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

        $this->notificationService->sendNotification(Auth::user()->id, 'save_shipment_data', ['message' => 'Shipment Amount Saved'], 'weeks', $data->id);

        return response()->json(['message' => 'Shipment Amount Saved', 'data' => $data]);
    }

    public function change_past_due(Request $request)
    {
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();

        $data->past_due = $request->past_due;
        $data->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'change_past_due', ['message' => 'Past Due Changed'], 'weeks', $data->id);

        return response()->json(['message' => 'Past Due Changed', 'past_due' => $data->past_due]);
    }

    public function update_week_or_month(Request $request)
    {
        $data = Weeks::where('user_id', Auth::user()->id)->where('part_number', $request->part_number)->first();
        $data->{$request->id} = $request->value;
        $data->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'update_week_or_month', ['message' => 'Weeks or Month Updated'], 'weeks', $data->id);

        return response()->json([
            'success' => true,
            'id' => $request->id,
            'updated_value' => $request->value,
        ]);
    }

    public function save_columns_preferences(Request $request)
    {
        $request->validate([
            'columns' => 'required'
        ]);

        $user = new ColumnPreferences();
        $user->user_id = Auth::user()->id;
        $user->columns = $request->columns;
        $user->save();

        $columnPreferences = ColumnPreferences::updateOrCreate(
            ['user_id' => $user->id],
            ['columns' => json_encode($request->columns)]
        );

        return response()->json(['message' => 'Preferences saved successfully']);
    }

    public function saveUserConfiguration(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'key' => 'required',
                'value' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ]);
            }

            UserConfig::updateOrCreate([
                'user_id' => auth()->id(),
                'key' => $request->key,
            ], [
                'value' => $request->value
            ]);

            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Configuration saved!',
                'errors' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $e->getMessage(),
                'errors' => []
            ]);
        }
    }
}
