<?php

namespace App\Providers;
use app;
use Inertia\Inertia;
use App\Billing\BankPaymentGateway;
use App\Billing\CreditPaymentGateway;
use App\Billing\PaymentGatewayContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentGatewayContract::class, function($app){
            
            if(request()->has('credit')){
                return new CreditPaymentGateway('USD');
            }
            return new BankPaymentGateway('USD');
        });
    }
 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         //Inertia::share('base_url' , env('APP_URL'));
    }
}
