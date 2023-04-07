<?php

return [
    'enabled' => [
        \App\Services\Analysis\Analyzers\TransactionVolumeSumPerDay::class,
        \App\Services\Analysis\Analyzers\TransactionCountPerDay::class,
        \App\Services\Analysis\Analyzers\TotalTransactionVolumePerWeekDay::class,
        \App\Services\Analysis\Analyzers\TotalTransactionsVolume::class
    ],
];
