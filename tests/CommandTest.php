<?php

namespace Alrez96\LaravelOtp\Tests;

use Illuminate\Support\Facades\Artisan;
use Alrez96\LaravelOtp\Otp;

class CommandTest extends TestCase
{
    /**
     * Test it can prune all old tokens.
     */
    public function test_it_can_prune_all_old_tokens(): void
    {
        $otp = new Otp;

        $otpToken = $otp->generateToken('test@example.com');

        $otp->validateToken('test@example.com', $otpToken);

        $this->assertDatabaseHas(config('otp.token_table'), [
            'identifier' => 'test@example.com',
        ]);

        Artisan::call('otp:prune');

        $this->assertDatabaseMissing(config('otp.token_table'), [
            'identifier' => 'test@example.com',
        ]);
    }
}
