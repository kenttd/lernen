<?php

namespace App\Http\Requests\Student\Order;

use App\Models\UserWallet;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest {
    /**OrderRequest
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'firstName'             => 'required|string|max:150',
            'lastName'              => 'required|string|max:150',
            'paymentMethod'         => 'required|string|max:150',
            'phone'                 => 'required|numeric|digits:11',
            'email'                 => 'required|email',
            'country'               => 'required|string|max:150',
            'state'                 => 'required|string|max:255',
            'zipcode'               => 'required|integer|regex:/^\d{5,}$/',
            'city'                  => 'required|string|max:150',
        ];
    }

    public function messages() {
        return [
            'required'                  => __('general.required_field'),
            'paymentMethod.required'    => __('general.method_required'),
            'email'                     => __('general.invalid_email'),
            'required_with'             => __('general.required_field'),
            'zipcode.regex'             => __('validation.min_length_field', ['field' => 'zipcode', 'length' => 5]),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'firstName'             => sanitizeTextField($this->firstName),
            'lastName'              => sanitizeTextField($this->lastName),
            'paymentMethod'         => sanitizeTextField($this->paymentMethod),
            'company'               => sanitizeTextField($this->company),
            'country'               => sanitizeTextField($this->country),
            'state'                 => sanitizeTextField($this->state),
            'city'                  => sanitizeTextField($this->city),
        ]);
    }
}
