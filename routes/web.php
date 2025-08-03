<?php

use App\Livewire\ExpiryTagGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/', ExpiryTagGenerator::class)->name('expiry-tag-generator');

Route::get('/view', function () {
    return view('exports.pdf', [
        'title' => 'Sample Title',
        'address' => '123 Sample Address',
        'mfg_date' => now()->toDateString(),
        'exp_date' => now()->addDays(30)->toDateString(),
        'quantity' => 10,
    ]);
})->name('view.expiry-tag-generator');
