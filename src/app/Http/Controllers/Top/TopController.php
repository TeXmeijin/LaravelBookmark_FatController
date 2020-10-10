<?php

namespace App\Http\Controllers\Top;

use App\Http\Controllers\Controller;

class TopController extends Controller
{
    public function __invoke()
    {
        return view('page.top.index');
    }
}