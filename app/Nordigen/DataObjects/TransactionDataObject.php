<?php

namespace App\Nordigen\DataObjects;

class TransactionDataObject extends DataObject
{
    public function __construct(
        public string $rawVolume,
        public string $currency,
        public string $valueDate,
        public ?string $bookingDate,
        public ?string $debtorName,
        public ?string $remittanceInformationUnstructured,
    ) {}

    public static function make(mixed $data): TransactionDataObject
    {
        return new self(
            rawVolume: data_get($data, 'transactionAmount.amount'),
            currency: data_get($data, 'transactionAmount.currency'),
            valueDate: data_get($data, 'valueDate'),
            bookingDate: data_get($data, 'bookingDate'),
            debtorName: data_get($data, 'debtorName'),
            remittanceInformationUnstructured: data_get($data, 'remittanceInformationUnstructured'),
        );
    }
}
