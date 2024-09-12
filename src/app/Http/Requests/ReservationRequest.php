<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ReservationRequest extends FormRequest
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
            'date' => ['required', 'date', function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->isPast()) {
                    $fail('※予約日は過去の日付を指定できません。');
                }
            }],
            'time' => ['required', 'date_format:H:i'],
            'number_of_people' => ['required', 'integer', 'min:1']
        ];
    }
}
