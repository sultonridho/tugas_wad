<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;

Route::get('/', [DriverController::class, 'index'])
    ->name('drivers.index');

Route::resource('drivers', DriverController::class)
    ->except(['index']);
