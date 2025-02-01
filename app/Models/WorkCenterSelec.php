<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkCenterSelec extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "work_center_selector";
}
