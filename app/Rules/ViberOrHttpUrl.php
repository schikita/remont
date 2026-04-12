<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Laravel/Filament: raw closures in Filament {@see \Filament\Forms\Components\Concerns\CanBeValidated}
 * are evaluated as Filament closures; use a {@see ValidationRule} object instead.
 */
class ViberOrHttpUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (blank($value)) {
            return;
        }

        $v = trim((string) $value);

        if (str_starts_with(strtolower($v), 'viber://')) {
            if (! preg_match('/^viber:\/\/\S+$/i', $v)) {
                $fail('Укажите корректную ссылку Viber (viber://…).');
            }

            return;
        }

        if (filter_var($v, FILTER_VALIDATE_URL) === false) {
            $fail(__('validation.url'));
        }
    }
}
