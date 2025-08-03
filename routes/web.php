<?php

use App\Livewire\ExpiryTagGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('expiry-tag-generator');
})->name('home');

Route::middleware(['guest'])
    ->group(function () {
        Route::get('/generate', ExpiryTagGenerator::class)->name('expiry-tag-generator');
    });