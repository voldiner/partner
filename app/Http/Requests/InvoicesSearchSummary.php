<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoicesSearchSummary extends FormRequest
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

            'month' => [
                'required',
                'integer',
                Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
            ],
            'year' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
