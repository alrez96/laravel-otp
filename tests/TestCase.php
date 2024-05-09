<?php

namespace Alrez96\LaravelOtp\Tests;

use Alrez96\LaravelOtp\OtpServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use function Orchestra\Testbench\artisan;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            OtpServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('otp.token_type', 'numeric');
        $app['config']->set('otp.token_length', 6);
        $app['config']->set('otp.token_validity', 2);
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
