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
        $type = $type ?: config('otp.token_type');
        $length = $length ?: config('otp.token_length');
        $validity = $validity ?: config('otp.token_validity');

        if ($length < 1 || $validity < 1) {
            throw new Exception(
                'The ' .  (($length < 1) ? 'length' : 'validity') . ' must be set to a value greater than 1!'
            );
        }

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
    private function generateNumericToken(int $length): string
    {
        return substr_replace((string) random_int(10 ** ($length - 1), 10 ** ($length) - 1), random_int(0, 9), 0, 1);
    }

    /**
     * Generate alphanumeric otp token.
     *
     * @param int $length
     * @return string
     */
    private function generateAlphanumericToken(int $length): string
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, $length);
    }
}
