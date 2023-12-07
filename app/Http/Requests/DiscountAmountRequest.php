<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountAmountRequest extends FormRequest
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
            'date' => [
                'required',
                Rule::unique('discounts_amounts')->where(function ($query) {
                    return $query->where('id_discount', $this->route('pid'))
                        ->where('date', $this->input('date'));
                })->ignore($this->_id, 'id_discount_amount'),

            ],
            'amount' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'data inicial',
            'amount' => 'valor',
        ];
    }
}
