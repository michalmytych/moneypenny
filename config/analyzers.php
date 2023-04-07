<?php

return [
    'use_auto_discovery' => true,
    'namespace'          => "App\\Services\\Analysis\\Analyzers\\",
    'path'               => 'Services/Analysis/Analyzers',
    'enabled'            => [
        \App\Services\Analysis\Analyzers\TransactionVolumeSumPerDay::class,
        \App\Services\Analysis\Analyzers\TransactionCountPerDay::class,
        \App\Services\Analysis\Analyzers\TotalTransactionVolumePerWeekDay::class,
        \App\Services\Analysis\Analyzers\TotalTransactionsVolume::class,
    ],
];
