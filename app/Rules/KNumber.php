<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class KNumber implements Rule
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
        if((strpos($value, 'k') === 0 || strpos($value, 'K') === 0) && strlen($value) == 8 && $this->countDigits($value) ==7)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'K number must start with k or K and must have a length of 8 characters.';
    }

    private function countDigits($str)
    {
        return preg_match_all( "/[0-9]/", $str );
    }
}
