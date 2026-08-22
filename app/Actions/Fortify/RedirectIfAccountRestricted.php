<?php

namespace App\Actions\Fortify;

use App\Support\AccountRestrictions;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;

class RedirectIfAccountRestricted
{
    public function __construct(protected StatefulGuard $guard) {}

    /**
     * Handle the incoming request.
     *
     * @param  callable  $next
     */
    public function handle(Request $request, $next): mixed
    {
        $provider = $this->guard->getProvider();

        $user = $provider->retrieveByCredentials(
            $request->only(Fortify::username(), 'password')
        );

        if (! $user || ! $provider->validateCredentials($user, ['password' => $request->password])) {
            return $next($request);
        }

        if (AccountRestrictions::allows($user->status)) {
            return $next($request);
        }

        $request->session()->put('access_restricted.user_id', $user->getKey());

        return redirect()->route('access-restricted.show');
    }
}
