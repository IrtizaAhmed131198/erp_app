<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visual extends Model
{
    use HasFactory;

    protected $table = "visuals";

    protected $fillable = [
        "status",
        "customer",
        "part_number",
        "quantity",
        "job",
        "lot",
        "type",
        "user_id",
        "type_id",
        "entry_id"
    ];

    public function part()
    {
        return $this->hasOne(Parts::class, 'id', 'part_number');
    }
}
