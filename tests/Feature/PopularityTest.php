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

it('it gets records by all time popularity', function () {
    Series::factory()->times(2)->create()->each->visit();

    $series = Series::popularAllTime()->get();

    expect($series->count())->toBe(2);
    expect($series->first()->visit_count_total)->toBe(1);
});
