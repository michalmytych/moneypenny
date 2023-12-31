<?php

namespace App\Nordigen\Models;

use App\Moneypenny\User\Models\User;
use App\Shared\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $nordigen_institution_id
 * @var bool $is_successful
 * @var Collection $requisitions
 * @method static create(array $array)
 * @method static firstWhere(string|array $attribute, mixed $value = null)
 * @method static findOrFail(mixed $endUserAgreementId)
 * @method static latest()
 * @method static whereUser(User $user)
 */
class EndUserAgreement extends Model
{
    use HasFactory, BelongsToUser;

    protected $table = 'nordigen_end_user_agreements';

    protected $fillable = [
        'user_id',
        'is_successful',
        'raw_request_body',
        'raw_response_body',
        'nordigen_institution_id',
        'nordigen_end_user_agreement_id',
        'nordigen_end_user_agreement_created',
    ];

    public function getInstitutionId(): ?string
    {
        return $this->nordigen_institution_id;
    }

    public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class, 'end_user_agreement_id');
    }
}

