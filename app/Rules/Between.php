<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Between implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private float $min ,private  float $max)
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
        return ($this->min <= (float) $value )&&( (float) $value <= $this->max);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute  must be between '.$this->min .' and '.$this->max.' .';
    }
}
