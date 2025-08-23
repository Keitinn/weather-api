<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        
        // Vercel環境では手動でルートを登録
        if (app()->environment('production')) {
            $this->mapVercelRoutes();
        } else {
            $this->routes(function () {
                Route::prefix('apis')
                    ->middleware('api')
                    ->namespace($this->namespace)
                    ->group(__DIR__.'/../../routes/api.php');

                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(__DIR__.'/../../routes/web.php');
            });
        }
    }

    protected function mapVercelRoutes()
    {
        // API routes
        Route::prefix('apis')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(function () {
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
                
                Route::get('/forecast', [\App\Http\Controllers\ForecastController::class, 'index_query']);
                Route::get('/forecast/city/{city_id}', [\App\Http\Controllers\ForecastController::class, 'index']);
            });

        // Web routes
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/', function () {
                    return view('index');
                });
            });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
