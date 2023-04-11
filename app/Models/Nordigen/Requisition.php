<?php

namespace App\Models\Nordigen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static latest()
 */
class Requisition extends Model
{
    use HasFactory;

    protected $table = 'nordigen_requisitions';

    protected $fillable = [
        'link',
        'reference',
        'raw_request_body',
        'raw_response_body',
        'end_user_agreement_id',
        'nordigen_institution_id',
        'nordigen_requisition_id',
    ];
}
