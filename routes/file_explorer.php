<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::prefix('file-explorer')->as('file_explorer.')->group(function () {
    Route::get('/', function() {
        return view('file_explorer.index');
    })->name('index');

    Route::get('/open', function(Request $request) {
        $targetPath = $request->get('path');
        $targetPath = str_replace($targetPath, '/', storage_path());
        $render = '';
        $data = [
            'directories' => [],
            'files' => [],
        ];

        foreach (Storage::directories($targetPath) as $path) {
            $data['directories'][] = $path;
        }
        foreach (Storage::files($targetPath) as $path) {
            $data['files'][] = $path;
        }

        foreach ($data['directories'] as $directory) {
            $render .= view('file_explorer.partials.folder', [

                'url' => route('file_explorer.open', ['path' => $request->get('path') . '/' . $directory]),
                'directoryName' => $directory,

            ])->render();
        }

        foreach ($data['files'] as $file) {
            $render .= view('file_explorer.partials.file', ['file' => $file])->render();
        }

        if ($render === '') {
            $render .= view('file_explorer.partials.empty-folder')->render();
        }

        return response()->json([
            'render' => $render
        ]);

    })->name('open');
});
