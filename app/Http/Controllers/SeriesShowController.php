<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesShowController extends Controller
{
    public function __invoke(Series $series)
    {
        return view('series.show', [
            'series' => $series,
        ]);
    }
}
