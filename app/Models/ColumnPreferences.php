<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnPreferences extends Model
{
    use HasFactory;

    protected $table = "user_column_preferences";

    protected $fillable = ['user_id', 'columns'];
}
