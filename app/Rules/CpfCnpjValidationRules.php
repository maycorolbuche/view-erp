<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfCnpjValidationRules implements Rule
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
        $value = preg_replace('/[^0-9]/', '', $value);

        if ($value == "") {
            return true;
        } elseif (strlen($value) === 11) {
            return $this->validateCPF($value);
        } elseif (strlen($value) === 14) {
            return $this->validateCNPJ($value);
        }

        return false;
    }

    public function validateCPF($value)
    {
        // Remover caracteres não numéricos
        $value = preg_replace('/[^0-9]/', '', $value);

        // Verificar se o CPF possui 11 dígitos
        if (strlen($value) !== 11) {
            return false;
        }

        // Verificar CPFs com todos os dígitos iguais (111.111.111-11, 222.222.222-22, etc)
        if (preg_match('/^(\d)\1*$/', $value)) {
            return false;
        }

        // Validar dígito verificador 1
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $value[$i] * (10 - $i);
        }
        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        // Verificar dígito verificador 1
        if ($value[9] != $digit1) {
            return false;
        }

        // Validar dígito verificador 2
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $value[$i] * (11 - $i);
        }
        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        // Verificar dígito verificador 2
        if ($value[10] != $digit2) {
            return false;
        }

        return true;
    }

    public function validateCNPJ($value)
    {
        // Remover caracteres não numéricos
        $value = preg_replace('/[^0-9]/', '', $value);

        // Verificar se o CNPJ possui 14 dígitos
        if (strlen($value) !== 14) {
            return false;
        }

        // Validar dígitos verificadores
        $digits = str_split($value);
        $size = count($digits);

        $sum = 0;
        $position = 5;
        for ($i = 0; $i < $size - 2; $i++) {
            $sum += $digits[$i] * $position;
            $position--;
            if ($position < 2) {
                $position = 9;
            }
        }

        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($digits[12] != $digit1) {
            return false;
        }

        $sum = 0;
        $position = 6;
        for ($i = 0; $i < $size - 1; $i++) {
            $sum += $digits[$i] * $position;
            $position--;
            if ($position < 2) {
                $position = 9;
            }
        }

        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($digits[13] != $digit2) {
            return false;
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
        return 'O campo :attribute não é um CPF ou CNPJ válido.';
    }
}
