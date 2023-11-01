<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PisValidationRules implements Rule
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
        // Remover caracteres não numéricos
        $value = preg_replace('/[^0-9]/', '', $value);

        if ($value == "") {
            return true;
        }

        // Verificar se o PIS possui 11 dígitos
        if (strlen($value) !== 11) {
            return false;
        }

        // Calcular o dígito verificador
        $weights = [3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 10; $i++) {
            $sum += $weights[$i] * $value[$i];
        }

        $remainder = $sum % 11;
        $digit = 11 - $remainder;

        if ($digit == 10 || $digit == 11) {
            $digit = 0;
        }

        return (int)$value[10] == $digit;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo :attribute não é um PIS/PASEB válido.';
    }
}
