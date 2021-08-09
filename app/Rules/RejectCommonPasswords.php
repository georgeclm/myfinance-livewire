<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RejectCommonPasswords implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !in_array($value, [
            '123456789',
            'password',
            'test123456',
            'Password',
            'picture1',
            '12345678',
            '111111111',
            '11111111',
            '1234567890',
            'iloveyou',
            'qwertyuiop',
            'qwer123456'
        ]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Common Password usage is not allowed.';
    }
}
