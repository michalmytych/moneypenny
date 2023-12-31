<?php

namespace App\Moneypenny\Import\Services;

use App\File\Models\File;
use App\Moneypenny\Import\Contracts\ImportServiceContract;
use App\Moneypenny\Import\Imports\TransactionsImport;
use App\Moneypenny\Import\Models\ColumnsMapping;
use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\Import\Models\ImportSetting;
use App\Moneypenny\User\Models\User;
use App\Notification\Services\NotificationBroadcastService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportService implements ImportServiceContract
{
    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService)
    {
    }

    public function all(User $user)
    {
        return Import::whereUser($user)
            ->with('file', 'synchronization')
            ->withCount('addedTransactions')
            ->latest()
            ->get();
    }

    public function importFromFile(int $fileId, int $importSettingId, int $columnsMappingId, User $user): void
    {
        $importSetting = ImportSetting::findOrFail($importSettingId);
        $columnsMapping = ColumnsMapping::findOrFail($columnsMappingId);
        $file = File::findOrFail($fileId);

        $import = new Import([
            'user_id' => $user->id,
            'file_id' => $file->id,
            'status' => Import::STATUS_PROCESSING,
            'import_setting_id' => $importSettingId,
            'columns_mapping_id' => $columnsMappingId,
        ]);

        $import->save();

        DB::transaction(function () use ($file, $importSetting, $columnsMapping, $import, $user) {
            Excel::queueImport(
                new TransactionsImport($importSetting, $columnsMapping, $import, $user),
                $file->path
            );
        });

        $import->update(['status' => Import::STATUS_SAVED]);

        $this->notificationBroadcastService->sendStoredApplicationNotification(
            header: 'New transactions import! ',
            content: 'See more',
            url: route('transaction.index'),
            userId: $user->id
        );
    }

    public function columnConfigurationForUserExist(User $user): bool
    {
        return ColumnsMapping::whereUser($user)->count() === 0
            || ImportSetting::whereUser(request()->user())->count() === 1;
    }

    public function create(User $user, array $data): Import
    {
        $data['user_id'] = $user->id;
        return Import::create($data);
    }
}
