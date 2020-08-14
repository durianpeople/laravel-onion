<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

foreach (scandir($path = app_path('Modules')) as $dir) {
    if (file_exists($filepath = "{$path}/{$dir}/Presentation/routes/api.php")) {
        require $filepath;
    }
}
