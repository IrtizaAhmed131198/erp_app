<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    protected $table = "reports";

    protected $appends = ['username', 'department_name', 'part_number_name', 'work_center_name', 'customer_name', 'material_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUsernameAttribute()
    {
        return $this->user ? $this->user->name : '';
    }

    public function getDepartmentNameAttribute()
    {
        $department = department::where('id', $this->department)->first();
        return $department ? $department->name : '';
    }

    public function getPartNumberNameAttribute()
    {
        $entries = Entries::where('id', $this->entry_id)->first();
        $entries->part_number;
        $PartNumber = Parts::where('id', $entries->part_number)->first();

        return $PartNumber ? $PartNumber->Part_Number : '';
    }

    public function getWorkCenterNameAttribute()
    {
        $work_center = WorkCenterSelec::where('id', $this->work_center)->first();
        return $work_center ? $work_center->name : '';
    }

    public function getCustomerNameAttribute()
    {
        $customer = Customer::where('id', $this->customer)->first();
        return $customer ? $customer->CustomerName : '';
    }

    public function getMaterialNameAttribute()
    {
        $material = Material::where('id', $this->material)->first();
        return $material ? $material->Package : '';
    }

}
