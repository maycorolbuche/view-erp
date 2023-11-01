<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfCnpjValidationRules;
use App\Rules\PisValidationRules;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_employment_type' => 'required',
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email,' . $this->_id . ',id_user'],
            'cpf_or_cnpj' => ['nullable', 'unique:users,cpf_or_cnpj,' . $this->_id . ',id_user', new CpfCnpjValidationRules],
            'id_card' => ['nullable', 'unique:users,id_card,' . $this->_id . ',id_user'],
            'pis' => ['nullable', 'unique:users,pis,' . $this->_id . ',id_user', new PisValidationRules],
        ];
    }

    public function attributes()
    {
        return [
            'id_employment_type' => 'tipo de recurso',
            'name' => 'nome',
            'email' => 'e-mail',
            'cpf_or_cnpj' => 'CPF/CNPJ',
            'id_card' => 'RG',
            'pis' => 'PIS/PASEB',
        ];
    }

}
