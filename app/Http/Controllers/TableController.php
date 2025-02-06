<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parts;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Material;
use App\Models\WorkCenterSelec;
use App\Models\Vendor;
use App\Services\NotificationService;
use App\Models\Notification;

class TableController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function add_part_number(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string|max:255',
        ]);

        $data = Parts::where('part_number', $request->part_number)->first();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Part number already exists.',
            ]);
        }

        $partNumber = new Parts();
        $partNumber->part_number = $request->part_number;
        $partNumber->save();


        $this->notificationService->sendNotification(Auth::user()->id, 'create_part', ['message' => 'Part number has been added.'], 'parts', $partNumber->id, 'add');

        return response()->json([
            'success' => true,
            'message' => 'Part number added successfully.',
            'part_number' => $partNumber,
        ]);

    }

    public function add_customer(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
        ]);

        // $data = Customer::where('CustomerName', $request->customer_name)->first();
        // if ($data) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Customer already exists.',
        //     ]);
        // }

        $customer = new Customer();
        $customer->CustomerName = $request->customer_name;
        $customer->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'create_customer', ['message' => 'Customer has been added.'], 'customers', $customer->id, 'add');


        return response()->json([
            'success' => true,
            'message' => 'Customer added successfully.',
            'customer' => $customer,
        ]);
    }

    public function add_department(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = Department::where('name', $request->name)->first();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Department already exists.',
            ]);
        }

        $department = new Department();
        $department->name = $request->name;
        $department->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'create_department', ['message' => 'Department has been added.'], 'department', $department->id, 'add');


        return response()->json([
            'success' => true,
            'message' => 'Department added successfully.',
            'department' => $department,
        ]);
    }

    public function add_material(Request $request)
    {
        $request->validate([
            'package' => 'required|string|max:255',
        ]);

        $data = Material::where('Package', $request->package)->first();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Material already exists.',
            ]);
        }

        $material = new Material();
        $material->Package = $request->package;
        $material->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'create_material', ['message' => 'Material has been added.'], 'package', $material->id, 'add');

        return response()->json([
            'success' => true,
            'message' => 'Material added successfully.',
            'material' => $material,
        ]);
    }

    public function add_work_center(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = WorkCenterSelec::where('name', $request->name)->first();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Work Center already exists.',
            ]);
        }

        $workCenter = new WorkCenterSelec();
        $workCenter->name = $request->name;
        $workCenter->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'create_workCenter', ['message' => 'Work center has been added.'], 'work_center_selector', $workCenter->id, 'add');


        return response()->json([
            'success' => true,
            'message' => 'Work Center added successfully.',
            'workCenter' => $workCenter,
        ]);
    }

    public function add_outside_processing(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = Vendor::where('name', $request->name)->first();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Outside Processing already exists.',
            ]);
        }

        $outsideProcessing = new Vendor();
        $outsideProcessing->name = $request->name;
        $outsideProcessing->save();

        $this->notificationService->sendNotification(Auth::user()->id, 'create_vendor', ['message' => 'Vendor has been added.'], 'vendor', $outsideProcessing->id, 'add');


        return response()->json([
            'success' => true,
            'message' => 'Outside Processing added successfully.',
            'outsideProcessing' => $outsideProcessing,
        ]);
    }
}
