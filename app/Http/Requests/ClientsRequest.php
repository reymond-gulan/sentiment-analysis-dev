<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsRequest extends FormRequest
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
            'id_number' => 'nullable',
            'name' => 'nullable',
            'yr' => 'nullable',
            'email_address' => 'nullable|email',
            'gender' => 'required',
            'course_id' => 'required',
            'college_id' => 'required',
            'office_id' => 'required',
            'semester' => 'required',
            'deleted_at' => 'nullable',
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
            'course_id.required' => 'You must select a course.',
            'college_id.required' => 'You must select a college.',
            'office_id.required' => 'You must select an office.',
        ];
    }
}
