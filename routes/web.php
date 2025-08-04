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

Route::get('/view', function () {
    return view('exports.pdf', [
        'title' => 'Sample Title',
        'address' => '123 Sample Address',
        'mfg_date' => now()->format('m-d-y'), // Changed format
        'exp_date' => now()->addDays(7)->format('m-d-y'),
    ]);
})->name('view.expiry-tag-generator');
