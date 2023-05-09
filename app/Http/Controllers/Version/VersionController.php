<?php

namespace App\Http\Controllers\Version;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class VersionController extends Controller
{
    public function releaseNotes(): View
    {
        return view('version.release_notes');
    }
}
