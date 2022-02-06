<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'string|required|max:255',
            'short_name' => 'string|nullable|max:100',
            'edrpou' => 'numeric|nullable',
            'is_pdv' => 'required_with:certificate,certificate_tax',
            'certificate' => 'required_with:is_pdv',
            'certificate_tax' => 'required_with:is_pdv',
            'surname' => 'string|nullable|max:150',
            'identifier' => 'numeric|nullable',
            'telephone' => 'nullable|numeric',
            'address' => 'string|required|max:255',
            'insurer' => 'string|nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Повне ім"я обов"язкове',
            'full_name.string' => 'Повне ім"я обов"язкове',
            'edrpou.numeric' => 'Код ЄДРПОУ має містити тільки цифри',
            'certificate.required_with' => 'Номер свідоцтва має бути, якщо платник ПДВ',
            'certificate_tax.required_with' => 'Податковий номер має бути, якщо платник ПДВ',
            'identifier.numeric' => 'Ідентифікаційний код тільки цифри',
            'telephone.numeric' => 'Телефон тільки цифри',
            'is_pdv.required_with' => 'Відмітка ПЛАТНИК ПДВ ставиться разом з номером свідоцтва та под. номером',
        ];
    }

    protected function prepareForValidation()
    {
       $value_checkbox = $this->get('is_pdv');
        /*if ($value_checkbox) {
            $this->merge([
                'is_pdv' => 1,
            ]);
        } else {
            $this->merge([
                'is_pdv' => 0,
            ]);
        }*/
    }
}
