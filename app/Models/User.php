<?php

namespace App\Models;

use App\Models\Auth\Settings;
use App\Models\Traits\HasAvatar;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Transaction\Budget;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaction\PersonalAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use IvanoMatteo\LaravelDeviceTracking\Traits\UseDevices;

/**
 * @property mixed $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property null|boolean $is_admin
 * @property null|boolean $is_blocked
 * @property Settings|null $settings
 * @property Collection $personalAccounts
 * @property Collection $budgets
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
        'is_admin',
        'password',
        'remember_token',
    ];

    protected array $protected = [
        'is_admin',
        'is_blocked'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personalAccounts(): HasMany
    {
        return $this->hasMany(PersonalAccount::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function isBlocked(): bool
    {
        return (bool) $this->is_blocked;
    }

    public function settings(): HasOne
    {
        return $this->hasOne(Settings::class);
    }
}
