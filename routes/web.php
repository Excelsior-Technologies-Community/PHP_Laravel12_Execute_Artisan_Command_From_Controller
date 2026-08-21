<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Artisan Command Runner
|--------------------------------------------------------------------------
*/

Route::get(
    '/run-migrate',
    [ItemController::class, 'index']
)->name('command.form');

Route::match(
    ['GET', 'POST'],
    '/run-command',
    [ItemController::class, 'run']
)->name('command.run');

/*
|--------------------------------------------------------------------------
| Artisan Command History
|--------------------------------------------------------------------------
*/

Route::get(
    '/command-history',
    [ItemController::class, 'history']
)->name('command.history');

Route::delete(
    '/command-history/{history}',
    [ItemController::class, 'deleteHistory']
)->name('command.history.delete');

Route::delete(
    '/command-history',
    [ItemController::class, 'clearHistory']
)->name('command.history.clear');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});