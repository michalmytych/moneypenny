<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FileController extends Controller
{
    public function index(): View
    {
        $files = File::latest()->get();
        return view('file.index', compact('files'));
    }

    public function show($id): View
    {
        $file = File::findOrFail($id);

        return view('file.show', [
            'file' => $file,
        ]);
    }

    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file');

        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $uuid      = Str::uuid();

        $fileName = "upload_{$uuid}_{$timestamp}.{$extension}";

        $fileModel = new File();

        $fileModel->name = $file->getClientOriginalName();
        $fileModel->path = "private/{$fileName}";
        $fileModel->size = $file->getSize();

        DB::transaction(function () use ($fileModel, $file, $fileName) {
            $fileModel->save();
            $file->storeAs('private', $fileName);
        });

        return redirect()->route('file.index');
    }
}
