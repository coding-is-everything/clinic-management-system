<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $team = Team::where('slug', $request->route('current_team'))->firstOrFail();

        $query = trim((string) $request->query('q', ''));

        if ($query === '') {
            return response()->json(['clinics' => [], 'members' => []]);
        }

        $clinics = $team->clinics()
            ->where(fn ($q) => $q->where('name', 'like', "%{$query}%")
                ->orWhere('code', 'like', "%{$query}%"))
            ->orderBy('name')
            ->limit(5)
            ->get(['id', 'name', 'code', 'status'])
            ->map(fn ($clinic) => [
                'id' => $clinic->id,
                'name' => $clinic->name,
                'code' => $clinic->code,
                'status' => $clinic->status,
                'href' => "/{$team->slug}/clinics",
            ]);

        $members = $team->members()
            ->where(fn ($q) => $q->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%"))
            ->orderBy('name')
            ->limit(5)
            ->get()
            ->map(function (User $member) use ($team) {
                /** @var Membership $membership */
                $membership = $member->getRelation('pivot');

                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'roleLabel' => $membership->role->label(),
                    'href' => "/settings/teams/{$team->slug}",
                ];
            });

        return response()->json(['clinics' => $clinics, 'members' => $members]);
    }
}
