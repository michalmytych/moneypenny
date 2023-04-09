<?php

namespace App\Models\Nordigen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @var bool $is_successful
 * @method static create(array $array)
 * @method static firstWhere(string $attribute, mixed $value)
 */
class EndUserAgreement extends Model
{
    use HasFactory;

    protected $table = 'nordigen_end_user_agreements';

    protected $fillable = [
        'is_successful',
        'raw_request_body',
        'raw_response_body',
        'nordigen_institution_id',
        'nordigen_end_user_agreement_id',
        'nordigen_end_user_agreement_created',
    ];
}
