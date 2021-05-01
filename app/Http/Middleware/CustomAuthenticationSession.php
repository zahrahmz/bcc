<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Auth;


/**
 * @property SessionGuard $auth
 */
class CustomAuthenticationSession extends AuthenticateSession
{

    protected $auth;


    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }


    public function handle($request, Closure $next)
    {
        return $next($request);
    }

}
