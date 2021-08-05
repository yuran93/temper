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
        # Lets just bind the csv repo to out contract so in future we can easily switch to db.
        $this->app->bind(
            SignupTrackingRepository::class,
            SignupTrackingCSVRepository::class
        );
    }
}
