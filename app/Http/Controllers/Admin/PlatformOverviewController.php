<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlatformOverviewController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $tenants = Team::withCount(['clinics', 'members'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function (Team $team) {
                $owner = $team->owner();

                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'slug' => $team->slug,
                    'clinicsCount' => $team->clinics_count,
                    'membersCount' => $team->members_count,
                    'ownerName' => $owner?->name,
                    'ownerEmail' => $owner?->email,
                    'createdAt' => $team->created_at?->toIso8601String(),
                ];
            });

        return Inertia::render('admin/overview', [
            'stats' => [
                'totalTenants' => Team::count(),
                'totalClinics' => Clinic::count(),
                'totalUsers' => User::count(),
            ],
            'tenants' => $tenants,
            'appHost' => $request->getHost(),
        ]);
    }
}
