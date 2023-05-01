<?php

namespace App\Services\Transaction\Report;

use App\Models\Transaction\ReportField;
use Illuminate\Support\Facades\DB;

class ReportBuilder
{
    protected array $fieldsAdded = [];

    public function addField(string $name, int $value): self
    {
        $this->fieldsAdded[] = [
            'name' => $name,
            'value' => $value,
        ];

        return $this;
    }

    public function build(): void
    {
        DB::transaction(function() {
            ReportField::createMany($this->fieldsAdded);
        });
    }
}
