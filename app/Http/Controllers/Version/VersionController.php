<?php

namespace App\Http\Controllers\Version;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class VersionController extends Controller
{
    public function releaseNotes(): View
    {
        return view('version.release_notes');
    }
}
