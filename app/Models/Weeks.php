<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weeks extends Model
{
    use HasFactory;

    protected $table = "weeks";

    protected $fillable = [
        "user_id",
        "part_number",
        "week_1",
        "week_2",
        "week_3",
        "week_4",
        "week_5",
        "week_6",
        "week_7",
        "week_8",
        "week_9",
        "week_10",
        "week_11",
        "week_12",
        "week_13",
        "week_14",
        "week_15",
        "week_16",
        "month_5",
        "month_6",
        "month_7",
        "month_8",
        "month_9",
        "month_10",
        "month_11",
        "month_12",
    ];

    public function entries()
    {
        return $this->belongsTo(Entries::class, 'part_number', 'part_number');
    }
}
