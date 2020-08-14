<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

foreach (scandir($path = app_path('Modules')) as $dir) {
    if (file_exists($filepath = "{$path}/{$dir}/Presentation/routes/web.php")) {
        require $filepath;
    }
}
