<?php

namespace App\Moneypenny\Category\Models;

use App\Moneypenny\Transaction\Models\Transaction;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property string $code
 * @method static firstOrCreate(string[] $categoryData)
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'code'
    ];

    protected $appends = [
        'name'
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::of($this->code)
                ->replace('_', ' ')
                ->ucfirst()
                ->toString()
        );
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
