<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;
use App\Actions\ValidatePassword as PasswordL;
trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required',
                'string',
                new Password,
                'confirmed',
                PasswordL::min(8)->letters()->mixedCase()->numbers(),
        ];
    }
}
