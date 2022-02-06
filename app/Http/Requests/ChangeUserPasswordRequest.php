<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangeUserPasswordRequest extends FormRequest
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
            'password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'confirmed',
                'regex:((?=.*d)(?=.*[a-z])(?=.*[A-Z])(?=.*[1-9]).{8,20})',
            ],
            'new_password_confirmation' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Пароль необхідно вказати',
            'password.current_password' => 'Неправильний пароль',
            'new_password.regex' => 'Мають бути: латинські - великі букви, маленькі букви, цифри. Довжина від 8 до 20 символів',
            'new_password.confirmed' => 'Підтвердження паролю не співпадає',
        ];
    }
}
