<?php

namespace App\Providers;

use App\Repositories\Contracts\SignupTrackingRepository;
use App\Repositories\FromCSV\SignupTrackingCSVRepository;
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
        $this->app->bind(
            SignupTrackingRepository::class,
            SignupTrackingCSVRepository::class
        );
    }

    // public function boot()
    // {
    //     $request = app('request');

    //     // ALLOW OPTIONS METHOD
    //     if( $request->getMethod() === 'OPTIONS')  {
    //         return response('OK',200)
    //             ->header('Access-Control-Allow-Origin', '*')
    //             ->header('Access-Control-Allow-Methods','OPTIONS, GET, POST, PUT, DELETE')
    //             ->header('Access-Control-Allow-Headers', 'Content-Type, Origin');
    //     }
    // }
}
