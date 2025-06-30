<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;
use App\Models\Reservation;

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
            'date'   => ['required', 'date', 'date_format:Y-m-d'],
            'time'   => ['required', 'date_format:H:i'],
            'number' => ['required', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $date = $this->input('date');
            $time = $this->input('time');

            if ($date && $time) {
                try {
                    $dt = Carbon::createFromFormat('Y-m-d H:i', "$date $time");
                    if ($dt->lt(now())) {
                        $validator->errors()->add('date', '過去の日時は選択できません。');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('date', '日付・時間の形式が不正です。');
                }

                $userId = auth()->id();
                $reservationId = $this->route('id');

                $query = Reservation::where('user_id', $userId)
                    ->where('reserved_date', $date)
                    ->whereTime('reserved_time', '=', $time . ':00');

                if ($reservationId) {
                    $query->where('id', '<>', $reservationId);
                }

                $duplicate = $query->exists();

                if ($duplicate) {
                    $validator->errors()->add('date', 'この日時ではすでに予約を登録済みです。別の時間を選んでください。');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'date.required'        => '日付を選択してください。',
            'date.date'            => '有効な日付を入力してください。',
            'date.date_format'     => '日付は「YYYY-MM-DD」形式で入力してください。',
            'date.unique_datetime' => '指定された日時はすでに予約済みです。別の日時を選択してください。',
            'time.required'        => '時間を選択してください。',
            'time.date_format'     => '時間は「HH:MM」形式で入力してください。',
            'number.required'      => '人数を入力してください。',
            'number.integer'       => '人数は数字で入力してください。',
            'number.min'           => '人数は1人以上で指定してください。',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'date'   => $this->input('reserved_date', $this->input('date')),
            'time'   => $this->input('reserved_time', $this->input('time')),
            'number' => $this->input('number_of_people', $this->input('number')),
        ]);
    }
}