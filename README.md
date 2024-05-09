# Laravel OTP - One-Time Password Authentication

[![Latest Stable Version](http://poser.pugx.org/alrez96/laravel-otp/v)](https://packagist.org/packages/alrez96/laravel-otp)
[![Total Downloads](http://poser.pugx.org/alrez96/laravel-otp/downloads)](https://packagist.org/packages/alrez96/laravel-otp)

## Introduction

This is a simple package for implementing the OTP system in Laravel, which only includes generating the token and validating it. You can use this package alongside Laravel's authentication system or the [laravel/breeze](https://github.com/laravel/breeze) package.

## Installation

You can install the package via composer:

```bash
composer require alrez96/laravel-otp
```

## Configuration

**You should publish** the migration and the config/otp.php config file with:

```bash
php artisan vendor:publish --provider="Alrez96\LaravelOtp\OtpServiceProvider"
```

## Usage

### Generate OTP Token

```php
<?php

use Alrez96\LaravelOtp\Otp;

$otp = new Otp;

$otp->generateToken(string $identifier);

// or using helper

otp()->generateToken(string $identifier);
```

### Validate OTP Token

```php
<?php

use Alrez96\LaravelOtp\Otp;

$otp = new Otp;

$otp->validateToken(string $identifier, string $token);

// or using helper

otp()->validateToken(string $identifier, string $token);
```

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).
