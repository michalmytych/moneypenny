<?php

namespace Tests\Feature\Web\File;

use Tests\TestCase;
use App\Models\User;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{
    /**
     * @dataProvider provideValidAvatarData
     */
    public function test_avatar_upload(int $expectedStatus, array $input): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('file.upload'), $input)
            ->assertStatus($expectedStatus);

        $fileRelativePath = 'avatars/' . $user->id . '_avatar.jpg';

        Storage::disk('public')->assertExists($fileRelativePath);
        Storage::disk('public')->delete($fileRelativePath);
    }

    /**
     * @dataProvider provideInvalidAvatarData
     */
    public function test_avatar_upload_validation(int $expectedStatus, array $input): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->postJson(route('file.upload'), $input)
            ->assertStatus($expectedStatus);
    }

    /**
     * @dataProvider provideInvalidAvatarData
     */
    public static function provideValidAvatarData(): array
    {
        return [
            [
                302,
                [
                    'file' => UploadedFile::fake()->image('avatar.jpg'),
                    'type' => File::USER_AVATAR
                ],
            ]
        ];
    }

    public static function provideInvalidAvatarData(): array
    {
        return [
            [
                422,
                [
                    'file' => UploadedFile::fake()->image('avatar.jpg')->size(1_000_000_000),
                    'type' => File::USER_AVATAR
                ],
            ],
            [
                422,
                [
                    'file' => null,
                    'type' => File::USER_AVATAR
                ],
            ],
            [
                422,
                [
                    'file' => UploadedFile::fake()->image('avatar.jpg')->size(1_000_000_000),
                    'type' => null
                ],
            ],
            [
                422,
                [
                    'file' => null,
                    'type' => null
                ],
            ]
        ];
    }
}
