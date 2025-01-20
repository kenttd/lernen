<?php

namespace Amentotech\LaraPayEase;

use Amentotech\LaraPayEase\Factories\PaymentFactory;
use Illuminate\Support\ServiceProvider;

class PayEaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'payease');
    }

    public function register()
    {
        $this->app->singleton('payment.driver', function ($app) {
            return new PaymentFactory();
        });
    }
}
