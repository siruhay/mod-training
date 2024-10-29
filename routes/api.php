<?php

use Illuminate\Support\Facades\Route;
use Module\Training\Http\Controllers\DashboardController;


Route::get('dashboard', [DashboardController::class, 'index']);