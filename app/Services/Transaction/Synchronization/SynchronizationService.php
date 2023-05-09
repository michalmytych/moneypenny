<?php

namespace App\Services\Transaction\Synchronization;

use Illuminate\Support\Collection;
use App\Models\Synchronization\Synchronization;

class SynchronizationService
{
    public function all(): Collection
    {
        return Synchronization::latest()->get();
    }
}
