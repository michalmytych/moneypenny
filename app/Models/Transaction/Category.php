<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * @property string $code
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'code'
    ];

    public function name(): string
    {
        return Str::of($this->code)
            ->replace('_', ' ')
            ->ucfirst()
            ->toString();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
