<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\AccountRestrictions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccessRestrictedController extends Controller
{
    public function show(Request $request): Response|RedirectResponse
    {
        $user = $this->restrictedUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        $administrator = $user->currentTeam?->owner();

        return Inertia::render('auth/access-restricted', [
            'restriction' => AccountRestrictions::describe($user->status),
            'administratorEmail' => $administrator?->email,
        ]);
    }

    public function exit(Request $request): RedirectResponse
    {
        $request->session()->forget('access_restricted.user_id');

        return redirect()->route('login');
    }

    protected function restrictedUser(Request $request): ?User
    {
        $id = $request->session()->get('access_restricted.user_id');

        return $id ? User::find($id) : null;
    }
}
