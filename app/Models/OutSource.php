<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutSource extends Model
{
    use HasFactory;

    protected $table = "outsource";

    public function entries_data()
    {
        return $this->hasOne(Entries::class, 'id', 'entry_id');
    }
}
