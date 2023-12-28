<?php

namespace App\Http\Controllers\Web\FileExplorer;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class FileExplorerController extends Controller
{
    public function index(): View
    {
        return view('file_explorer.index');
    }
}
