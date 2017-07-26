<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('password_current', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, current($parameters));
        });
        Validator::extend('password_confirmation', function ($attribute, $value, $parameters, $validator) {
            return $value === current($parameters);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
