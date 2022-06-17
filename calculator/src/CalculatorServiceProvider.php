<?php

namespace Chris\Calculator;

use Illuminate\Support\ServiceProvider;

class CalculatorServiceProvider extends ServiceProvider
{
   public function boot()
   {

    $this->publishes([
        __DIR__.'/config/codedcalculate.php' => config_path('codedcalculate.php'),
    ]);

    $this->loadViewsFrom(__DIR__.'/resources/views', 'calculator');

    $this->loadRoutesFrom(__DIR__.'/routes/web.php');

    $this->loadMigrationsFrom(__DIR__.'/database/migrations');
   }

   public function register()
   {

   }
}
