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

        if(in_array(env('APP_MODE', 'erp'), ['erp'])) {
            Projectionist::addReactors([
                \Lacunose\Swirl\Reactors\ERPSaleTransactionReactor::class,
                \Lacunose\Swirl\Reactors\ProcureTransactionReactor::class,
                \Lacunose\Swirl\Reactors\DocumentReactor::class,
                \Lacunose\Swirl\Reactors\SubscriptionReactor::class,
                \Lacunose\Swirl\Reactors\UserReactor::class,
                \Lacunose\Swirl\Reactors\CustomerReactor::class,
                \Lacunose\Swirl\Reactors\AccessReactor::class,
                \Lacunose\Swirl\Reactors\SaleCustomerReactor::class,
            ]);
        }else{
            Projectionist::addReactors([
                \Lacunose\Swirl\Reactors\MRPSaleTransactionReactor::class,
                \Lacunose\Swirl\Reactors\ProcureTransactionReactor::class,
                \Lacunose\Swirl\Reactors\DocumentReactor::class,
                \Lacunose\Swirl\Reactors\SubscriptionReactor::class,
                \Lacunose\Swirl\Reactors\UserReactor::class,
                \Lacunose\Swirl\Reactors\CustomerReactor::class,
                \Lacunose\Swirl\Reactors\AccessReactor::class,
                \Lacunose\Swirl\Reactors\SaleCustomerReactor::class,
            ]);
        }
    }
}
