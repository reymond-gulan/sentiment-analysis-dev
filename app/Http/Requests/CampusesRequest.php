<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampusesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable',
            'campus_name' => 'required|string|max:255',
            'campus_address' => 'required',
            'email_address' => 'nullable|email',
            'contact_information' => 'nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'campus_name.required' => 'Campus Name must not be empty.',
            'campus_name.unique' => 'Campus Name already exists.',
            'campus_address.required' => 'Campus Address is a required field.',
            'email_address.email' => 'Submitted email address seems to be invalid.',
            'email_address' => 'Submitted email already exists.',
        ];
    }
}
