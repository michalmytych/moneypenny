<?php

/**
 * @deprecated
 */

return [
    'use_auto_discovery' => true,
    'namespace'          => "App\\Services\\Analysis\\Analyzers\\",
    'path'               => 'Services/Analysis/Analyzers',
    'enabled'            => [
        \App\Services\Analytics\Analyzers\TransactionVolumeSumPerDay::class,
        \App\Services\Analytics\Analyzers\TransactionCountPerDay::class,
        \App\Services\Analytics\Analyzers\TotalTransactionVolumePerWeekDay::class,
        \App\Services\Analytics\Analyzers\TotalTransactionsVolume::class,
    ],
];
