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
        $reservedWords = ['data', 'logout', 'login', 'password'];

        return [
            'slug' => [
                'required',
                'unique:systems,slug,' . $this->_id . ',id_system',
                'not_in:' . implode(',', $reservedWords),
            ],
            'name' => 'required',
            'icon' => 'required',
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

    public function messages()
    {
        return [
            'slug.not_in' => 'A palavra ":input" é reservada, e não pode ser usada no campo :attribute'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug(strtolower($this->input('slug'))),
        ]);
    }
}
