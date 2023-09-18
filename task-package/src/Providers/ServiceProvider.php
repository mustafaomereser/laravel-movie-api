<?php

namespace Task\Package\Providers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(dirname(__DIR__) . "/routes/api.php");
    }

    public function register()
    {
        // $this->mergeConfigFrom();
    }
}
