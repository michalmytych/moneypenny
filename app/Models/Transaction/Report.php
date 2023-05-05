<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 */
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(ReportField::class);
    }
}
