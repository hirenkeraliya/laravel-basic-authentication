<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (Str::startsWith($request->getRequestUri(), '/admin')) {
            if (Auth::guard('admin')->check()) {
                return null;
            }

            return route('admin.login');
        }

        return $request->expectsJson() ? null : route('login');
    }
}
