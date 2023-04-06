<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FileController extends Controller
{
    public function index(): View
    {
        $files = File::latest()->get();
        return view('file.index', compact('files'));
    }

    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required'
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads');

        $fileModel = new File();
        $fileModel->name = $file->getClientOriginalName();
        $fileModel->path = $path;
        $fileModel->size = $file->getSize();
        $fileModel->save();

        return redirect()->route('file.index');
    }
}
