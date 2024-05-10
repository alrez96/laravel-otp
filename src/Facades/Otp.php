<?php

namespace Alrez96\LaravelOtp\Facades;

use Illuminate\Support\Facades\Facade;

class Otp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Alrez96\LaravelOtp\Otp::class;
    }
}
