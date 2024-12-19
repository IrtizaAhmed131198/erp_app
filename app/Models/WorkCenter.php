<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCenter extends Model
{
    use HasFactory;

    protected $table = "work_center";

    public function entries()
    {
        return $this->hasOne(Entries::class, 'id', 'entry_id');
    }
}
