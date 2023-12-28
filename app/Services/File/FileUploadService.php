<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

readonly class FileUploadService
{
    public function __construct(
        private ProfileFileService $profileFileService,
        private TransactionFileService $transactionFileService
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function upload(User $user, UploadedFile $file, array $data): void
    {
        $fileType = $data['type'];

        if ($fileType && $fileType === File::USER_AVATAR) {
            $this->profileFileService->uploadAvatar($file, $user->id);

            return;
        }

        try {
            $this->transactionFileService->uploadTransactions(
                $file,
                $data['import_setting_id'],
                $data['columns_mapping_id'],
                $user
            );

        } catch(\Throwable) {
            throw ValidationException::withMessages(
                [
                'file' => 'Invalid file, please check import configuration.'
                ]
            );
        }
    }
}
