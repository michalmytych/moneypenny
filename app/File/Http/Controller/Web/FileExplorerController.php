<?php

namespace App\File\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
use Illuminate\View\View;

class FileExplorerController extends Controller
{
    public function index(): View
    {
        return view('file_explorer.index');
    }
}
