<?php

use App\Modules\Welcome\Presentation\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', [IndexController::class, 'index']);
