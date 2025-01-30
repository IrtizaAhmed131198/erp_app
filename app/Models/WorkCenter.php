<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkCenter extends Model
{
    use HasFactory;

    protected $table = "work_center";

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($data) {
            DB::table('notifications')->where('reference_id', $data->id)->delete();
        });
    }

    public function entries()
    {
        return $this->hasOne(Entries::class, 'id', 'entry_id');
    }

    public function work_select()
    {
        return $this->hasOne(WorkCenterSelec::class, 'id', 'com');
    }
}
