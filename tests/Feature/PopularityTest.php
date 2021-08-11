<?php

use App\Models\Series;
use Carbon\Carbon;
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
    $popularSeries = Series::factory()->create();

    Carbon::setTestNow(now()->subDays(2));
    $popularSeries->visit();
    Carbon::setTestNow();
    $popularSeries->visit();

    $series = Series::query()->latest()->popularAllTime()->get();

    expect($series->count())->toBe(3);
    expect($series->first()->visit_count_total)->toEqual(2);
});

it('it gets popular records between two dates', function () {
    $series = Series::factory()->times(2)->create();
    
    Carbon::setTestNow(Carbon::createFromDate(2021, 8, 1));
});
