<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
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
| Product Management
|--------------------------------------------------------------------------
*/

Route::get(
    '/products',
    [ProductController::class, 'index']
)->name('products.index');

Route::get(
    '/products/export-csv',
    [ProductController::class, 'exportCsv']
)->name('products.export.csv');

Route::post(
    '/products/bulk-action',
    [ProductController::class, 'bulkAction']
)->name('products.bulk-action');

Route::delete(
    '/products/{product}',
    [ProductController::class, 'destroy']
)->name('products.destroy');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});
