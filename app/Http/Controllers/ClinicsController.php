<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clinics\SaveClinicRequest;
use App\Models\Clinic;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ClinicsController extends Controller
{
    public function index(Request $request): Response
    {
        $team = Team::where('slug', $request->route('current_team'))->firstOrFail();

        $clinics = $team->clinics()->orderBy('created_at')->get();

        $doctorCounts = DB::table('doctors')
            ->whereIn('primary_clinic_id', $clinics->pluck('id'))
            ->whereNull('deleted_at')
            ->selectRaw('primary_clinic_id, count(*) as total')
            ->groupBy('primary_clinic_id')
            ->pluck('total', 'primary_clinic_id');

        return Inertia::render('clinics/index', [
            'clinics' => $clinics->map(fn (Clinic $clinic) => [
                'id' => $clinic->id,
                'name' => $clinic->name,
                'code' => $clinic->code,
                'email' => $clinic->email,
                'phone' => $clinic->phone,
                'address_line1' => $clinic->address_line1,
                'address_line2' => $clinic->address_line2,
                'city' => $clinic->city,
                'state' => $clinic->state,
                'postal_code' => $clinic->postal_code,
                'country' => $clinic->country,
                'status' => $clinic->status,
                'doctorCount' => $doctorCounts[$clinic->id] ?? 0,
            ]),
        ]);
    }

    public function store(SaveClinicRequest $request): RedirectResponse
    {
        $team = Team::where('slug', $request->route('current_team'))->firstOrFail();

        $data = $request->validated();
        $data['code'] ??= $this->nextClinicCode($team);

        $team->clinics()->create($data);

        return back();
    }

    public function update(SaveClinicRequest $request): RedirectResponse
    {
        // Note: with a Request-derived $request parameter present alongside
        // the {current_team} route segment, Laravel binds extra route
        // parameters positionally rather than by name — so the clinic must
        // be resolved explicitly rather than type-hinted here (see
        // ModulePlaceholderController for the same footgun).
        $team = Team::where('slug', $request->route('current_team'))->firstOrFail();

        $clinic = $team->clinics()->findOrFail($request->route('clinic'));

        $data = $request->validated();
        $data['code'] ??= $clinic->code;

        $clinic->update($data);

        return back();
    }

    private function nextClinicCode(Team $team): string
    {
        return sprintf('CLN-%03d', $team->clinics()->withTrashed()->count() + 1);
    }
}
