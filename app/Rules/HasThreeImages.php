<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasThreeImages implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): void $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Must be an array
        if (!is_array($value)) {
            $fail('The :attribute field must be an array of images.');
            return;
        }

        // Filter out null entries
        $nonNullImages = array_filter($value, function ($item) {
            return !is_null($item);
        });

        // Check count
        if (count($nonNullImages) !== 3) {
            $fail('You must upload exactly 3 images.');
        }
    }
}
