<?php

namespace App\Services\Nordigen\DataObjects;

use App\DataObjects\DataObject;

class TransactionDataObject extends DataObject
{
    public function __construct(
        /** @var string $rawVolume Operation raw volume */
        public string  $rawVolume,

        /** @var string $currency Operation currency code */
        public string  $currency,

        /** @var string $valueDate Operation execution date */
        public string  $valueDate,

        /** @var string|null $bookingDate Operation booking date */
        public ?string $bookingDate,

        /** @var string|null $debtorName Operation sender name */
        public ?string $debtorName,

        /** @var string|null $creditorName Operation receiver name */
        public ?string $creditorName,

        /** @var string|null $remittanceInformationUnstructured Operation details/description */
        public ?string $remittanceInformationUnstructured,

        /** @var string|null $senderAccountNumber Sender IBAN Number */
        public ?string $senderAccountNumber,

        /** @var string|null $receiverAccountNumber Receiver IBAN Number */
        public ?string $receiverAccountNumber,

        /** @var int $personalAccountId Personal account id. */
        public ?int $personalAccountId // @todo: SHOULD NOT BE NULLABLE
    )
    {
    }

    public static function make(mixed $data): self
    {
        return new self(
            rawVolume: data_get($data, 'transactionAmount.amount'),
            currency: data_get($data, 'transactionAmount.currency'),
            valueDate: data_get($data, 'valueDate'),
            bookingDate: data_get($data, 'bookingDate'),
            debtorName: data_get($data, 'debtorName'),
            creditorName: data_get($data, 'creditorName'),
            remittanceInformationUnstructured: data_get($data, 'remittanceInformationUnstructured'),
            senderAccountNumber: data_get($data, 'debtorAccount.iban'),
            receiverAccountNumber: data_get($data, 'creditorAccount.iban'),
            personalAccountId: data_get($data, 'personalAccountId'),
        );
    }
}
