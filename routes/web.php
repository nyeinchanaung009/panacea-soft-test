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
    Route::get('item/{item}/edit',[ItemController::class,'edit'])->name('item.edit');
    Route::post('item/{item}',[ItemController::class,'update'])->name('item.update');

    // delete and put method is in error and still figuring out . so,curretly use post methods
    Route::post('/item/delete/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    Route::post('/item/make-publish/{id}', [ItemController::class, 'makePublish'])->name('item.makePublish');
});
