<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'employee_id' => 'required|min:6',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'campus_id' => 'required',
            'user_type' => 'required',
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
            //'campus_name.required' => 'Campus Name must not be empty.',
            // 'campus_name.unique' => 'Campus Name already exists.',
            // 'campus_address.required' => 'Campus Address is a required field.',
            // 'email_address.email' => 'Submitted email address seems to be invalid.',
            //'email_address.unique' => 'Submitted email already exists.',
            'campus_id.required' => 'You must select from campus data.',
            'user_type.required' => 'You must select an account type for the user.',
        ];
    }
}
