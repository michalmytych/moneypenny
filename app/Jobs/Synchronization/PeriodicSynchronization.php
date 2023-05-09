<?php

namespace App\Jobs\Synchronization;

use App\Events\ApplicationNotificationSent;
use App\Models\Import\Import;
use App\Models\Nordigen\EndUserAgreement;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Synchronization\Synchronization;
use Illuminate\Support\Facades\Http;

class PeriodicSynchronization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $lastSuccesfullSync = Synchronization::query()
            ->where('status', Synchronization::SYNC_STATUS_SUCCEEDED)
            ->latest()
            ->get()
            ->first();

        /** @var Carbon $c */
        $c = $lastSuccesfullSync->created_at;

        if (now()->diffInHours($c) > 4) {
            // @todo refactor
            $agreement = EndUserAgreement::latest()->limit(1)->get()->first();
            Http::get(route('api.sync', ['agreement_id' => $agreement->id]));
            $import = Import::latest()->withCount('addedTransactions')->limit(1)->get()->first();

            $header = 'Nowa automatyczna synchronizacja';
            $content = "$import->added_transactions_count nowych transakcji";
            $url = \route('transaction.index');

            \App\Models\Notification::create([
                'content' => json_encode([
                    'header' => $header,
                    'content' => $content,
                    'url' => $url,
                ]),
                'type'
            ]);

            broadcast(
                new ApplicationNotificationSent($header, $content, $url)
            );
        }
    }
}
