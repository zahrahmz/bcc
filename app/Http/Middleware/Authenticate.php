<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (empty($request->segments()[0])) {
                return route('site.login');
            }

            if ($request->segments()[0] == 'admin') {
                return route('admin.login');
            }

            return route('site.login');
        }
    }
}
