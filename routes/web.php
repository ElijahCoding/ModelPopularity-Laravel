<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/series', \App\Http\Controllers\SeriesIndexController::class);
Route::get('/series/{series:slug}', \App\Http\Controllers\SeriesShowController::class);
