<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EGPhoneRule implements Rule
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
    public function passes($attribute, $value): bool
    {
        return preg_match('/\(?(\+2)?0\)?(-|\s)?1\d{2}(-|\s)?\d{3}(-|\s)?\d{4}/',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'phone number is invalid';
    }
}
