<?php

namespace Alrez96\LaravelOtp;

use Alrez96\LaravelOtp\Console\Commands\PruneOtps;
use Illuminate\Support\ServiceProvider;

class OtpServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/otp.php', 'otp');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole()) {
            $this->publishesMigrations([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'otp-migrations');

            $this->publishes([
                __DIR__ . '/../config/otp.php' => config_path('otp.php'),
            ], 'otp-config');

            $this->commands([
                PruneOtps::class,
            ]);
        }
    }
}
