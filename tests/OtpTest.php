<?php

namespace Alrez96\LaravelOtp\Tests;

use Alrez96\LaravelOtp\Otp;
use Carbon\Carbon;

class OtpTest extends TestCase
{
    /**
     * Test it can generate a new otp token.
     */
    public function test_it_can_generate_token(): void
    {
        $otp = new Otp;

        $otpToken = $otp->generateToken('test@example.com');

        $this->assertIsString($otpToken);
        $this->assertDatabaseHas('otp_tokens', [
            'identifier' => 'test@example.com',
        ]);
    }

    /**
     * Test it can validate otp token.
     */
    public function test_it_can_validate_token(): void
    {
        $otp = new Otp;

        $otpToken = $otp->generateToken('test@example.com');

        $otpValidated = $otp->validateToken('test@example.com', $otpToken);

        $this->assertIsBool($otpValidated);
        $this->assertTrue($otpValidated);
    }

    /**
     * Test it can't validate with invalid otp token.
     */
    public function test_it_can_not_validate_with_invalid_token(): void
    {
        $otp = new Otp;

        $otp->generateToken('test@example.com');

        $otpValidated = $otp->validateToken('test@example.com', 'wrong');

        $this->assertIsBool($otpValidated);
        $this->assertFalse($otpValidated);
    }

    /**
     * Test it can't validate with expired otp token.
     */
    public function test_it_can_not_validate_with_expired_token(): void
    {
        $otp = new Otp;

        $otpToken = $otp->generateToken('test@example.com');

        Carbon::setTestNow(Carbon::now()->addMinutes(config('otp.token_validity', 2) + 1));

        $otpValidated = $otp->validateToken('test@example.com', $otpToken);

        $this->assertIsBool($otpValidated);
        $this->assertFalse($otpValidated);
    }

    /**
     * Test it can't validate with used otp token.
     */
    public function test_it_can_not_validate_with_used_token(): void
    {
        $otp = new Otp;

        $otpToken = $otp->generateToken('test@example.com');

        $otp->validateToken('test@example.com', $otpToken);
        $otpValidated = $otp->validateToken('test@example.com', $otpToken);

        $this->assertIsBool($otpValidated);
        $this->assertFalse($otpValidated);
    }
}
