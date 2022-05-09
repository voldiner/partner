<?php

namespace App\Actions\Fortify;

use App\Mail\UserRegisterMessageForAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $messages = [
            'email.required' => 'Потрібно вказати email адресу!',
            'password_fxp.exists' => 'Реєстраційний ключ введено невірно'
        ];

        Validator::make($input, [
            'password_fxp' => ['required', 'string', 'max:100', 'exists:users'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'terms' => [
                'required',
                Rule::in(['agree']),
            ],
        ], $messages)->validate();

        // --- моя логіка створення користувача
        $user = User::where('password_fxp', $input['password_fxp'])->first();
        $user->update([
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        $logMessage = 'User ' . $user->name . ' has successfully registered ID - ' . $user->id;

        Log::channel('register')->debug($logMessage);

        Mail::send(new UserRegisterMessageForAdmin($user->name, $user->id));

        return $user;
    }
}
