<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $format = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($format, $value)->first();
        if (!$user) {
            $fail("The $attribute you entered is invalid.");
        }
    }
}
