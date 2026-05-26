<?php

use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Livewire\Doctors\EditDoctor;

Route::middleware(['auth'])->group(function () {
    Route::get('/doctors/{doctor}/edit', EditDoctor::class)->name('doctors.edit');
});

Route::redirect('/', '/admin');
// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('admin')
        ->name('admin.')
        ->group(base_path('routes/admin.php'));

});
