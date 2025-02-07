<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;

    protected $table = "notifications";

    protected $fillable = ['user_id', 'type', 'data', 'reference_table', 'reference_id', 'is_read', 'post_type', 'info'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($data) {
            DB::table('target_cells')->where('notification_id', $data->id)->delete();
            DB::table('target_rows')->where('notification_id', $data->id)->delete();
        });
    }

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
