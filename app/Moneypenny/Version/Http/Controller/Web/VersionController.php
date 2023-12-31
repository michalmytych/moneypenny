<?php

namespace App\Moneypenny\Version\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
use Illuminate\View\View;

class VersionController extends Controller
{
    public function releaseNotes(): View
    {
        return view('version.release_notes');
    }
}
