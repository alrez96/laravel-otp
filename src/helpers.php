<?php

use Alrez96\LaravelOtp\Otp;

if (!function_exists('otp')) {

    /**
     * @param string $str
     * @return \Alrez96\LaravelOtp\Otp
     */
    function otp(): Otp
    {
        return new Otp;
    }
}
