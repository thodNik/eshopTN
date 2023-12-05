<?php

use App\Actions\Shared\ResourceResolverAction;
use Illuminate\Support\Facades\Auth;

if (! function_exists('guardMe')) {
    function guardMe(): string
    {
        if (Auth::guard('user-api')->check()) {
            $guard = 'user-api';
        } elseif (Auth::guard('tech-api')->check()) {
            $guard = 'tech-api';
        } elseif (Auth::guard('admin-api')->check()) {
            $guard = 'admin-api';
        } else {
            $guard = false;
        }

        return $guard;
    }
}

if (! function_exists('getAuthUserFromResource')) {
    function getAuthUserFromResource()
    {
        return ResourceResolverAction::make(auth(guardMe())->user());
    }
}

if (! function_exists('getAuthUser')) {
    function getAuthUser()
    {
        return auth(guardMe())->user();
    }
}

if (! function_exists('whenHas')) {
    // Define the global function whenHas
    function whenHas($value, callable $callback, callable $default)
    {
        // Check if the value is null or empty, and if so, return the result of the default callback.
        if (empty($value)) {
            return $default();
        }

        // Otherwise, execute the callback function and return its result.
        return $callback();
    }
}

