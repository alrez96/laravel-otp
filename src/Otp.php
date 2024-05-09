<?php

namespace Alrez96\LaravelOtp;

use Exception;
use Alrez96\LaravelOtp\OtpToken;
use Illuminate\Support\Facades\Hash;

class Otp
{
    /**
     * Generate a new otp token.
     *
     * @param string $identifier
     * @param string $type
     * @param int $length
     * @param int $validity
     * @return string
     * @throws Exception
     */
    public function generateToken(
        string $identifier,
        ?string $type = null,
        ?int $length = null,
        ?int $validity = null
    ): string {
        $type = $type ?: config('otp.token_type', 'numeric');
        $length = $length ?: config('otp.token_length', 6);
        $validity = $validity ?: config('otp.token_validity', 2);

        switch ($type) {
            case 'numeric':
                $generatedToken = $this->generateNumericToken($length);
                break;
            case 'alpha_numeric':
                $generatedToken = $this->generateAlphanumericToken($length);
                break;
            default:
                throw new Exception("{$type} is not a supported type!");
        }

        OtpToken::create([
            'identifier' => $identifier,
            'token' => Hash::make($generatedToken),
            'expired_at' => now()->addMinutes($validity),
        ]);

        return $generatedToken;
    }

    /**
     * Validate otp token.
     *
     * @param string $identifier
     * @param string $token
     * @return bool
     */
    public function validateToken(string $identifier, string $token): bool
    {
        $otp = OtpToken::where('identifier', $identifier)
            ->where('expired_at', '>', now())
            ->whereNull('used_at')
            ->latest()
            ->first();

        if (!$otp || !Hash::check($token, $otp->token)) {
            return false;
        }

        $otp->used_at = now();

        $otp->save();

        return true;
    }

    /**
     * Generate numeric otp token.
     *
     * @param int $length
     * @return string
     */
    private function generateNumericToken(int $length = 6): string
    {
        $i = 0;
        $token = '';

        while ($i < $length) {
            $token .= random_int(0, 9);
            $i++;
        }

        return $token;
    }

    /**
     * Generate alphanumeric otp token.
     *
     * @param int $length
     * @return string
     */
    private function generateAlphanumericToken(int $length = 6): string
    {
        return substr(
            str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'),
            0,
            $length
        );
    }
}
