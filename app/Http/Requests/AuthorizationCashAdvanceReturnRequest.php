<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AuthorizationType;
use App\Models\UserCash;

class AuthorizationCashAdvanceReturnRequest extends FormRequest
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
        $max_amount = UserCash::where('id_user', auth()->id())->sum('amount');

        return [
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $max_amount,
            ],
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'amount' => 'valor',
            'description' => 'motivo da devolução',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_user' => auth()->id(),
            'self' => true,
            'start_datetime' => date('Y-m-d') . ' 00:00:00',
            'end_datetime' => date('Y-m-d') . ' 23:59:59',
        ]);

        $authorization_type = AuthorizationType::where('type', 'cash-advance-return')->select('id_authorization_type')->pluck('id_authorization_type')->toArray();
        if (count($authorization_type) > 0) {
            $this->merge(['id_authorization_type' => $authorization_type[0]]);
        }
    }
}
