<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExpenseRequest extends FormRequest
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
            'id_authorization' => 'required',
            'id_category' => 'required',
            'id_payment_method' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'id_authorization' => 'autorização',
            'id_category' => 'categoria',
            'id_payment_method' => 'tipo de pagamento',
            'date' => 'data',
            'amount' => 'valor',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_user' => Auth::id(),
        ]);
    }
}
