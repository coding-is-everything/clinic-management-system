<?php

namespace App\Http\Controllers;

use App\Http\Requests\Onboarding\StoreOrganizationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OnboardingController extends Controller
{
    public function show(Request $request): Response
    {
        return Inertia::render('onboarding/organization', [
            'organization' => $request->session()->get('onboarding.organization'),
            'appHost' => $request->getHost(),
        ]);
    }

    public function store(StoreOrganizationRequest $request): RedirectResponse
    {
        $request->session()->put('onboarding.organization', $request->validated());

        return redirect()->route('onboarding.next');
    }

    public function next(Request $request): Response|RedirectResponse
    {
        $organization = $request->session()->get('onboarding.organization');

        if (! $organization) {
            return redirect()->route('onboarding.show');
        }

        return Inertia::render('onboarding/setup-pending', [
            'organization' => $organization,
            'appHost' => $request->getHost(),
        ]);
    }
}
