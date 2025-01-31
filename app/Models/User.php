<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'add_by',
        'role',
        'department',
        'phone',
        'successful_payments',
        'payouts',
        'fee_collection',
        'customer_payment_dispute',
        'refund_alerts',
        'invoice_payments',
        'webhook_api_endpoints',
        'user_img',
        'create_order',
        'user_maintenance',
        'visual_input_screen',
        'View_1',
        'View_2',
        'View_3',
        'status_column',
        'stock_finished_column',
        'part_number_column',
        'calendar_column',
        'input_screen_column'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($data) {
            DB::table('user_configs')->where('id', $data->id)->delete();
            DB::table('highlighted_cells')->where('id', $data->id)->delete();
        });
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }
    public function hasPermission($key)
    {
        return $this->permissions()->where('key', $key)->exists();
    }

    public function syncPermissions(array $permissions)
    {
        $permissionIds = Permission::whereIn('key', $permissions)->pluck('id');
        $this->permissions()->sync($permissionIds);
    }

    public function highlighted_cell ()
    {
        return $this->hasMany(HighlightedCell::class, 'user_id', 'id');
    }

    public function highlighted_cell_identifiers ()
    {
        return $this->hasMany(HighlightedCell::class, 'user_id', 'id')->pluck('identifier')->toArray();
    }

    public function highlighted_cell_colors ()
    {
        return $this->hasMany(HighlightedCell::class, 'user_id', 'id')->pluck('color')->toArray();
    }
}
