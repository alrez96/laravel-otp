<?php

if (!function_exists('otp')) {

    /**
     * @param string $str
     * @return \Alrez96\LaravelOtp\Otp
     */
    function otp()
    {
        return new \Alrez96\LaravelOtp\Otp;
    }
}
