<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeksHistory extends Model
{
    use HasFactory;

    protected $table = "weeks_history";

    protected $fillable = [
        'user_id',
        'entry_id',
        'week_values',
        'past_due',
        'updated_by'
    ];

    protected $casts = [
        'week_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function entry()
    {
        return $this->belongsTo(Entries::class, 'entry_id');
    }
}
