<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/run-migrate', [ItemController::class, 'index']);


Route::get('/', function () {
    return view('welcome');
});
