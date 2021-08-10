<?php

use App\Models\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('it gets the total visit count', function () {
    $series = Series::factory()->create();

    $series->visit();

    $series = Series::withTotalVisitCount()->first();

    expect($series->visit_count_total)->toEqual(1);
});
