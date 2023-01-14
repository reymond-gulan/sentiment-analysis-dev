<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollegesRequest extends FormRequest
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
            'college_code' => 'required|string|max:255',
            'college_name' => 'required|string|max:255',
            'college_dean' => 'nullable',
        ];
    }
}
