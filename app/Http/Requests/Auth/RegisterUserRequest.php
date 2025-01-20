<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password'      => ['required', 'string', 'confirmed', Password::defaults()],
            'user_role'     => 'required|in:tutor,student',
            'terms'         => 'required|string'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'first_name'        => sanitizeTextField($this->first_name),
            'last_name'         => sanitizeTextField($this->last_name),
        ]);
    }
}
