
<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('welcome', function() {
        return view('welcome');
    })->name('create');
});
