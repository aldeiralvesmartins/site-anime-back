<?php

namespace App\Config;

use App\Models\Dojo;
use Illuminate\Support\Facades\Auth;

class Config
{
    public static function isDevelop(): bool
    {
        return env('APP_ENV') === 'local' || env('APP_ENV') === 'development';
    }

    public static function isProduction(): bool
    {
        return env('APP_ENV') === 'production';
    }

    public static function isSuperAdmin(): bool
    {
        if (Auth::user()) {
            return Auth::user()->is_super_admin;
        }
        return false;
    }

    public static function isActive($user): bool
    {
        return $user->active && Dojo::find($user->dojo_id)->active;
    }

    public static function canLogin(array $credentials): bool
    {
        if (\auth()->attempt($credentials)) {
            debug();
            return self::isActive(\auth()->user());
        }

        return false;
    }
}
