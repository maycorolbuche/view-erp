<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayRequest extends FormRequest
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
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->input('type') == "easter") {
            $day = null;
            $month = null;
            $year = null;
            $easter = $this->input('easter');
        } else {
            $date = explode("-", $this->input('date'));

            $day = $date[2];
            $month = $date[1];
            $year = $this->input('type') == "repeat" ? null : $date[0];
            $easter = null;
        }

        $this->merge([
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'easter' => $easter,
        ]);
    }
}
