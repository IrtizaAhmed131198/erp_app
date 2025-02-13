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
use App\Models\HighlightedCell;
use App\Models\WeeksHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Validator;
use App\Events\StockUpdate;
use Yajra\DataTables\Facades\DataTables;

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

        // Apply search query
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($query) use ($request) {
                $search = $request->search;

                $query->where('revision', 'LIKE', "%$search%") // Replace with actual column names
                    ->orWhere('process', 'LIKE', "%$search%")
                    ->orWhere('pc_weight', 'LIKE', "%$search%")
                    ->orWhere('safety_shock', 'LIKE', "%$search%")
                    ->orWhere('moq', 'LIKE', "%$search%")
                    ->orWhere('order_notes', 'LIKE', "%$search%")
                    ->orWhere('part_notes', 'LIKE', "%$search%")
                    ->orWhere('future_raw', 'LIKE', "%$search%")
                    ->orWhere('price', 'LIKE', "%$search%")
                    ->orWhere('notes', 'LIKE', "%$search%")
                    ->orWhere('planning', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%")
                    ->orWhere('filter', 'LIKE', "%$search%")
                    ->orWhere('job', 'LIKE', "%$search%")
                    ->orWhere('lot', 'LIKE', "%$search%")
                    ->orWhere('in_stock_finish', 'LIKE', "%$search%")
                    ->orWhere('live_inventory_finish', 'LIKE', "%$search%")
                    ->orWhere('live_inventory_wip', 'LIKE', "%$search%")
                    ->orWhere('in_stock_live', 'LIKE', "%$search%")
                    ->orWhere('in_process_outside', 'LIKE', "%$search%")
                    ->orWhere('raw_mat', 'LIKE', "%$search%")
                    ->orWhere('wet_reqd', 'LIKE', "%$search%")
                    ->orWhere('wet_reqd', 'LIKE', "%$search%")
                    ->orWhere('safety', 'LIKE', "%$search%")
                    ->orWhere('min_ship', 'LIKE', "%$search%")
                    ->orWhere('currency', 'LIKE', "%$search%")
                    ->orWhere('wt_pc', 'LIKE', "%$search%");

                $query->orWhereHas('part', function ($q) use ($search) {
                    $q->where('Part_Number', 'LIKE', "%$search%");
                });

                $query->orWhereHas('get_customer', function ($q) use ($search) {
                    $q->where('CustomerName', 'LIKE', "%$search%");
                });

                $query->orWhereHas('get_material', function ($q) use ($search) {
                    $q->where('Package', 'LIKE', "%$search%");
                });

                $query->orWhereHas('get_department', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                });

                $query->orWhereHas('out_source_one', function ($q) use ($search) {
                    $q->where('out', 'LIKE', "%$search%");
                    $q->where('in_process_outside', 'LIKE', "%$search%");
                });

                $query->orWhereHas('work_center_one', function ($q) use ($search) {
                    $q->where('com', 'LIKE', "%$search%");
                });
            });
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
        $entry = Entries::with(['get_customer', 'part', 'get_department'])->find($dataId);

        if ($entry) {
            if ($entry->{$fieldName} == $value) {
                return response()->json(['message' => 'Field updated successfully.']);
            }
            // Update the specific field
            $old = $entry->{$fieldName};
            $entry->{$fieldName} = $value;
            $entry->save();

            if ($fieldName == 'department') {
                $new_old = $entry->get_department->name;
                $new_value = Department::find($value)->name;
            } else if ($fieldName == 'customer') {
                $new_old = $entry->get_customer->CustomerName;
                $new_value = Customer::find($value)->CustomerName;
            } else if ($fieldName == 'part') {
                $new_old = $entry->part->Part_Number;
                $new_value = Parts::find($value)->Part_Number;
            } else {
                $new_old = $old;
                $new_value = $value;
            }

            $fieldNameFormatted = ucwords(str_replace('_', ' ', $fieldName));
            if ($new_old == '') {
                $info = '"' . $new_value . '" has been added to ' . $fieldNameFormatted;
            } else {
                $info = $fieldNameFormatted . ' value changes from "' . $new_old . '" to "' . $new_value . '"';
            }

            $this->notificationService->sendNotification(
                Auth::user()->id,
                'add_manual_entries',
                ['message' => 'Manual entries has been added.', 'entries', $entry->id],
                'entries',
                $entry->id,
                $fieldName,
                $old,
                $value,
                'add',
                $info
            );

            $data_updates = [
                'entries_' . $dataId . '_' . $fieldName => $value
            ];
            // Broadcast the event
            event(new StockUpdate($data_updates));

            if ($fieldName == 'department') {
                $weeks_histroy = WeeksHistory::where('entry_id', $dataId)->get();
                foreach ($weeks_histroy as $weeks_histroy) {
                    $weeks_histroy->department = $value;
                    $weeks_histroy->save();
                }
            }

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
        $entry = WorkCenter::with('work_select')->find($dataId);

        if ($entry) {
            if ($entry->{$fieldName} == $value) {
                return response()->json(['message' => 'Field updated successfully.']);
            }
            // Update the specific field
            $old = $entry->{$fieldName};
            $entry->{$fieldName} = $value;
            $entry->save();

            $new_old = $entry->work_select->name;
            $new_value = WorkCenterSelec::find($value)->name;
            $fieldNameFormatted = ucwords(str_replace('_', ' ', $fieldName));
            $info = 'WorkCenter value changes from "' . $new_old . '" to "' . $new_value . '"';

            $this->notificationService->sendNotification(Auth::user()->id, 'add_manual_entries', ['message' => 'Manual entries has been added.'], 'work_center', $entry->id, $fieldName, $old, $value, 'update', $info);

            $data_updates = [
                'entries_' . $dataId . '_' . $fieldName => $value
            ];
            // Broadcast the event
            event(new StockUpdate($data_updates));

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
        return $entry = OutSource::find($dataId);

        if ($entry) {
            if ($entry->{$fieldName} == $value) {
                return response()->json(['message' => 'Field updated successfully.']);
            }
            // Update the specific field
            $old = $entry->{$fieldName};
            $entry->{$fieldName} = $value;
            $entry->save();

            // $new_old = $entry->work_select->name;
            // $new_value = WorkCenterSelec::find($value)->name;
            // $fieldNameFormatted = ucwords(str_replace('_', ' ', $fieldName));
            // $info = 'WorkCenter value changes from ' . $new_old . ' to ' . $new_value;

            $this->notificationService->sendNotification(Auth::user()->id, 'add_manual_entries', ['message' => 'Manual entries has been added.'], 'outsource', $entry->id, $fieldName, $old, $value, 'add');

            $data_updates = [
                'entries_' . $dataId . '_' . $fieldName => $value
            ];
            // Broadcast the event
            event(new StockUpdate($data_updates));

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
        $last_activity = Notification::with('user')
            ->where('type', 'update_entries')
            ->where('reference_id', $id)
            ->orderBy('id', 'desc')
            ->first();
        $data = Entries::with('work_center', 'out_source')->where('id', $id)->first();
        $parts = Parts::all();
        $customer = DB::table('customers')->get();
        $material = DB::table('package')->get();
        $department = Department::get();
        $work_center_select = WorkCenterSelec::get();
        $vendor = Vendor::get();
        return view('data-center-edit', compact('data', 'parts', 'customer', 'material', 'department', 'work_center_select', 'vendor', 'last_activity'));
    }

    private function removeCommas($value)
    {
        // Check if the value is not empty and is numeric before removing commas
        return !empty($value) ? preg_replace('/,/', '', $value) : $value;
    }

    public function post_data_center(Request $request)
    {
        $validatedData = $request->validate([
            'part_number' => 'required|unique:entries,part_number',
            'customer' => 'required',
            'revision' => 'required|string|max:255',
            'ids' => 'nullable|string|max:255',
            'process' => 'nullable|string|max:255',
            'department' => 'nullable',
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
            'outside_processing_text_1' => 'nullable',
            'outside_processing_text_2' => 'nullable',
            'outside_processing_text_3' => 'nullable',
            'outside_processing_text_4' => 'nullable',
            'material' => 'nullable|string|max:255',
            'pc_weight' => 'nullable',
            'safety_shock' => 'nullable',
            'moq' => 'nullable',
            'order_notes' => 'nullable|string',
            'part_notes' => 'nullable|string',
            // 'future_raw' => 'nullable|string|max:255',
            'price' => 'nullable',
            'notes' => 'nullable|string',
            'rev' => 'nullable',
            'wet_reqd' => 'nullable',
            'safety' => 'nullable',
            'min_ship' => 'nullable',
            'wt_pc' => 'required',
            'currency' => 'required',
        ]);


        $existingEntry = Entries::where('customer', $validatedData['customer'])
            ->where('part_number', $validatedData['part_number'])
            ->first();

        if ($existingEntry) {
            return redirect()->back()->with('error', 'This Part Number entry already exists.');
        }
        try {
            $validatedData['user_id'] = Auth::user()->id;
            $validatedData['moq'] = $this->removeCommas($validatedData['moq']);
            $validatedData['safety'] = $this->removeCommas($validatedData['safety']);
            $validatedData['min_ship'] = $this->removeCommas($validatedData['min_ship']);
            $validatedData['in_process_outside'] = $request->outside_processing_text_1;

            $entry = Entries::create($validatedData);
            $entry->last_updated_by = auth()->id();
            $entry->save();

            $work_centres = [
                'work_centre_1' => $validatedData['work_centre_1'],
                'work_centre_2' => $validatedData['work_centre_2'] ?? null,
                'work_centre_3' => $validatedData['work_centre_3'] ?? null,
                'work_centre_4' => $validatedData['work_centre_4'] ?? null,
                'work_centre_5' => $validatedData['work_centre_5'] ?? null,
                'work_centre_6' => $validatedData['work_centre_6'] ?? null,
                'work_centre_7' => $validatedData['work_centre_7'] ?? null,
            ];

            $outside_processing = [
                'outside_processing_1' => $validatedData['outside_processing_1'] ?? null,
                'outside_processing_2' => $validatedData['outside_processing_2'] ?? null,
                'outside_processing_3' => $validatedData['outside_processing_3'] ?? null,
                'outside_processing_4' => $validatedData['outside_processing_4'] ?? null,
            ];

            $outside_processing_text = [
                'outside_processing_text_1' => $validatedData['outside_processing_text_1'] ?? null,
                'outside_processing_text_2' => $validatedData['outside_processing_text_2'] ?? null,
                'outside_processing_text_3' => $validatedData['outside_processing_text_3'] ?? null,
                'outside_processing_text_4' => $validatedData['outside_processing_text_4'] ?? null,
            ];

            // Get the entry ID
            $entryId = $entry->id;

            foreach ($work_centres as $centre => $value) {
                if (!empty($value) && $value != 'Select') {
                    $work_center = new WorkCenter();
                    $work_center->entry_id = $entryId;
                    $work_center->com = $value;
                    $work_center->work_centre_id = $centre;
                    $work_center->save();
                }
            }

            foreach ($outside_processing as $centre => $value) {
                if (!empty($value) && $value != 'Select') {
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

            $part = Parts::find($validatedData['part_number'])->Part_Number;

            $info = 'New entry has been created for part number: "' . $part . '"';

            $this->notificationService->sendNotification(Auth::user()->id, 'create_entries', ['message' => 'Entries has been added.'], 'entries', $entryId, '', '', '', 'add', $info);

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
            'ids' => 'nullable|string|max:255',
            'process' => 'nullable|string|max:255',
            'department' => 'nullable',
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
            'outside_processing_text_1' => 'nullable',
            'outside_processing_text_2' => 'nullable',
            'outside_processing_text_3' => 'nullable',
            'outside_processing_text_4' => 'nullable',
            'material' => 'nullable|string|max:255',
            'pc_weight' => 'nullable',
            'safety_shock' => 'nullable',
            'moq' => 'nullable',
            'order_notes' => 'nullable|string',
            'part_notes' => 'nullable|string',
            // 'future_raw' => 'nullable|string|max:255',
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

            // Store old values before update
            $oldValues = $entry->toArray();

            // Update main entry data
            $validatedData['user_id'] = Auth::user()->id;
            $validatedData['moq'] = $this->removeCommas($validatedData['moq']);
            $validatedData['safety'] = $this->removeCommas($validatedData['safety']);
            $validatedData['min_ship'] = $this->removeCommas($validatedData['min_ship']);
            $validatedData['in_process_outside'] = $request->outside_processing_text_1;
            $entry->update($validatedData);
            $entry->last_updated_by = auth()->id();
            $entry->save();

            // Track changed values for broadcasting
            $data_updates = [];
            foreach ($validatedData as $field => $newValue) {
                if (isset($oldValues[$field]) && $oldValues[$field] != $newValue) {
                    $data_updates['entries_' . $id . '_' . $field] = $newValue;
                }
            }

            // Broadcast the event if any values changed
            if (!empty($data_updates)) {
                event(new StockUpdate($data_updates));
            }

            // Prepare work centers and outside processing data
            $work_centres = [
                'work_centre_1' => $validatedData['work_centre_1'] ?? null,
                'work_centre_2' => $validatedData['work_centre_2'] ?? null,
                'work_centre_3' => $validatedData['work_centre_3'] ?? null,
                'work_centre_4' => $validatedData['work_centre_4'] ?? null,
                'work_centre_5' => $validatedData['work_centre_5'] ?? null,
                'work_centre_6' => $validatedData['work_centre_6'] ?? null,
                'work_centre_7' => $validatedData['work_centre_7'] ?? null,
            ];

            $outside_processing = [
                'outside_processing_1' => $validatedData['outside_processing_1'] ?? null,
                'outside_processing_2' => $validatedData['outside_processing_2'] ?? null,
                'outside_processing_3' => $validatedData['outside_processing_3'] ?? null,
                'outside_processing_4' => $validatedData['outside_processing_4'] ?? null,
            ];

            $outside_processing_text = [
                'outside_processing_text_1' => $validatedData['outside_processing_text_1'] ?? null,
                'outside_processing_text_2' => $validatedData['outside_processing_text_2'] ?? null,
                'outside_processing_text_3' => $validatedData['outside_processing_text_3'] ?? null,
                'outside_processing_text_4' => $validatedData['outside_processing_text_4'] ?? null,
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

            $weeks_histroy = WeeksHistory::where('entry_id', $id)->get();
            foreach ($weeks_histroy as $weeks_histroy) {
                $weeks_histroy->part_number = $validatedData['part_number'];
                $weeks_histroy->customer = $validatedData['customer'];
                $weeks_histroy->department = $validatedData['department'];
                $weeks_histroy->save();
            }

            $part = Parts::find($validatedData['part_number'])->Part_Number;

            $info = 'Entry has been updated for part number: "' . $part . '"';

            $this->notificationService->sendNotification(Auth::user()->id, 'update_entries', ['message' => 'Entries have been updated.'], 'entries', $entry->id, '', '', '', 'update', $info);
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
        // if (Auth::user()->role == 1) {
        $parts = Entries::with('part')->get();
        // } else {
        //     $parts = Entries::with('part')->where('user_id', Auth::user()->id)->get();
        // }
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

        $out1 = OutSource::with(['entries_data.get_customer', 'entries_data.part', 'out_source'])
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->whereHas('entries_data', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            })
            ->get();

        $customers = Customer::get();

        $parts = Parts::get();

        return view('input-screen', compact('com1', 'out1', 'customers', 'parts'));
    }

    public function save_table_data(Request $request)
    {
        $validated = $request->validate([
            'entries' => 'required|array',
            'entries.*.status' => 'required|string',
            'entries.*.customer' => 'nullable|string',
            'entries.*.part_number' => 'nullable|string',
            'entries.*.quantity' => 'nullable|integer',
            'entries.*.job' => 'nullable|string',
            'entries.*.lot' => 'nullable|string',
            'entries.*.type' => 'nullable|string',
            'entries.*.type_id' => 'nullable|string',
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
            'entries_data.*.customer' => 'nullable|string',
            'entries_data.*.part_number' => 'nullable|string',
            'entries_data.*.quantity' => 'nullable|integer',
            'entries_data.*.job' => 'nullable|string',
            'entries_data.*.lot' => 'nullable|string',
            'entries_data.*.type' => 'nullable|string',
            'entries_data.*.type_id' => 'nullable|string',
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
        $search = $request->input('search');
        // $posttype = $request->input('post_type');
        $userId = $request->input('user_id');
        $status = $request->input('status'); // Get status filter

        $notificationsQuery = Notification::with('user', 'target_cell');

        if ($search) {
            $notificationsQuery->where(function ($query) use ($search) {
                $query->where('data', 'like', '%' . $search . '%')
                    ->orWhere('info', 'like', '%' . $search . '%')
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.some_key')) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        // if ($posttype) {
        //     $notificationsQuery->where('post_type', $posttype);
        // }

        if ($status) {
            $notificationsQuery->where('post_type', $status);
        }

        if (Auth::user()->role != 1) {
            $notificationsQuery->where('user_id', Auth::id());
        } elseif ($userId && $userId !== 'all') {
            $notificationsQuery->where('user_id', $userId);
        }

        $notifications = $notificationsQuery->orderBy('created_at', 'desc')->paginate(10);
        $users = User::where('role', 2)->get();

        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        $filter = [
            'Today' => $notifications->filter(fn($n) => $n->created_at->toDateString() === $today),
            'Yesterday' => $notifications->filter(fn($n) => $n->created_at->toDateString() === $yesterday),
        ];

        $filtered = $notifications->reject(
            fn($n) => $n->created_at->toDateString() === $today ||
            $n->created_at->toDateString() === $yesterday
        )->groupBy(fn($n) => $n->created_at->format('y-m-d'));

        $filters = array_merge($filter, $filtered->toArray());

        if ($request->ajax()) {
            $html = view('partials.notification-ajax', ['notifications' => $notifications, 'filters' => $filters])->render();
            return response()->json(['html' => $html]);
        }

        return view('notifications', compact('notifications', 'users', 'filters'));
    }

    public function visual_screen()
    {
        $visuals = Visual::with('part')
            ->when(Auth::user()->role != 1, function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->get()
            ->groupBy('status');

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
        if (Auth::user()->user_maintenance == 1) {
            return view('add-user');
        }
        return redirect()->route('index');
    }

    public function get_part_no_detail(Request $request)
    {
        $partNumber = $request->get('part_number');

        $entries = Entries::with('last_updated_by_user')->where('part_number', $partNumber)->first();

        if (!$entries) {
            return response()->json(['message' => 'No entry found for the provided part number.']);
        }

        $last_update_user = $entries->last_updated_by_user->name ?? null;
        $last_update_date = is_null($entries->updated_at) ? $entries->created_at : $entries->updated_at;
        if (!is_null($last_update_user)) {
            $date_string = \Carbon\Carbon::parse($last_update_date)->format('d F Y, h:i A');
        } else {
            $date_string = null;
        }

        return response()->json([
            'success' => true,
            'existing_amount' => $entries->in_stock_finish,
            'revision' => $entries->revision,
            'safety' => $entries->safety,
            'min_ship' => $entries->min_ship,
            'part_notes' => $entries->part_notes,
            'last_update_user' => $last_update_user,
            'last_update_date' => $date_string,
        ]);
    }

    public function create_shipment_order_not($id)
    {
        $create_shipment_order = Notification::with('user')
            ->where('type', 'create_shipment_order')
            ->where('reference_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$create_shipment_order) {
            return response()->json([
                'last_update_user' => null,
                'last_update_date' => null,
            ]);
        }

        $last_update_user = $create_shipment_order->user->name ?? null;
        $last_update_date = is_null($create_shipment_order->updated_at) ? $create_shipment_order->created_at : $create_shipment_order->updated_at;
        if (!is_null($last_update_user)) {
            $date_string = \Carbon\Carbon::parse($last_update_date)->format('d F Y, h:i A');
        } else {
            $date_string = null;
        }

        return response()->json([
            'last_update_user' => $last_update_user,
            'last_update_date' => $date_string,
        ]);
    }

    public function update_production_total_not($id)
    {
        $update_production_total = Notification::with('user')
            ->where('type', 'update_production_total')
            ->where('reference_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$update_production_total) {
            return response()->json([
                'last_update_user' => null,
                'last_update_date' => null,
            ]);
        }

        $last_update_user = $update_production_total->user->name ?? null;
        $last_update_date = is_null($update_production_total->updated_at) ? $update_production_total->created_at : $update_production_total->updated_at;
        if (!is_null($last_update_user)) {
            $date_string = \Carbon\Carbon::parse($last_update_date)->format('d F Y, h:i A');
        } else {
            $date_string = null;
        }

        return response()->json([
            'last_update_user' => $last_update_user,
            'last_update_date' => $date_string,
        ]);
    }

    public function add_shipment_not($id)
    {
        $add_shipment = Notification::with('user')
            ->where('type', 'detect_production')
            ->where('reference_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$add_shipment) {
            return response()->json([
                'last_update_user' => null,
                'last_update_date' => null,
            ]);
        }

        $last_update_user = $add_shipment->user->name ?? null;
        $last_update_date = is_null($add_shipment->updated_at) ? $add_shipment->created_at : $add_shipment->updated_at;
        if (!is_null($last_update_user)) {
            $date_string = \Carbon\Carbon::parse($last_update_date)->format('d F Y, h:i A');
        } else {
            $date_string = null;
        }

        return response()->json([
            'last_update_user' => $last_update_user,
            'last_update_date' => $date_string,
        ]);
    }

    public function update_production_total(Request $request)
    {
        $existingAmount = $request->input('existing_amount');
        $addProduction = $request->input('add_production');
        $newTotal = $request->input('new_total');
        $part_no = $request->input('part_no');

        $data = Entries::with('part')->where('part_number', $part_no)->first();

        $data->in_stock_finish = $newTotal;
        $data->last_updated_by = Auth::user()->id;
        $data->save();

        $info = 'Production total has been change "' . $existingAmount . '" to "' . $newTotal . '" for part number: "' . $data->part->Part_Number . '"';

        $this->notificationService->sendNotification(Auth::user()->id, 'update_production_total', ['message' => 'Production Total Updated'], 'entries', $part_no, '', '', '', 'update', $info);

        $data_updates = [
            'entries_' . $data->id . '_in_stock_finished' => $data->in_stock_finish
        ];
        // Broadcast the event
        event(new StockUpdate($data_updates));

        return response()->json([
            'message' => 'Production total updated successfully!',
            'new_total' => $newTotal
        ]);
    }

    private function calculateWeeksMonths($data, $dataId)
    {
        $weeksDataFormatted = [];
        $sumWeeks1To6 = array_sum([
            $data->week_1,
            $data->week_2,
            $data->week_3,
            $data->week_4,
            $data->week_5,
            $data->week_6,
        ]);
        $sumWeeks7To12 = array_sum([
            $data->week_7,
            $data->week_8,
            $data->week_9,
            $data->week_10,
            $data->week_11,
            $data->week_12,
        ]);

        $in_stock_finish = $data->in_stock_finish ?? 0;
        $wt_pc = $data->wt_pc ?? 0;

        if ($sumWeeks1To6 != 0 && $sumWeeks7To12 != 0) {
            $WT_RQ = max(($sumWeeks1To6 + $sumWeeks7To12 - $in_stock_finish) * $wt_pc, 0);
        } else {
            $WT_RQ = 0;
        }

        $sum1_12 = $sumWeeks1To6 + $sumWeeks7To12;
        $sumWeeks1To6 += ((float) $data->past_due ?? 0);
        $sum1_12_f = (($sum1_12 - $in_stock_finish) > 0) ? number_format(($sum1_12 - $in_stock_finish) * $wt_pc, 2) : 0;
        // Add calculated values to broadcast payload
        $weeksDataFormatted['entries_' . $dataId . '_past_due'] = $data->past_due ?? 0;
        $weeksDataFormatted['entries_' . $dataId . '_reqd_1_6_weeks'] = $sumWeeks1To6;
        $weeksDataFormatted['entries_' . $dataId . '_reqd_7_12_weeks'] = $sumWeeks7To12;
        $weeksDataFormatted['entries_' . $dataId . '_wt_reqd_1_12_weeks'] = $sum1_12_f;
        //dates
        // $weeksDataFormatted = [];

        // Format week headers dynamically from provided $data values
        for ($week = 1; $week <= 16; $week++) {
            $weekKey = "week_{$week}_date"; // Constructing property name
            if (!empty($data->$weekKey)) {
                $weeksDataFormatted["head_week_{$week}"] = date('j-M', strtotime($data->$weekKey));
            }
        }

        // Format month headers dynamically from provided $data values
        for ($month = 5; $month <= 12; $month++) {
            $monthKey = "month_{$month}_date"; // Constructing property name
            if (!empty($data->$monthKey)) {
                $weeksDataFormatted["head_month_{$month}"] = date('j-M', strtotime($data->$monthKey));
            }
        }

        return $weeksDataFormatted;
    }

    public function create_order(Request $request)
    {
        $request->validate([
            'weeks' => 'nullable|array',
            'weeks.*' => 'nullable|string',
            'weeks_edit' => 'nullable|array',
            'weeks_edit.*' => 'nullable|string',
            'part_number' => 'required',
            'future_raw' => 'nullable',
            'past_val' => 'nullable'
        ]);

        $data = Weeks::where('part_number', $request->part_number)
            ->first();

        $part = Entries::with('part')->where('part_number', $request->part_number)
            ->first();

        $isNewEntry = false;

        $weeksData = $data ? $request->weeks_edit : $request->weeks;

        if (!$data) {
            $data = new Weeks();
            $data->user_id = Auth::user()->id;
            $data->part_number = $request->part_number;
            $isNewEntry = true;
        }

        $temp = $isNewEntry ? $this->getWeekArr(date('Y-m-d')) : null;
        // Prepare weeksData for broadcasting
        $weeksDataFormatted = [];

        foreach ($weeksData as $key => $value) {
            if ($value === null) {
                continue;
            }

            $data->$key = str_replace(',', '', $value);

            if ($isNewEntry) {
                $data->{$key . '_date'} = $temp[$key];
            }
            // Format key to match your frontend structure
            $weeksDataFormatted['entries_' . $part->id . '_' . $key] = str_replace(',', '', $value);
        }

        $data->past_due = $request->past_val;
        $data->save();

        if ($part) {
            $part->filter = 'pending';
            $part->future_raw = str_replace(',', '', $request->future_raw);
            $part->last_updated_by = Auth::user()->id;
            $part->save();
        }

        $weeksDataFormatted['entries_' . $part->id . '_future_raw'] = str_replace(',', '', $request->future_raw);
        // Perform calculations for weeks 1 to 6 and weeks 7 to 12

        $calArr = $this->calculateWeeksMonths($data, $part->id);
        $mergedData = array_merge($calArr, $weeksDataFormatted);

        // Broadcast the updated values via Pusher
        event(new StockUpdate($mergedData));


        // Send notification
        $message = $isNewEntry ? 'Order Created' : 'Order Updated';
        $info = '"' . $part->part->Part_Number . '" ' . $message;
        $this->notificationService->sendNotification(
            Auth::user()->id,
            'create_shipment_order',
            ['message' => $message],
            'entries',
            $request->part_number,
            '',
            '',
            '',
            $isNewEntry ? 'add' : 'update',
            $info
        );

        WeeksHistory::create([
            'user_id' => Auth::user()->id,
            'entry_id' => $part->id,
            'customer' => $part->customer,
            'department' => $part->department,
            'part_number' => $part->part_number,
            'week_values' => json_encode($weeksData),
            'past_due' => $request->past_val,
            'updated_by' => Auth::user()->id,
        ]);

        return response()->json(['message' => $message, 'past_due' => $request->past_val, 'future_raw' => number_format((float) $part->future_raw), 'data' => $data]);
    }

    public function add_shipment(Request $request)
    {
        $request->validate([
            'weeks' => 'required|array',
            'weeks.*' => 'nullable|string',
            'part_number' => 'required'
        ]);

        $data = Weeks::where('part_number', $request->part_number)->first();
        if (!$data) {
            return response()->json(['error' => true, 'message' => 'No weeks data found for the provided part number.']);
        }
        $entries = Entries::with('part')->where('part_number', $request->part_number)->first();

        foreach ($request->weeks as $key => $value) {
            if ($value != '' && $value != null) {
                $data->$key = (float) str_replace(',', '', $value);
                // $data->$key = $value;
            }
        }
        $data->save();

        $info = 'Shipment Order has been added for part number: "' . $entries->part->Part_Number . '"';

        $this->notificationService->sendNotification(Auth::user()->id, 'add_shipment', ['message' => 'Shipment Added.'], 'entries', $request->part_number, '', '', '', 'add', $info);

        return response()->json(['message' => 'Shipment Order Created', 'data' => $data]);
    }

    public function get_weeks(Request $request)
    {
        $data = Weeks::where('part_number', $request->part_number)->first();
        $entries = Entries::where('part_number', $request->part_number)->first();

        $Arr = [
            "week_1" => $data->week_1 ?? null,
            "week_2" => $data->week_2 ?? null,
            "week_3" => $data->week_3 ?? null,
            "week_4" => $data->week_4 ?? null,
            "week_5" => $data->week_5 ?? null,
            "week_6" => $data->week_6 ?? null,
            "week_7" => $data->week_7 ?? null,
            "week_8" => $data->week_8 ?? null,
            "week_9" => $data->week_9 ?? null,
            "week_10" => $data->week_10 ?? null,
            "week_11" => $data->week_11 ?? null,
            "week_12" => $data->week_12 ?? null,
            "week_13" => $data->week_13 ?? null,
            "week_14" => $data->week_14 ?? null,
            "week_15" => $data->week_15 ?? null,
            "week_16" => $data->week_16 ?? null,
            "month_5" => $data->month_5 ?? null,
            "month_6" => $data->month_6 ?? null,
            "month_7" => $data->month_7 ?? null,
            "month_8" => $data->month_8 ?? null,
            "month_9" => $data->month_9 ?? null,
            "month_10" => $data->month_10 ?? null,
            "month_11" => $data->month_11 ?? null,
            "month_12" => $data->month_12 ?? null,
        ];

        return response()->json(['message' => 'Get Weeks', 'in_stock_finish' => $entries->in_stock_finish, 'future_raw' => $entries->future_raw, 'data' => $Arr]);
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
        $data = Weeks::where('part_number', $partNumber)->first();
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
        // return $array_1;

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

        // $array_1['month_12'] = null;

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
        $weeksDataFormatted = [];
        $data = Weeks::where('part_number', $request->part_number)->first();
        $entries = Entries::with('part')->where('part_number', $request->part_number)->first();

        foreach ($request->shipmentData as $shipment) {
            if ($shipment['value'] != '' && $shipment['value'] != null) {
                if ($shipment['weekKey'] === 'past_due') {
                    // Update the past_due field in another table (e.g., PastDueTable)
                    $data->past_due = $shipment['value'];
                    $weeksDataFormatted['entries_' . $entries->id . '_past_due'] = $shipment['value'];
                } else {
                    // Update fields in the Weeks table
                    $data->{$shipment['weekKey']} = $shipment['value'];
                    $weeksDataFormatted['entries_' . $entries->id . '_' . $shipment['weekKey']] = $shipment['value'];
                }
            }
        }
        $data->save();

        // Update Entries table
        $entries->in_stock_finish -= (float) $request->shipped_amount;
        $entries->save();

        $info = 'Shipment Amount (' . $request->shipped_amount . ') has been added for part number: "' . $entries->part->Part_Number . '"';

        $this->notificationService->sendNotification(Auth::user()->id, 'save_shipment_data', ['message' => 'Shipment Amount Saved'], 'weeks', $entries->part_number, '', '', '', 'add', $info);

        $info = 'In Stock Amount (' . $entries->in_stock_finish . ') has been updated for part number: "' . $entries->part->Part_Number . '"';

        $this->notificationService->sendNotification(Auth::user()->id, 'detect_production', ['message' => 'Weeks In Stock Updated'], 'weeks', $entries->part_number, '', '', '', 'update', $info);

        $weeksDataFormatted['entries_' . $entries->id . '_in_stock_finish'] = $entries->in_stock_finish;

        // Broadcast the event
        event(new StockUpdate($weeksDataFormatted));

        return response()->json(['message' => 'Shipment Amount Saved', 'data' => $data, 'existing_amount' => number_format($entries->in_stock_finish)]);
    }

    public function change_past_due(Request $request)
    {
        $data = Weeks::where('part_number', $request->part_number)->first();
        $entries = Entries::with('part')->where('part_number', $request->part_number)->first();

        if (!$data) {
            return response()->json(['error' => true, 'message' => 'No weeks data found for the provided part number.']);
        }

        $old_past_due = $data->past_due;
        $data->past_due = $request->past_due;
        $data->save();

        $info = 'Past Due changed "' . $old_past_due . '" to "' . $data->past_due . '"  for part number: "' . $entries->part->Part_Number . '"';

        $this->notificationService->sendNotification(Auth::user()->id, 'change_past_due', ['message' => 'Past Due Changed'], 'weeks', $data->id, '', '', '', 'update', $info);

        $data_updates = [
            'entries_' . $entries->id . '_past_due' => $data->past_due
        ];
        // Broadcast the event
        event(new StockUpdate($data_updates));

        return response()->json(['message' => 'Past Due Changed', 'past_due' => $data->past_due]);
    }

    public function update_week_or_month(Request $request)
    {
        $data = Weeks::where('part_number', $request->part_number)->first();
        $data->{$request->id} = $request->value;
        $data->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'update_week_or_month', ['message' => 'Weeks or Month Updated'], 'weeks', $data->id, 'update');

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

    public function resetUserConfiguration(Request $request)
    {
        try {
            // Default configurations for region 1
            $region1Config = [
                ['column' => 'department', 'order' => 1, 'visibility' => true],
                ['column' => 'work_center', 'order' => 2, 'visibility' => true],
                ['column' => 'planning_queue', 'order' => 3, 'visibility' => true],
                ['column' => 'status', 'order' => 4, 'visibility' => true],
                ['column' => 'job_number', 'order' => 5, 'visibility' => true],
                ['column' => 'lot_number', 'order' => 6, 'visibility' => true],
                ['column' => 'ids', 'order' => 7, 'visibility' => true],
                ['column' => 'part_number', 'order' => 8, 'visibility' => true],
                ['column' => 'customer', 'order' => 9, 'visibility' => true],
                ['column' => 'rev', 'order' => 10, 'visibility' => true],
                ['column' => 'process', 'order' => 11, 'visibility' => true]
            ];

            // Default configurations for region 2
            $region2Config = [
                ['column' => 'reqd_1_6_weeks', 'order' => 1, 'visibility' => true],
                ['column' => 'reqd_7_12_weeks', 'order' => 2, 'visibility' => true],
                ['column' => 'scheduled_total', 'order' => 3, 'visibility' => true],
                ['column' => 'in_stock_finished', 'order' => 4, 'visibility' => true],
                ['column' => 'live_inventory_finished', 'order' => 5, 'visibility' => true],
                ['column' => 'live_inventory_wip', 'order' => 6, 'visibility' => true],
                ['column' => 'in_process_out_side', 'order' => 7, 'visibility' => true],
                ['column' => 'on_order_raw_matl', 'order' => 8, 'visibility' => true],
                ['column' => 'in_stock_live', 'order' => 9, 'visibility' => true],
                ['column' => 'wt_pc', 'order' => 10, 'visibility' => true],
                ['column' => 'material_sort', 'order' => 11, 'visibility' => true],
                ['column' => 'wt_reqd_1_12_weeks', 'order' => 12, 'visibility' => true],
                ['column' => 'safety', 'order' => 13, 'visibility' => true],
                ['column' => 'min_ship', 'order' => 14, 'visibility' => true],
                ['column' => 'order_notes', 'order' => 15, 'visibility' => true],
                ['column' => 'part_notes', 'order' => 16, 'visibility' => true]
            ];

            // Reset configurations
            UserConfig::where('user_id', auth()->id())
                ->whereIn('key', ['master_screen_region_1_column_configuration', 'master_screen_region_2_column_configuration'])
                ->delete();

            // Insert default configurations
            UserConfig::create([
                'user_id' => auth()->id(),
                'key' => 'master_screen_region_1_column_configuration',
                'value' => json_encode($region1Config)
            ]);

            UserConfig::create([
                'user_id' => auth()->id(),
                'key' => 'master_screen_region_2_column_configuration',
                'value' => json_encode($region2Config)
            ]);

            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Configurations have been reset!',
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

    public function highlight_cell_for_me(Request $request)
    {
        try {
            $request->validate([
                'identifier' => 'required'
            ]);

            if ($request->color == 'rgb(255, 255, 255)') {
                $record = HighlightedCell::where([
                    'user_id' => auth()->id(),
                    'identifier' => $request->identifier
                ])->first();

                if ($record) {
                    $record->delete();
                }

                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'Cell un-highlighted!',
                    'errors' => [],
                ]);
            }


            HighlightedCell::create([
                'user_id' => auth()->id(),
                'identifier' => $request->identifier,
                'color' => $request->color,
            ]);

            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Cell highlighted!',
                'errors' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $e->getMessage(),
                'errors' => [],
            ]);
        }
    }

    public function delete_entry($id)
    {
        $entry = Entries::find($id);

        if (!$entry) {
            return response()->json(['message' => 'Entry not found.'], 404);
        }

        $entry->delete();

        return response()->json(['message' => 'Entry deleted successfully.']);
    }

    public function get_qa($part)
    {

        return $query = Entries::with([
            'part',
            'weeks_months',
            'work_center_one',
            'out_source_one',
            'get_department',
            'get_customer',
            'get_material'
        ])->where('part_number', $part)->first();

        return view('qa', compact('query'));
    }

    public function report($userId)
    {
        $parts = Parts::all();
        return view('report', compact('parts', 'userId'));
    }

    public function getReportData(Request $request)
    {
        $query = WeeksHistory::with([
            'entry.get_department',
            'entry.get_customer',
            'entry.part'
        ])->select('weeks_history.*');

        if ($request->has('userId')) {
            $query->where('weeks_history.user_id', $request->userId);
        }

        // Apply date range filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereDate('weeks_history.created_at', '>=', $request->start_date)
                ->whereDate('weeks_history.created_at', '<=', $request->end_date);
        }

        if ($request->has('filter') && $request->filter == 'customer') {
            $query->orderBy('weeks_history.customer', 'asc');
        } else if ($request->has('filter') && $request->filter == 'part_number') {
            $query->orderBy('weeks_history.part_number', 'asc');
        } else if ($request->has('filter') && $request->filter == 'department') {
            $query->orderBy('weeks_history.department', 'asc');
        }

        return DataTables::of($query)
            ->addColumn('department', function ($row) {
                return $row->entry->get_department->name ?? 'N/A';
            })
            ->addColumn('customer', function ($row) {
                return $row->entry->get_customer->CustomerName ?? 'N/A';
            })
            ->addColumn('part_number', function ($row) {
                return $row->entry->part->Part_Number ?? 'N/A';
            })
            ->addColumn('date_search', function ($row) {
                return $row->created_at ?? '';
            })
            ->addColumn('in_stock', function ($row) {
                return $row->entry->in_stock_finish ?? '';
            })
            ->addColumn('past_due', function ($row) {
                return $row->past_due ?? '';
            })
            ->addColumn('balance_schedule', function ($row) {
                $total_weeks = Weeks::selectRaw('
                    COALESCE(month_5, 0) + COALESCE(month_6, 0) + COALESCE(month_7, 0) + COALESCE(month_8, 0) +
                    COALESCE(month_9, 0) + COALESCE(month_10, 0) + COALESCE(month_11, 0) + COALESCE(month_12, 0) AS total
                ')->where('part_number', $row->entry->part->id)->first();

                $weekValues = json_decode($row->week_values, true);
                $total = 0;
                for ($i = 1; $i <= 16; $i++) {
                    $total += (int) ($weekValues["week_$i"] ?? 0);
                }
                for ($i = 5; $i <= 12; $i++) {
                    $total += (int) ($weekValues["month_$i"] ?? 0);
                }
                return $total_weeks->total + $total;
            })
            ->addColumn('week_values', function ($row) {
                return json_decode($row->week_values, true);
            })
            ->make(true);
    }

    private function generateWeekColumns()
    {
        $columns = [];
        $today = date('Y-m-d');
        $dayOfWeek = date('w', strtotime($today));
        $mondayOfWeek = $dayOfWeek == 0
            ? date('Y-m-d', strtotime('-6 days', strtotime($today)))
            : date('Y-m-d', strtotime('-' . ($dayOfWeek - 1) . ' days', strtotime($today)));

        for ($week = 1; $week <= 16; $week++) {
            $weekKey = "week_$week";
            $columns[$weekKey] = function ($row) use ($weekKey) {
                $weekValues = json_decode($row->week_values, true);
                return $weekValues[$weekKey] ?? '';
            };
        }

        return $columns;
    }

    /**
     * Generates dynamic month columns (month_5 to month_12)
     */
    private function generateMonthColumns()
    {
        $columns = [];

        // Calculate the start date of week 16
        $today = date('Y-m-d');
        $dayOfWeek = date('w', strtotime($today));
        $mondayOfWeek = $dayOfWeek == 0
            ? date('Y-m-d', strtotime('-6 days', strtotime($today)))
            : date('Y-m-d', strtotime('-' . ($dayOfWeek - 1) . ' days', strtotime($today)));

        $week16StartDate = date('Y-m-d', strtotime('+15 weeks', strtotime($mondayOfWeek)));
        $week16EndDate = date('Y-m-d', strtotime('+6 days', strtotime($week16StartDate)));
        $month5StartDate = date('Y-m-d', strtotime('+1 day', strtotime($week16EndDate)));

        for ($month = 5; $month <= 12; $month++) {
            $monthKey = "month_$month";
            $columns[$monthKey] = function ($row) use ($monthKey) {
                $weekValues = json_decode($row->week_values, true);
                return $weekValues[$monthKey] ?? '';
            };

            $month5StartDate = date('Y-m-d', strtotime('+31 days', strtotime($month5StartDate)));
        }

        return $columns;
    }
}
