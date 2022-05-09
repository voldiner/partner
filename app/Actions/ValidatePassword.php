<?php

namespace App\Actions;
use Illuminate\Validation\Rules\Password as Password;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Illuminate\Support\Facades\Validator;

class ValidatePassword extends Password
{
    public function passes($attribute, $value)
    {
        $this->messages = [];

        $validator = Validator::make(
            $this->data,
            [$attribute => array_merge(['string', 'min:'.$this->min], $this->customRules)],
            $this->validator->customMessages,
            $this->validator->customAttributes
        )->after(function ($validator) use ($attribute, $value) {
            if (! is_string($value)) {
                return;
            }

            $value = (string) $value;

            if ($this->mixedCase && ! preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/u', $value)) {
                $validator->errors()->add($attribute, ' Цей :attribute повинен містити хоча б одну велику і одну малу букву.');
            }

            if ($this->letters && ! preg_match('/\pL/u', $value)) {
                $validator->errors()->add($attribute, 'Цей :attribute повинен містити хоча б одну букву.');
            }

            if ($this->symbols && ! preg_match('/\p{Z}|\p{S}|\p{P}/u', $value)) {
                $validator->errors()->add($attribute, 'The :attribute must contain at least one symbol.');
            }

            if ($this->numbers && ! preg_match('/\pN/u', $value)) {
                $validator->errors()->add($attribute, 'Цей :attribute повинен містити хоча б одну цифру.');
            }
        });

        if ($validator->fails()) {
            return $this->fail($validator->messages()->all());
        }

        if ($this->uncompromised && ! Container::getInstance()->make(UncompromisedVerifier::class)->verify([
                'value' => $value,
                'threshold' => $this->compromisedThreshold,
            ])) {
            return $this->fail(
                'The given :attribute has appeared in a data leak. Please choose a different :attribute.'
            );
        }

        return true;
    }


}