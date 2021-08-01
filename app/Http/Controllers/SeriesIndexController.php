<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriesIndexController extends Controller
{
    public function __invoke()
    {
        return view('series.index');
    }
}
