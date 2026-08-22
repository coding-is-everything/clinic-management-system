<?php

namespace App\Http\Requests\Clinics;

use App\Models\Team;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveClinicRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $team = Team::where('slug', $this->route('current_team'))->firstOrFail();
        $clinicId = $this->route('clinic');

        return [
            'name' => ['required', 'string', 'max:200'],
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('clinics', 'code')
                    ->where(fn ($query) => $query->where('team_id', $team->id))
                    ->ignore($clinicId),
            ],
            'email' => ['nullable', 'string', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
        ];
    }
}
