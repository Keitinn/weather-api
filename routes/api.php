<?php

use Illuminate\Http\Request;
use App\Http\Controllers as Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Forecast API (自動的に /api プレフィックスが付く)
Route::get('/forecast', [Controllers\ForecastController::class, 'index_query']);
Route::get('/forecast/city/{city_id}', [Controllers\ForecastController::class, 'index']);
