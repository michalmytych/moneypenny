<?php

namespace App\Services\Transaction\Report\Defaults;

use App\Models\User;

abstract class ReportTemplate
{
    protected array $params = [];

    public function setParams(array $params): static
    {
        $this->params = $params;
        return $this;
    }

    abstract public function getReportData(User $user): array;
}
