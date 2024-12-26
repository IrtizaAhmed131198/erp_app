<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'table',
        'ref_id'
    ];

    public function notification ()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
