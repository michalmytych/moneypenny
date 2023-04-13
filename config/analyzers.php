<?php

return [
    'use_auto_discovery' => true,
    'namespace'          => "App\\Interfaces\\Analysis\\Analyzers\\",
    'path'               => 'Interfaces/Analysis/Analyzers',
    'enabled'            => [
        \App\Services\Analysis\Analyzers\TransactionVolumeSumPerDay::class,
        \App\Services\Analysis\Analyzers\TransactionCountPerDay::class,
        \App\Services\Analysis\Analyzers\TotalTransactionVolumePerWeekDay::class,
        \App\Services\Analysis\Analyzers\TotalTransactionsVolume::class,
    ],
];
