<?php

use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware([Authenticate::class])->group(function () {
    Route::get('/', function () {
        return redirect('/login'); // Langsung arahkan ke Filament
    });
});
