<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OutSource extends Model
{
    use HasFactory;

    protected $table = "outsource";

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($data) {
            DB::table('notifications')->where('reference_id', $data->id)->delete();
        });
    }

    public function entries_data()
    {
        return $this->hasOne(Entries::class, 'id', 'entry_id');
    }

    public function out_source()
    {
        return $this->hasOne(Vendor::class, 'id', 'out');
    }
}
