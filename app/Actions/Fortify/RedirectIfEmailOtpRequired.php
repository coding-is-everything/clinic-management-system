<?php

namespace App\Actions\Fortify;

use App\Mail\OtpMail;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Fortify;

class RedirectIfEmailOtpRequired
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

        if (! $user->mfa_enabled) {
            return $next($request);
        }

        $code = (string) random_int(100000, 999999);

        Cache::put("email-otp:{$user->getKey()}", [
            'code' => $code,
            'attempts' => 0,
        ], now()->addMinutes(5));

        Mail::to($user->email)->send(new OtpMail($code));

        $request->session()->put([
            'otp.id' => $user->getKey(),
            'otp.remember' => $request->boolean('remember'),
        ]);

        return redirect()->route('otp.verify');
    }
}
