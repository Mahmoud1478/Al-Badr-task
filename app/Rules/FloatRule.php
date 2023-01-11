<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FloatRule implements Rule
{
    private string $attribute;
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
        $this->attribute = $attribute;
        return preg_match('/-?\d+(\.\d+)?/',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be float number';
    }
}
