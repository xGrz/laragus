<?php

use Illuminate\Support\Facades\Route;
use xGrz\LaraGus\Http\Controllers\SearchGusDataController;


if (config('laragus.expose_api_route', true)) {

    Route::middleware(config('laragus.middleware', []))
        ->get(
            config('laragus.api_uri', 'ajax/gus'),
            SearchGusDataController::class
        )
        ->name(config('laragus.api_route_name', 'ajax.gus'));

}
