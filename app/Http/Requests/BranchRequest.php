<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'name' => 'required',
            'short_name' => [
                'required',
                'unique:branches,short_name,' . $this->_id . ',id_branch',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'short_name' => 'nome abreviado',
        ];
    }
}
