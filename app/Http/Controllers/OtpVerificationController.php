<?php

namespace App\Http\Controllers;

use App\Http\Responses\Concerns\RedirectsToCurrentTeam;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Fortify;

class OtpVerificationController extends Controller
{
    use RedirectsToCurrentTeam;

    public function show(Request $request): Response|RedirectResponse
    {
        $user = $this->pendingUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        return Inertia::render('auth/verify-otp', [
            'maskedEmail' => $this->maskEmail($user->email),
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string', 'size:6']]);

        $user = $this->pendingUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        $cacheKey = "email-otp:{$user->getKey()}";
        $entry = Cache::get($cacheKey);

        if (! $entry || $entry['attempts'] >= 5) {
            throw ValidationException::withMessages([
                'code' => 'This code has expired. Please request a new one.',
            ]);
        }

        if (! hash_equals($entry['code'], (string) $request->input('code'))) {
            Cache::put($cacheKey, [
                'code' => $entry['code'],
                'attempts' => $entry['attempts'] + 1,
            ], now()->addMinutes(5));

            throw ValidationException::withMessages([
                'code' => 'The code you entered is incorrect.',
            ]);
        }

        Cache::forget($cacheKey);

        Auth::login($user, (bool) $request->session()->pull('otp.remember', false));

        $request->session()->forget('otp.id');
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPathForCurrentTeam($request, Fortify::redirects('login')));
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $this->pendingUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        $throttleKey = "email-otp-resend:{$user->getKey()}";

        if (Cache::has($throttleKey)) {
            throw ValidationException::withMessages([
                'code' => 'Please wait before requesting another code.',
            ]);
        }

        $code = (string) random_int(100000, 999999);

        Cache::put("email-otp:{$user->getKey()}", [
            'code' => $code,
            'attempts' => 0,
        ], now()->addMinutes(5));
        Cache::put($throttleKey, true, now()->addSeconds(30));

        Mail::to($user->email)->send(new OtpMail($code));

        return back();
    }

    public function cancel(Request $request): RedirectResponse
    {
        $request->session()->forget(['otp.id', 'otp.remember']);

        return redirect()->route('login');
    }

    protected function pendingUser(Request $request): ?User
    {
        $id = $request->session()->get('otp.id');

        return $id ? User::find($id) : null;
    }

    protected function maskEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email);

        $visible = min(2, strlen($name));

        return substr($name, 0, $visible).str_repeat('•', max(strlen($name) - $visible, 3)).'@'.$domain;
    }
}
