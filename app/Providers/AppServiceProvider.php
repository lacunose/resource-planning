<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if(in_array(env('APP_ENV', 'local'), ['beta', 'production', 'prod'])) {
            \URL::forceScheme('https');
        }

        Projectionist::addReactors([
            \App\Reactors\SaleTransactionReactor::class,
            \App\Reactors\ProcureTransactionReactor::class,
            \App\Reactors\DocumentReactor::class,
            \App\Reactors\SubscriptionReactor::class,
            \App\Reactors\UserReactor::class,
        ]);
    }
}
