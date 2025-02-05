<?php

namespace App\Http\Controllers;

use App\Models\Parts;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Material;
use App\Models\Department;
use App\Models\Entries;
use App\Models\Weeks;
use Illuminate\Http\Request;
use App\Models\WorkCenterSelec;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PartnumberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('source')) {
                $source = $request->input('source');

                switch ($source) {
                    case 'parts':
                        $data = Parts::select(['id', 'Part_Number']);
                        return DataTables::of($data)
                            ->addColumn('action', function ($row) {
                                return '<a href="#" data-bs-toggle="modal"
                                            data-bs-target="#partNumber" class="btn btn-success opendata"
                                            data-column="' . $row->Part_Number . '"
                                            data-id="' . $row->id . '">Edit</a>
                                        <button type="button" class="btn btn-danger delete-part"
                                            data-id="' . $row->id . '">Delete</button>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    case 'customer':
                        $data = Customer::select(['id', 'CustomerName']);
                        return DataTables::of($data)
                            ->addColumn('action', function ($row) {
                                return '<a href="#" data-bs-toggle="modal"
                                            data-bs-target="#customer1" class="btn btn-success opendata1"
                                            data-column="' . $row->CustomerName . '"
                                            data-id="' . $row->id . '">Edit</a>
                                        <button type="button" class="btn btn-danger" id="delete-cus"
                                            data-id="' . $row->id . '">Delete</button>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    case 'out':
                        $data = Vendor::select(['id', 'name']);
                        return DataTables::of($data)
                            ->addColumn('action', function ($row) {
                                return '<a href="#" data-bs-toggle="modal"
                                            data-bs-target="#partNumber4" class="btn btn-success opendata4"
                                            data-column="' . $row->name . '"
                                            data-id="' . $row->id . '">Edit</a>
                                        <button type="button" class="btn btn-danger" id="delete-out"
                                            data-id="' . $row->id . '">Delete</button>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    case 'department':
                        $data = Department::select(['id', 'name']);
                        return DataTables::of($data)
                            ->addColumn('action', function ($row) {
                                return '<a href="#" data-bs-toggle="modal"
                                            data-bs-target="#partNumber2" class="btn btn-success opendata2"
                                            data-column="' . $row->name . '"
                                            data-id="' . $row->id . '">Edit</a>
                                        <button type="button" class="btn btn-danger" id="delete-depart"
                                            data-id="' . $row->id . '">Delete</button>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    case 'work':
                        $data = WorkCenterSelec::select(['id', 'name']);
                        return DataTables::of($data)
                            ->addColumn('action', function ($row) {
                                return '<a href="#" data-bs-toggle="modal"
                                            data-bs-target="#partNumber3" class="btn btn-success opendata3"
                                            data-column="' . $row->name . '"
                                            data-id="' . $row->id . '">Edit</a>
                                        <button type="button" class="btn btn-danger" id="delete-work"
                                            data-id="' . $row->id . '">Delete</button>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    case 'material':
                        $data = Material::select(['id', 'Package']);
                        return DataTables::of($data)
                            ->addColumn('action', function ($row) {
                                return '<a href="#" data-bs-toggle="modal"
                                            data-bs-target="#partNumber5" class="btn btn-success opendata5"
                                            data-column="' . $row->Package . '"
                                            data-id="' . $row->id . '">Edit</a>
                                        <button type="button" class="btn btn-danger" id="delete-data"
                                            data-id="' . $row->id . '">Delete</button>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    // Add more cases as needed for other data sources
                    default:
                        return response()->json(['message' => 'Invalid source'], 400);
                }
            }
        }

        // For non-ajax requests, just return the view with other data
        $customer = Customer::paginate(10);
        $department = Department::get();
        $work_center_selector = WorkCenterSelec::paginate(10);
        $vendor = Vendor::paginate(10);
        $package = Material::paginate(10);

        return view('partsnumber.index', compact('customer', 'department', 'work_center_selector', 'vendor', 'package'));
    }

    public function partupdate(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string|max:255',
            'id' => 'required|exists:parts,id',  // Validate the part ID
        ]);

        // Find the part by ID
        $part = Parts::find($request->id);

        if (!$part) {
            return response()->json([
                'success' => false,
                'message' => 'Part not found.',
            ]);
        }

        // Check if the part number already exists
        $existingPart = Parts::where('part_number', $request->part_number)->where('id', '!=', $request->id)->first();
        if ($existingPart) {
            return response()->json([
                'success' => false,
                'message' => 'Part number already exists.',
            ]);
        }

        // Update the part number
        $part->part_number = $request->part_number;
        $part->save();

        return response()->json([
            'success' => true,
            'message' => 'Part number updated successfully.',
            'part_number' => $part,
        ]);
    }

    public function customerupdate(Request $request)
    {
        $request->validate([
            'CustomerName' => 'required|string|max:255',
            'id' => 'required|exists:customers,id',  // Validate the part ID
        ]);

        // Find the part by ID
        $customer = Customer::find($request->id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ]);
        }

        // Check if the part number already exists
        $existingPart = Customer::where('CustomerName', $request->CustomerName)->where('id', '!=', $request->id)->first();
        if ($existingPart) {
            return response()->json([
                'success' => false,
                'message' => 'Customer number already exists.',
            ]);
        }

        // Update the part number
        $customer->CustomerName = $request->CustomerName;
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully.',
            'CustomerName' => $customer,
        ]);
    }

    public function departmentupdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'required|exists:department,id',  // Validate the part ID
        ]);

        // Find the part by ID
        $department = Department::find($request->id);

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.',
            ]);
        }

        // Check if the part number already exists
        $existingPart = Department::where('name', $request->name)->where('id', '!=', $request->id)->first();
        if ($existingPart) {
            return response()->json([
                'success' => false,
                'message' => 'Department number already exists.',
            ]);
        }

        // Update the part number
        $department->name = $request->name;
        $department->save();

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully.',
            'name' => $department,
        ]);
    }

    public function workupdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'required|exists:work_center_selector,id',  // Validate the part ID
        ]);

        // Find the part by ID
        $work_center = WorkCenterSelec::find($request->id);

        if (!$work_center) {
            return response()->json([
                'success' => false,
                'message' => 'Work center not found.',
            ]);
        }

        // Check if the part number already exists
        $existingPart = WorkCenterSelec::where('name', $request->name)->where('id', '!=', $request->id)->first();
        if ($existingPart) {
            return response()->json([
                'success' => false,
                'message' => 'Work center already exists.',
            ]);
        }

        // Update the part number
        $work_center->name = $request->name;
        $work_center->save();

        return response()->json([
            'success' => true,
            'message' => 'Work center updated successfully.',
            'name' => $work_center,
        ]);
    }

    public function vendorupdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'required|exists:vendor,id',  // Validate the part ID
        ]);

        // Find the part by ID
        $vendor = Vendor::find($request->id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'vendor not found.',
            ]);
        }

        // Check if the part number already exists
        $existingPart = WorkCenterSelec::where('name', $request->name)->where('id', '!=', $request->id)->first();
        if ($existingPart) {
            return response()->json([
                'success' => false,
                'message' => 'vendor already exists.',
            ]);
        }

        // Update the part number
        $vendor->name = $request->name;
        $vendor->save();

        return response()->json([
            'success' => true,
            'message' => 'vendor updated successfully.',
            'name' => $vendor,
        ]);
    }

    public function materialupdate(Request $request)
    {
        $request->validate([
            'Package' => 'required|string|max:255',
            'id' => 'required|exists:package,id',  // Validate the part ID
        ]);

        // Find the part by ID
        $material = Material::find($request->id);

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'Material not found.',
            ]);
        }

        // Check if the part number already exists
        $existingPart = WorkCenterSelec::where('name', $request->Package)->where('id', '!=', $request->id)->first();
        if ($existingPart) {
            return response()->json([
                'success' => false,
                'message' => 'Material already exists.',
            ]);
        }

        // Update the part number
        $material->Package = $request->Package;
        $material->save();

        return response()->json([
            'success' => true,
            'message' => 'Material updated successfully.',
            'Package' => $material,
        ]);
    }

    public function deletePart($id)
    {
        // Check if the part is used in another table
        if (Entries::where('part_number', $id)->exists()) {
            $availableParts = Parts::where('id', '!=', $id)->get(['id', 'Part_Number']); // Get all parts except the selected one
            return response()->json([
                'error' => 'This part is used in other records and cannot be deleted.',
                'parts' => $availableParts
            ], 400);
        }

        // Delete the part
        Parts::destroy($id);
        return response()->json(['success' => 'Part deleted successfully.']);
    }

    public function replacePart(Request $request)
    {
        $oldPartId = $request->old_part_id;
        $newPartId = $request->new_part_id;

        if (!$newPartId) {
            return response()->json(['error' => 'Replacement part is required!'], 400);
        }

        Entries::where('part_number', $oldPartId)->update(['part_number' => $newPartId]);
        Weeks::where('part_number', $oldPartId)->update(['part_number' => $newPartId]);
        Parts::destroy($oldPartId);

        return response()->json(['success' => 'Entries updated, and the part has been deleted.']);
    }

    // Force delete part even if used
    public function forceDeletePart($id)
    {
        // Delete all entries that use this part number
        Entries::where('part_number', $id)->delete();

        // Delete all entries that use this weeks
        Weeks::where('part_number', $id)->delete();

        // Now delete the part itself
        Parts::destroy($id);
        return response()->json(['success' => 'Part deleted permanently.']);
    }

    public function deleteWork($id)
    {
        // Delete the work
        WorkCenterSelec::destroy($id);
        return response()->json(['success' => 'Work center deleted successfully.']);
    }

    public function deleted_records_work()
    {
        $deletedRecords = WorkCenterSelec::onlyTrashed()->get();
        return response()->json($deletedRecords);
    }

    // Restore a specific record
    public function restore_work($id)
    {
        $record = WorkCenterSelec::onlyTrashed()->findOrFail($id);
        $record->restore();

        return response()->json(['success' => 'Record restored successfully']);
    }

    public function deleteOut($id)
    {
        // Delete the work
        Vendor::destroy($id);
        return response()->json(['success' => 'Outsource processing successfully.']);
    }

    // Restore a specific record
    public function restore_out($id)
    {
        $record = Vendor::onlyTrashed()->findOrFail($id);
        $record->restore();

        return response()->json(['success' => 'Record restored successfully']);
    }

    public function deleted_records_out()
    {
        $deletedRecords = Vendor::onlyTrashed()->get();
        return response()->json($deletedRecords);
    }

    public function deleteData($id)
    {
        // Delete the work
        Material::destroy($id);
        return response()->json(['success' => 'Outsource processing successfully.']);
    }

    public function deleted_records_data()
    {
        $deletedRecords = Material::onlyTrashed()->get();
        return response()->json($deletedRecords);
    }

    public function restore_data($id)
    {
        $record = Material::onlyTrashed()->findOrFail($id);
        $record->restore();

        return response()->json(['success' => 'Record restored successfully']);
    }

    public function deletedepart($id)
    {
        // Delete the work
        Department::destroy($id);
        return response()->json(['success' => 'Outsource processing successfully.']);
    }
    public function deleted_records_depart()
    {
        $deletedRecords = Department::onlyTrashed()->get();
        return response()->json($deletedRecords);
    }

    public function restore_depart($id)
    {
        $record = Department::onlyTrashed()->findOrFail($id);
        $record->restore();

        return response()->json(['success' => 'Record restored successfully']);
    }

    public function deleteCus($id)
    {
        // Delete the work
        Customer::destroy($id);
        return response()->json(['success' => 'Outsource processing successfully.']);
    }
    public function deleted_records_cus()
    {
        $deletedRecords = Customer::onlyTrashed()->get();
        return response()->json($deletedRecords);
    }

    public function restore_cus($id)
    {
        $record = Customer::onlyTrashed()->findOrFail($id);
        $record->restore();

        return response()->json(['success' => 'Record restored successfully']);
    }


    public function deletePartnum($id)
    {
        // Delete the work
        Parts::destroy($id);
        return response()->json(['success' => 'Outsource processing successfully.']);
    }
    public function deleted_records_part()
    {
        $deletedRecords = Parts::onlyTrashed()->get();
        return response()->json($deletedRecords);
    }

    public function restore_part($id)
    {
        $record = Parts::onlyTrashed()->findOrFail($id);
        $record->restore();

        return response()->json(['success' => 'Record restored successfully']);
    }


}
