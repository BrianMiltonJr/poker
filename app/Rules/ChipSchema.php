<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ChipSchema implements Rule
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
    public function passes($attribute, $bundle)
    {
        $types = [
            'color', 'denomination', 'amount'
        ];
        foreach ($bundle as $value) {
            foreach ($types as $type) {
                if (!array_key_exists($type, $value) || gettype($value[$type]) !== 'string') {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'We could not accept the chip format.';
    }
}
