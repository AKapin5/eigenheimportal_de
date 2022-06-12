<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AdminAuthenticate extends Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('admin.login');
        }
        return null;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {
        $this->authenticate($request, $guards);
        $user = $this->getUser();
        if (!$user->hasRole(config('admin.roles'))) {
            return redirect(route('home'));
        }
        return $this->checkIsActive($user) ?: $next($request);
    }
}
