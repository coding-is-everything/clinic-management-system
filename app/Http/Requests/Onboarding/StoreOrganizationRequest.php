<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organization_name' => ['required', 'string', 'max:150'],
            'workspace_slug' => [
                'required',
                'string',
                'max:63',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('teams', 'slug'),
            ],
            'business_email' => ['required', 'string', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'clinic_type' => ['required', Rule::in(['general', 'dental', 'physio', 'specialist', 'other'])],
            'num_doctors' => ['nullable', 'integer', 'min:1'],
            'num_branches' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'workspace_slug.regex' => 'The workspace slug may only contain lowercase letters, numbers, and hyphens.',
            'workspace_slug.unique' => 'That workspace slug is already taken. Please choose another.',
        ];
    }
}
