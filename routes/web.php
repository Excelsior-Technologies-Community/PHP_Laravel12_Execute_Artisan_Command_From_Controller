<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/run-migrate', [ItemController::class, 'index'])->name('command.form');
Route::match(['GET', 'POST'], '/run-command', [ItemController::class, 'run'])->name('command.run');

Route::get('/', function () {
    return view('welcome');
});
