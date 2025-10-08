<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTherapySessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->admin == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'session_cost' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'client_contribution' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'remaining_client_contribution' => ['required', 'numeric', 'min:0', 'max:99999.99'],
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'session_cost.required' => 'Session cost is required.',
            'session_cost.numeric' => 'Session cost must be a number.',
            'session_cost.min' => 'Session cost must be at least 0.',
            'session_cost.max' => 'Session cost cannot exceed 99999.99.',
            'client_contribution.required' => 'Client contribution is required.',
            'client_contribution.numeric' => 'Client contribution must be a number.',
            'client_contribution.min' => 'Client contribution must be at least 0.',
            'client_contribution.max' => 'Client contribution cannot exceed 99999.99.',
            'remaining_client_contribution.required' => 'Remaining client contribution is required.',
            'remaining_client_contribution.numeric' => 'Remaining client contribution must be a number.',
            'remaining_client_contribution.min' => 'Remaining client contribution must be at least 0.',
            'remaining_client_contribution.max' => 'Remaining client contribution cannot exceed 99999.99.',
        ];
    }
}
