<?php

use App\Http\Controllers\ItemController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return Inertia::render('Dashboard', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [ItemController::class,'index'])->name('dashboard');
    Route::get('/item/create',[ItemController::class,'create'])->name('item.create');
    Route::post('/item/store',[ItemController::class,'store'])->name('item.store');

    Route::delete('/item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    Route::post('/item/make-publish', [ItemController::class, 'makePublish'])->name('item.makePublish');
});
