<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->post('/welcome', function () {
    return json_encode([
        'success' => true
    ]);
});
