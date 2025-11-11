<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // ADD THIS LINE: Imports the Rule class
use Illuminate\Validation\Rules\Password; // ADD THIS LINE: Imports the Password class

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * We already handle authorization in the controller via policies,
     * so we can simply return true here to allow the validation to proceed.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Define the roles an 'admin' is allowed to create.
        $adminAllowedRoles = ['agent', 'user'];
        // Define the roles an 'agent' is allowed to create.
        $agentAllowedRoles = ['user'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],

            // FIX: Use the imported 'Password' class directly
            'password' => ['required', 'confirmed', Password::defaults()],

            'role' => [
                'required',
                // FIX: Use the imported 'Rule' class
                Rule::in(
                    $this->user()->role === 'admin' ? $adminAllowedRoles : $agentAllowedRoles
                )
            ],
        ];
    }
}
