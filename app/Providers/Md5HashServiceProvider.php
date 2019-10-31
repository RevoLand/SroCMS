<?php

namespace App\Providers;

use App\Classes\Md5Hash;
use Illuminate\Support\ServiceProvider;

class Md5HashServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Boot any application services.
     */
    public function boot()
    {
        app('hash')->extend('md5', function ()
        {
            return new Md5Hash();
        });
    }
}
