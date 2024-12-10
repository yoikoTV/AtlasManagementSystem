<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'mail_address' => 'required|email|unique:users,mail_address',
            'sex' => 'required|in:1,2,3',
            'old_year' => 'require|integer|max:2000',
            'old_month' => 'required|integer|max:12',
            'old_day' => 'required|integer|max:31',
            'role' => 'required|in:1,2,3',
            'password' => 'required|min:8|max:30|confirmed'
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $year = $this->input('old_year');
            $month = str_pad($this->input('old_month'), 2, '0', STR_PAD_LEFT);
            $day = str_pad($this->input('old_day'), 2, '0', STR_PAD_LEFT);

            // 結合して日付文字列を作成
            $dateString = "{$year}-{$month}-{$day}";

            // 入力された日付が2000年1月1日以降で、今日以前であることを確認
            $minDate = '2000-01-01'; // 2000年1月1日
            $maxDate = now()->toDateString(); // 今日の日付（YYYY-MM-DD形式）

            // 日付が有効かどうかをチェック
            try {
                Carbon::parse($dateString); // 無効な日付の場合、例外が発生する
            } catch (\Exception $e) {
                $validator->errors()->add('date', '無効な日付です。');
            }
        });
    }
}
