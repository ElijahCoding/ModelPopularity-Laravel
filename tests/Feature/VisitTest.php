<?php

use App\Models\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('it creates a visit', function () {
    $series = Series::factory()->create();

    $series->visit();

    expect($series->visits->count())->toBe(1);
});

it('it creates a visit with the default ip address', function () {
    $series = Series::factory()->create();

    $series->visit()->withIp();

    expect($series->visits->first()->data)->toMatchArray([
        'ip' => request()->ip(),
    ]);
});

it('it creates a visit with the given ip address', function () {
    $series = Series::factory()->create();

    $series->visit()->withIp('localhost');

    expect($series->visits->first()->data)->toMatchArray([
        'ip' => 'localhost',
    ]);
});
