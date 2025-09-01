<?php

namespace Modules\Core\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SignedDecimal implements ValidationRule
{
    /**
     * Pattern: optional sign, digits, optional fractional part with at least one digit.
     * Examples that pass: -12.34, +7, 0.5, 42, -0
     * Examples that fail: .5, 5., +, -, 1e3, 12,34
     */
    private const REGEX = '/^[+-]?\d+(?:\.\d+)?$/';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Normalize strings (common in form inputs)
        if (is_string($value)) {
            $value = trim($value);
        }

        // Allow ints/floats directly (e.g. programmatic input), but reject INF/NAN
        if (is_int($value) || is_float($value)) {
            if (is_finite((float) $value)) {
                return; // valid
            }
            $fail("The :attribute must be a signed decimal number.");
            return;
        }

        // Everything else must match the decimal regex
        if (!is_scalar($value) || !preg_match(self::REGEX, (string) $value)) {
            $fail("The :attribute must be a signed decimal number.");
        }
    }
}
