<?php

namespace App\Modules\Welcome\Presentation\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('Welcome::index.index');
    }
}
