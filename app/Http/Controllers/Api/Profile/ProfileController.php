<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\File\ProfileFileService;

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
