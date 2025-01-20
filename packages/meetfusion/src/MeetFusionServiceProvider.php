<?php

namespace Amentotech\MeetFusion;

use Illuminate\Support\ServiceProvider;
use Amentotech\MeetFusion\Factories\MeetFusionFactory;
class MeetFusionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'meetfusion');
    }

    public function register()
    {
        $this->app->singleton('meetfusion', function () {
            return new MeetFusionFactory();
        });

    }
}
