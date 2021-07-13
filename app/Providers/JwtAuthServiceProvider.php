<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JwtAuthServiceProvider extends ServiceProvider
{

    public function register()
    {
        require_once app_path().'/Helpers/JwtAuth.php';
    }


    public function boot()
    {
        //
    }
}
