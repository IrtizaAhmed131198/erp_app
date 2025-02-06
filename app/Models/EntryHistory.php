<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryHistory extends Model
{
    use HasFactory;

    protected $table = "entry_history";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entry()
    {
        return $this->belongsTo(Entries::class, 'entry_id');
    }
}
