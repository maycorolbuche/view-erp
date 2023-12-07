<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BatchRequest extends FormRequest
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
            'expense' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'expense' => 'despesas',
        ];
    }

    public function messages()
    {
        return [
            'expense.required' => 'Selecione as despesas para geração do lote.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_user' => Auth::id(),
            'datetime' => date("Y-m-d H:i:s"),
            'expense' => array_keys($this->expense ?? []),
        ]);
    }
}
