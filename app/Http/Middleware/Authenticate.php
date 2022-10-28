<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {
        $this->authenticate($request, $guards);
        $user = $this->getUser();
        return $this->checkIsActive($user) ?: $next($request);
    }

    /**
     * @param User $user
     * @return RedirectResponse|bool
     */
    protected function checkIsActive(User $user): bool|RedirectResponse
    {
        if (!$user->status) {
            Auth::logout();
            return redirect('login')->withErrors(__('Your account is deactivated!'));
        }
        return false;
    }

    /**
     * @return Authenticatable|User
     */
    protected function getUser(): ?User
    {
        return auth()->user();
    }
}
