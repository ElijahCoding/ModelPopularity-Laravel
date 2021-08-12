<?php

namespace App\Http\Controllers;

use App\Models\Series;


class SeriesIndexController extends Controller
{
    public function __invoke()
    {
        return view('series.index', [
            'popular' => Series::query()->withTotalVisitCount()->popularLastDays->get(),
        ]);
    }
}
