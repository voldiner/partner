<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlacesSearchRequest extends FormRequest
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
            'data-range' => 'nullable|string|max:30',
            'stations' => 'nullable|array',
            'stations.*' => 'integer',
            'interval' => 'nullable|in:1',
            'number_place' => 'nullable|string|max:50',
            'final' => 'nullable|string|max:50',
            'surname' => 'nullable|string|max:50',
            'dateStart' => 'nullable|date_format:"d/m/Y"',
            'dateFinish' => 'nullable|date_format:"d/m/Y"'
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    protected function prepareForValidation()
    {
        $valueDataRange = $this->get('data-range');

        if ($valueDataRange) {
            $dates = explode('-', $valueDataRange);
            if (count($dates) === 2){
                $this->merge([
                    'dateStart' => trim($dates[0]),
                    'dateFinish' => trim($dates[1]),
                ]);
            }
        }

    }
}
