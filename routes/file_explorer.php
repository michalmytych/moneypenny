<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

function isBinary($str) {
    return preg_match('~[^\x20-\x7E\t\r\n]~', $str) > 0;
}

function isImage($name) {
    $pathItems = explode('.', $name);
    $extension = end($pathItems); // @todo what if no extension
    $imageExtensions = ['jpg','jpeg','png','gif','bmp','webp','ico','svg','tif','tiff'];
    return in_array($extension, $imageExtensions);
}

function isVideo($name) {
    $pathItems = explode('.', $name);
    $extension = end($pathItems); // @todo what if no extension
    $imageExtensions = ['mp4','webm','ogg'];
    return in_array($extension, $imageExtensions);
}

Route::prefix('file-explorer')->as('file_explorer.')->group(function () {
    Route::get('/', function () {
        return view('file_explorer.index');
    })->name('index');

    Route::get('/get', function (Request $request) {
        $fileStoragePath = $request->get('path');
//        return response()->json([
//            'exists' => Storage::exists($fileStoragePath)
//        ]);
        return Storage::download($fileStoragePath);
    })->name('get');

    Route::get('/show', function (Request $request) {
        $storageFilePath = $request->get('path');
        $fileExists = Storage::exists($storageFilePath);
        $fileType = null;
        $fileRender = null;
        if ($fileExists) {
            $pathItems = explode('/', $storageFilePath);
            $fileName = end($pathItems);
            $fileType = 'text';
            $fileContent = Storage::get($storageFilePath);
            if (isBinary($fileContent)) {
                if (isImage($fileName)) {
                    $fileType = 'image';
                    $fileRender = view('file_explorer.partials.image-file', [
                        'fileName' => $fileName,
                        'src' => route('file_explorer.get', ['path' => $storageFilePath])
                    ])->render();

                } elseif(isVideo($fileName)) {
                    $fileType = 'video';
                    $pathItems = explode('.', $fileName);
                    $extension = end($pathItems); // @todo what if no extension
                    $fileRender = view('file_explorer.partials.video-file', [
                        'fileName' => $fileName,
                        'fileExtension' => $extension,
                        'src' => route('file_explorer.get', ['path' => $storageFilePath])
                    ])->render();
                }

                else {
                    $fileType = 'binary';
                    $fileRender = view('file_explorer.partials.binary-file', [
                        'fileName' => $fileName
                    ])->render();
                }
            } else {
                $fileRender = view('file_explorer.partials.text-file', [
                    'fileName' => $fileName,
                    'content' => $fileContent
                ])->render();
            }
        }
        return response()->json([
            'exists' => $fileExists,
            'file_type' => $fileType,
            'render' => $fileRender
        ]);
    })->name('show');

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
            $render .= view('file_explorer.partials.file', [
                'file' => $file,
                'filePath' => $targetPath . '/' . $file
            ])->render();
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
