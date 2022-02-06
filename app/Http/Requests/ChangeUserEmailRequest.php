<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeUserEmailRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required|current_password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Ведіть нову адресу електронної пошти',
            'email.email' => 'Неправильна адреса електронної пошти',
            'email.unique' => 'Вказана адреса електронної пошти вже існує',
            'password.current_password' => 'Неправильний пароль',
        ];
    }
}
