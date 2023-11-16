<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationExpenseRequest extends FormRequest
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
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'id_client' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'start_date' => 'data inicial',
            'end_date' => 'data final',
            'description' => 'motivo da solicitação',
            'id_client' => 'clientes envolvidos',
        ];
    }
}
