<?php

namespace App\Nordigen\DataObjects;

class InstitutionDataObject extends DataObject
{
    public function __construct(
        public string $id,
        public string $name,
        public string $bic,
        public string $transaction_total_days,
        public array  $countries,
        public string $logo,
    ) {
    }

    public static function make(mixed $data): InstitutionDataObject
    {
        return new self(
            id: data_get($data, 'id'),
            name: data_get($data, 'name'),
            bic: data_get($data, 'bic'),
            transaction_total_days: data_get($data, 'transaction_total_days'),
            countries: data_get($data, 'countries'),
            logo: data_get($data, 'logo'),
        );
    }
}
