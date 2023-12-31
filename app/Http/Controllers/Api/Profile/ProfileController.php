<?php

namespace App\Http\Controllers\Api\Profile;

use App\File\Services\ProfileFileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileFileService $profileFileService) {}

    public function selectLibraryAvatar(Request $request): JsonResponse
    {
        $user = $request->user();
        $serverPath = $request->input('server_path');
        $result = $this->profileFileService->selectLibraryAvatar($serverPath, $user->id);

        return response()->json($result);
    }
}
