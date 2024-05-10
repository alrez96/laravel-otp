<?php

namespace Alrez96\LaravelOtp;

use Illuminate\Database\Eloquent\Model;

class OtpToken extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('otp.token_table') ?: parent::getTable();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'token',
        'expired_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'token' => 'hashed',
            'expired_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }
}
