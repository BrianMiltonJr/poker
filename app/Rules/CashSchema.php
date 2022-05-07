<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CashSchema implements Rule
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
        $denominations =[
            ".25",
            "1",
            "5",
            "10",
            "20",
            "50",
            "100"
        ];

        $final = [];

        foreach ($denominations as $denomination) {
            if (!array_key_exists($denomination, $bundle)) {
                return false;
            }

            if ($bundle[$denomination] > 0) {
                $final[$denomination] = $bundle[$denomination];
            }
        }

        $chipsToHandOut = $bundle['chips-to-handout'];

        $types = [
            'color', 'denomination', 'amount'
        ];
        foreach ($types as $type) {
            if (!array_key_exists($type, $chipsToHandOut) || gettype($chipsToHandOut[$type]) !== 'integer') {
                return false;
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
        return 'You are using an insufficient Cash Schema';
    }
}
