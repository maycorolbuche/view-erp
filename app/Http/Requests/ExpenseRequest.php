<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use App\Models\Authorization;

class ExpenseRequest extends FormRequest
{

    public function __construct(ValidationFactory $validationFactory, Request $request)
    {

        $validationFactory->extend(
            'date_authorization',
            function ($attribute, $value, $parameters) use ($request) {
                $date = $request->input('date');
                $count = Authorization::where('id_authorization', $request->input('id_authorization'))
                    ->whereDate('start_datetime', '<=', $date)
                    ->whereDate('end_datetime', '>=', $date)
                    ->count();
                return $count > 0;
            },
            "A data da despesa deve estar dentro do período autorizado"
        );

        $validationFactory->extend(
            'sum_expenses_clients',
            function ($attribute, $value, $parameters) use ($request) {
                $authorization = Authorization::where('id_authorization', $request->input('id_authorization'))
                    ->with('clients')->first();

                $clients = $authorization->clients->pluck('id_client')->toArray();

                $request['client_amount'] = array_intersect_key($request->input('client_amount'), array_flip($clients));

                $total_amount = round(array_sum(array_map('floatval', $request->client_amount)), 2);

                return $request->amount == $total_amount;
            },
            "A soma dos valores dos clientes deve ser igual ao valor da despesa"
        );

        $validationFactory->extend(
            'sum_expenses_users',
            function ($attribute, $value, $parameters) use ($request) {
                $total_amount = round(array_sum(array_map('floatval', $request->user_amount)), 2);

                return $request->amount == $total_amount;
            },
            "A soma dos valores dos usuários deve ser igual ao valor da despesa"
        );
    }

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
            'date' => ['required', 'date_authorization'],
            'amount' => ['required', 'sum_expenses_clients', 'sum_expenses_users'],
            'file' => 'file|max:20480|mimes:jpg,jpeg,png,pdf'
        ];
    }

    public function attributes()
    {
        return [
            'id_authorization' => 'autorização',
            'id_category' => 'categoria',
            'id_payment_method' => 'tipo de pagamento',
            'date' => 'data|date_within_authorization',
            'amount' => 'valor',
            'file' => 'arquivo'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_user' => Auth::id(),
        ]);
    }
}
