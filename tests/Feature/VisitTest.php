<?php

use App\Models\User;
use App\Models\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

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

it('it creates a visit with custom data', function () {
    $series = Series::factory()->create();

    $series->visit()->withData([
        'cats' => true
    ]);

    expect($series->visits->first()->data)->toMatchArray([
        'cats' => true,
    ]);
});

it('it creates a visit with the default user', function () {
    $this->actingAs($user = User::factory()->create());

    $series = Series::factory()->create();

    $series->visit()->withUser();

    expect($series->visits->first()->data)->toMatchArray([
        'user_id' => $user->id,
    ]);
});

it('it creates a visit with the given user', function () {
    $user = User::factory()->create();

    $series = Series::factory()->create();

    $series->visit()->withUser($user);

    expect($series->visits->first()->data)->toMatchArray([
        'user_id' => $user->id,
    ]);
});

it('it does not create duplicate visits with the same data', function () {
    $series = Series::factory()->create();

    $series->visit()->withData([
        'cats' => true
    ]);

    $series->visit()->withData([
        'cats' => true
    ]);

    expect($series->visits->count())->toBe(1);
});

it('it does not create visits within the timeframe', function () {
    $series = Series::factory()->create();

    Carbon::setTestNow(now()->subDays(2));
    $series->visit();

    Carbon::setTestNow();
    $series->visit();
    $series->visit();

    expect($series->visits->count())->toBe(2);
});

it('it creates visits after a daily timeframe', function () {
    $series = Series::factory()->create();

    $series->visit()->withIp();
    Carbon::setTestNow(now()->addDay()->addHour());
    $series->visit()->withIp();

    expect($series->visits->count())->toBe(2);
});

it('it creates visits after a hourly timeframe', function () {
    $series = Series::factory()->create();

    $series->visit()->hourlyInterval()->withIp();
    Carbon::setTestNow(now()->addHour()->addMinute());
    $series->visit()->hourlyInterval()->withIp();

    expect($series->visits->count())->toBe(2);
});

it('it creates visits after a default daily timeframe', function () {
    $series = Series::factory()->create();

    $series->visit()->dailyInterval()->withIp();
    Carbon::setTestNow(now()->addDay()->addMinute());
    $series->visit()->dailyInterval()->withIp();

    expect($series->visits->count())->toBe(2);
});

it('it creates visits after a default weekly timeframe', function () {
    $series = Series::factory()->create();

    $series->visit()->weeklyInterval()->withIp();
    Carbon::setTestNow(now()->addWeek()->addMinute());
    $series->visit()->weeklyInterval()->withIp();

    expect($series->visits->count())->toBe(2);
});

it('it creates visits after a default monthly timeframe', function () {
    $series = Series::factory()->create();

    $series->visit()->monthlyInterval()->withIp();
    Carbon::setTestNow(now()->addMonth()->addMinute());
    $series->visit()->monthlyInterval()->withIp();

    expect($series->visits->count())->toBe(2);
});

it('it creates visits after a custom timeframe', function () {
    $series = Series::factory()->create();

    $series->visit()->customInterval(now()->subYear())->withIp();
    Carbon::setTestNow(now()->addYear()->addMinute());
    $series->visit()->customInterval(now()->subYear())->withIp();

    expect($series->visits->count())->toBe(2);
});
