<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::prefix('file-explorer')->as('file_explorer.')->group(function () {
    Route::get('/', function () {
        return view('file_explorer.index');
    })->name('index');

    Route::get('/open', function (Request $request) {
        $targetPath = $request->get('path');

        if ($targetPath === storage_path()) {
            $targetPath = '/';
        } else {
            $targetPath = str_replace(storage_path(), '', $targetPath);
        }

        $render = '';

        $data = [
            'directories' => [],
            'files' => [],
        ];

        foreach (Storage::directories($targetPath) as $path) {
            $pathItems = explode('/', $path);
            $dirName = end($pathItems);
            $data['directories'][] = str_replace('/', '', $dirName);
        }
        foreach (Storage::files($targetPath) as $path) {
            $pathItems = explode('/', $path);
            $fileName = end($pathItems);
            $data['files'][] = str_replace('/', '', $fileName);
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
            'requested_path' => $request->get('path'),
            'render' => $render
        ]);

    })->name('open');
});
