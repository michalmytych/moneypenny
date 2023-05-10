<?php

namespace App\Services\Transaction\Transformers;

abstract class Transformer
{
    abstract static public function transform(mixed $data);
}
