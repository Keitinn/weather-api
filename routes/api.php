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

// デバッグエンドポイント
Route::get('/debug', function () {
    return response()->json([
        'status' => 'API is working',
        'timestamp' => now()->toISOString(),
        'server_info' => [
            'REQUEST_URI' => request()->server('REQUEST_URI'),
            'PATH_INFO' => request()->server('PATH_INFO'),
            'SCRIPT_NAME' => request()->server('SCRIPT_NAME'),
            'HTTP_HOST' => request()->server('HTTP_HOST'),
        ],
        'request_info' => [
            'url' => request()->url(),
            'full_url' => request()->fullUrl(),
            'path' => request()->path(),
            'method' => request()->method(),
        ]
    ], 200, [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
});
