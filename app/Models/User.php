<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}
