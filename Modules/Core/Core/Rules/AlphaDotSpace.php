<?php

namespace Modules\Core\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphaDotSpace implements ValidationRule
{
	/**
     * Run the validation rule.
     */

	public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[A-Za-z\s\.]+$/u', $value) > 0) {
            $fail('The :attribute may only contain letters, dots, spaces.');
        }
    }

}