<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class SystemRequest extends FormRequest
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
            'slug' => 'required|unique:systems,slug,' . $this->_id . ',id_system',
            'name' => 'required',
            'icon' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'slug' => 'nome url',
            'name' => 'nome',
            'icon' => 'ícone'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug(strtolower($this->input('slug'))),
        ]);
    }
}
