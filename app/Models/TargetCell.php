<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetCell extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'table',
        'ref_id',
        'field',
        'old',
        'new'
    ];

    public function notification ()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
