<?php

use App\Modules\Shared\Mechanism\ModuleTranslator;
use Illuminate\Support\Facades\Route;

Route::post(
    '/welcome',
    function (ModuleTranslator $translator) {
        return response()->json(
            [
                'success' => true,
                'data' => $translator->get('Welcome::default.welcome')
            ]
        );
    }
);
