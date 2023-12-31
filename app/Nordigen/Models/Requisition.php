<?php

namespace App\Nordigen\Models;

use App\Shared\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static latest()
 * @method static whereUser($user)
 * @property mixed $nordigen_requisition_id
 * @property mixed $id
 */
class Requisition extends Model
{
    use HasFactory, BelongsToUser;

    protected $table = 'nordigen_requisitions';

    protected $fillable = [
        'link',
        'user_id',
        'reference',
        'raw_request_body',
        'raw_response_body',
        'end_user_agreement_id',
        'nordigen_institution_id',
        'nordigen_requisition_id',
    ];
}
