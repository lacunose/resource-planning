<?php

namespace Lacunose\Customer\Providers;

use Str;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Console\Scheduling\Schedule;

use Spatie\EventSourcing\Facades\Projectionist;

use Lacunose\Customer\Console\Commands\AutoExtend;

class CustomerServiceProvider extends ServiceProvider {

    protected $namespace = 'Lacunose\Customer\Http\Controllers';

    public const HOME = '/login';

    /**
     * Register any application customers.
     *
     * @return void
     */
    public function register() {
        //REGISTER COMMAND
        $this->commands([
            AutoExtend::class,
        ]);
    }

    /**
     * Bootstrap any application customers.
     *
     * @return void
     */
    public function boot() {

        $this->publishes([
            __DIR__.'/../../config/tcust.php' => config_path('tcust.php'),
        ]);
        
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            // PUBLISH MIGRATION
            $this->publishes([
                __DIR__.'/../../database/migrations/' => database_path('/migrations/tenant'),
            ]);

            // REGISTER CONSOLE
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                if (app(\Hyn\Tenancy\Environment::class)->tenant()) {

                    $schedule->command(AutoExtend::class)->dailyAt('00:00')
                    ->before(function (Schedule $schedule) {
                        $tenant = app(\Hyn\Tenancy\Environment::class)->tenant();
                        $event  = $schedule->events()[0];
                        $event->command .= sprintf(" --website_id=%d", $tenant->id);
                    });
                }
            });

            // REGISTER MIDDLEWARE
        }else{
            // PUBLISH MIGRATION
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

            // REGISTER CONSOLE
            $schedule = $this->app->make(Schedule::class);
            $schedule->command(AutoExtend::class)->dailyAt('00:00');

            // REGISTER MIDDLEWARE
        }

        //REGISTER PROJECTOR
        Projectionist::addProjectors([
            \Lacunose\Customer\Projectors\AccountProjector::class,
            \Lacunose\Customer\Projectors\ProgramProjector::class,
            \Lacunose\Customer\Projectors\CustomerProjector::class,
        ]);

        //REGISTER REACTOR
        Projectionist::addReactors([
            \Lacunose\Customer\Reactors\AccountReactor::class,
            \Lacunose\Customer\Reactors\CustomerReactor::class,
        ]);
        
        // REGISTER ROUTES
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        // REGISTER VIEWS
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'tcust');
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
        // REGISTER ROUTES
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('/customer')
            ->group(__DIR__.'/../../routes/web.php');
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
        Route::middleware('api')
            ->namespace($this->namespace)
            ->prefix('api/customer')
            ->group(__DIR__.'/../../routes/api.php');
    }
}
