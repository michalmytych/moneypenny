<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\ExchangeRates\DataObjects;

abstract class DataObject
{
    // Decided to duplicate DataObject definition
    // because it may be useful when copying integration
    // to another project
    abstract public static function make(mixed $data): self;
}
