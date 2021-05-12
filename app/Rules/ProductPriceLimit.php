<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductPriceLimit implements Rule
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
        $data = $value <=460;
        $data = $value >=0;
        
         return $data;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'the :attribute must range from 250 to GHC 450.';
    }
}
