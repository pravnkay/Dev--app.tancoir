<?php

namespace Modules\Core\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphaNumDotSpaceSlash implements ValidationRule
{
	/**
     * Run the validation rule.
     */

	public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[A-Za-z0-9\.\s\/]+$/u', $value) > 0) {
            $fail('The :attribute may only contain letters, numbers, dots, spaces and slashes.');
        }
    }
}