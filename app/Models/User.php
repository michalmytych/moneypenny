<?php

namespace App\Models;

use App\Models\Traits\HasAvatar;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use IvanoMatteo\LaravelDeviceTracking\Traits\UseDevices;

/**
 * @property mixed $id
 * @method static cursor()
 * @method static firstWhere(array $array)
 * @method static findOrFail(mixed $userId)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UseDevices, HasAvatar;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
