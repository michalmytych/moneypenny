<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 */
class ReportField extends Model
{
    use HasFactory;

    public const TYPE_STRING = 0;

    public const TYPE_NUMERIC = 1;

    public const TYPE_OBJECT = 2;

    protected $fillable = [
        'name',
        'type',
        'value',
        'report_id',
        'parent_report_field_id'
    ];

    public function children(): HasMany
    {
        return $this->hasMany(ReportField::class, 'parent_report_field_id', 'id');
    }
}
