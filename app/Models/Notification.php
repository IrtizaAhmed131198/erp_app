<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "notifications";

    protected $fillable = ['user_id', 'type', 'data', 'reference_table', 'reference_id', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function target_cell()
    {
        return $this->hasOne(TargetCell::class);
    }

    public function target_row()
    {
        return $this->hasOne(TargetRow::class);
    }
}
