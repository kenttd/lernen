<?php

namespace App\Http\Requests\Common\PersonalDetail;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Facades\Auth;

class PersonalDetailRequest extends BaseFormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $enableGooglePlaces           = setting('_api.enable_google_places') ?? '0';

        $rules = [
            'first_name'        => 'required|string|min:3|max:150',
            'last_name'         => 'sometimes|string|min:3|max:150',
            'gender'            => 'required|in:male,female,not_specified',
            'user_languages'    => 'required|array|min:1',
            'native_language'   => 'required|string:max:255',
            'description'       => 'required|string|min:20|max:65535',
            'email'             => 'required|email|max:255',
            'image'             => 'required',
        ];

        if(Auth::user()->role == 'tutor'){
            $rules['intro_video'] = 'required';
            $rules['tagline']     = 'required|string|min:20|max:255';
        }

        if( $enableGooglePlaces != '1'){
            $rules['country']   = 'required|numeric';
            $rules['city']      = 'required|string|max:255';
            $rules['zipcode']   = 'required|regex:/^[A-Za-z0-9\s\-]+$/';
        } else {
            $rules['address']   = 'required|string|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required'      => __('validation.required_field'),
            'email'         => __('validation.invalid_email'),
            'zipcode.regex'         => __('validation.min_length_field', ['field' => 'zipcode', 'length' => 5]),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'first_name'                => sanitizeTextField($this->first_name),
            'last_name'                 => sanitizeTextField($this->last_name),
            'native_language'           => sanitizeTextField($this->native_language),
            'description'               => sanitizeTextField($this->description, keep_linebreak:true),
            'city'                      => sanitizeTextField($this->city),
            'address'                   => sanitizeTextField($this->address),
        ]);
    }
}

