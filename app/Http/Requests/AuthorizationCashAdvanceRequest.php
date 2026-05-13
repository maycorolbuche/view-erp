<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AuthorizationType;

class AuthorizationCashAdvanceRequest extends FormRequest
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
            'id_authorization_parent' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'id_authorization_parent' => 'autorização da despesa',
            'amount' => 'valor',
            'description' => 'motivo da solicitação',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_user' => auth()->id(),
            'self' => true,
            'start_datetime' => date('Y-m-d') . ' 00:00:00',
            'end_datetime' => date('Y-m-d') . ' 23:59:59'
        ]);

        $authorization_type = AuthorizationType::where('type', 'cash-advance')->select('id_authorization_type')->pluck('id_authorization_type')->toArray();
        if (count($authorization_type) > 0) {
            $this->merge(['id_authorization_type' => $authorization_type[0]]);
        }
    }
}
