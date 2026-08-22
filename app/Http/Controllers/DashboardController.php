<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamInvitation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Labels for the sample KPI row, in display order.
     *
     * @var array<int, string>
     */
    private const STAT_LABELS = [
        "Today's Appointments",
        'Patients Checked-in',
        'Doctors Available',
        'Pending Invoices',
    ];

    /**
     * Per-tenant dashboard branding and sample KPI values.
     *
     * This is a lightweight, hand-maintained lookup for now. Once clinics can
     * configure their own branding, this should read from the tenant's own
     * settings instead of this fixed table.
     *
     * @var array<string, array{specialty: string, accent: string, values: array<int, string>}>
     */
    private const CLINIC_PROFILES = [
        'default-clinic' => [
            'specialty' => 'General OPD & Family Medicine',
            'accent' => 'teal',
            'values' => ['42', '18', '6', '9'],
        ],
        'apollo-bilaspur' => [
            'specialty' => 'Multi-Specialty Hospital',
            'accent' => 'rose',
            'values' => ['127', '54', '21', '33'],
        ],
    ];

    public function __invoke(Request $request): Response
    {
        $email = strtolower($request->user()->email);

        $pendingInvitations = TeamInvitation::query()
            ->with(['inviter', 'team'])
            ->whereRaw('LOWER(email) = ?', [$email])
            ->whereNull('accepted_at')
            ->where(fn ($query) => $query
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now()))
            ->latest()
            ->get()
            ->map(fn (TeamInvitation $invitation) => [
                'code' => $invitation->code,
                'inviterName' => $invitation->inviter->name,
                'team' => [
                    'name' => $invitation->team->name,
                    'slug' => $invitation->team->slug,
                ],
            ]);

        $team = Team::where('slug', $request->route('current_team'))->firstOrFail();

        return Inertia::render('dashboard', [
            'pendingInvitations' => $pendingInvitations,
            'clinic' => $this->clinicProfile($team),
        ]);
    }

    /**
     * @return array{name: string, specialty: string, accent: string, stats: array<int, array{label: string, value: string}>}
     */
    private function clinicProfile(Team $team): array
    {
        $profile = self::CLINIC_PROFILES[$team->slug] ?? [
            'specialty' => 'Multi-Specialty Clinic',
            'accent' => 'teal',
            'values' => ['—', '—', '—', '—'],
        ];

        return [
            'name' => $team->name,
            'specialty' => $profile['specialty'],
            'accent' => $profile['accent'],
            'stats' => collect(self::STAT_LABELS)
                ->map(fn (string $label, int $i) => ['label' => $label, 'value' => $profile['values'][$i]])
                ->all(),
        ];
    }
}
