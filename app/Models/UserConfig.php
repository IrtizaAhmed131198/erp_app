<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'key',
        'value'
    ];

    public function user ()
    {
        $this->belongsTo(User::class, 'user_id', 'id');
    }
}
