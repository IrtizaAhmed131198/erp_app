<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    use HasFactory;

    protected $table = "entries";

    protected $fillable = [
        'user_id',
        'part_number',
        'customer',
        'revision',
        'ids',
        'process',
        'department',
        'work_centre_1',
        'work_centre_2',
        'work_centre_3',
        'work_centre_4',
        'work_centre_5',
        'work_centre_6',
        'work_centre_7',
        'outside_processing_1',
        'outside_processing_2',
        'outside_processing_3',
        'outside_processing_4',
        'material',
        'pc_weight',
        'safety_shock',
        'moq',
        'order_notes',
        'part_notes',
        'future_raw',
        'price',
        'notes',
        'in_stock_finish',
        'filter',
        'job',
        'lot',
        'raw_mat',
    ];

    public function weeks_months()
    {
        return $this->hasOne(Weeks::class, 'part_number', 'part_number');
    }

    public function work_center()
    {
        return $this->hasMany(WorkCenter::class, 'entry_id', 'id');
    }

    public function out_source()
    {
        return $this->hasMany(OutSource::class, 'entry_id', 'id');
    }

    public function work_center_one()
    {
        return $this->hasOne(WorkCenter::class, 'entry_id', 'id');
    }
}
