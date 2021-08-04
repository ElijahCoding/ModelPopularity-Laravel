<?php

namespace App\Http\Controllers;

use App\Models\Series;

class SeriesShowController extends Controller
{
    public function __invoke(Series $series)
    {
        $series->visit()->withIp()->withUser()->withData(['cats' => true]);

        return view('series.show', [
            'series' => $series,
        ]);
    }
}
