<?php

namespace App\Services\Import;

use App\Models\File;
use App\Models\User;
use App\Models\Import\Import;
use Illuminate\Support\Facades\DB;
use App\Imports\TransactionsImport;
use App\Models\Import\ImportSetting;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Import\ColumnsMapping;
use App\Contracts\Services\Import\ImportServiceContract;
use App\Services\Notification\Broadcast\NotificationBroadcastService;

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
