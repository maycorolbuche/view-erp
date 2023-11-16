<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\AuthorizationType;

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

    protected function prepareForValidation()
    {
        $this->merge([
            'id_user' => Auth::id(),
            'self' => true,
            'start_datetime' => $this->start_date . ' 00:00:00',
            'end_datetime' => $this->end_date . ' 23:59:59'
        ]);

        $authorization_type = AuthorizationType::where('type', 'expense')->select('id_authorization_type')->pluck('id_authorization_type')->toArray();
        if (count($authorization_type) > 0) {
            $this->merge(['id_authorization_type' => $authorization_type[0]]);
        }
    }
}
