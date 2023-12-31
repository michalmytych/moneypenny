<?php

namespace App\Shared\DataObjects;

abstract class DataObject
{
    abstract public static function make(mixed $data): self;
}
