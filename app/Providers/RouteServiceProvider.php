<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapAuthRoutes();
        
        $this->mapOAuthRoutes();

        $this->mapApiRoutes();
        $this->mapWebRoutes();

        $this->mapThunderRoutes();
        $this->mapOwnerRoutes();
        $this->mapMemberRoutes();

        $this->mapTenantHomepageRoutes();
        $this->mapTenantDashboardRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::middleware('web')
             ->group(base_path('routes/auth.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapOAuthRoutes()
    {
        Route::middleware('api')
             ->group(base_path('routes/oauth.php'));
    }
    
    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::domain(env('APP_BASE', 'localhost'))
             ->middleware('web')
             ->namespace('App\Http\Controllers\Web')
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapTenantHomepageRoutes()
    {
        Route::middleware('web')
             ->namespace('App\Http\Controllers\Homepage')
             ->group(base_path('routes/homepage.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapTenantDashboardRoutes()
    {
        Route::prefix('manage')
             ->middleware(['web', 'tacl.client'])
             ->namespace('App\Http\Controllers\Dashboard')
             ->group(base_path('routes/dashboard.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapThunderRoutes()
    {
        Route::domain('thunder.'.env('APP_BASE', 'localhost'))
             ->middleware(['web', 'tacl.level:thunder'])
             ->namespace('App\Http\Controllers\Thunder')
             ->group(base_path('routes/thunder.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapOwnerRoutes()
    {
        Route::domain('owner.'.env('APP_BASE', 'localhost'))
             ->middleware(['web', 'tacl.level:owner|thunder'])
             ->namespace('App\Http\Controllers\Owner')
             ->group(base_path('routes/owner.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapMemberRoutes()
    {
        Route::domain('member.'.env('APP_BASE', 'localhost'))
             ->middleware(['web'])
             ->namespace('App\Http\Controllers\Member')
             ->group(base_path('routes/member.php'));
    }
}
