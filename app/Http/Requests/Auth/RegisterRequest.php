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
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'mail_address' => 'required|email|unique:users,mail_address',
            'sex' => 'required|in:1,2,3',
            'old_year' => 'required|min:2000',
            'old_month' => 'required',
            'old_day' => 'required',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|min:8|max:30|confirmed'
        ];
    }


    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!checkdate($this->input('old_month'), $this->input('old_day'), $this->input('old_year'))) {
                $validator->errors()->add('birthday_day', '正しい日付を入力してください');
            }

            $birthdate = Carbon::createFromDate($this->input('old_year'), $this->input('old_month'), $this->input('old_day'));

            if ($birthdate->isFuture()) {
                $validator->errors()->add('birthday_day', '誕生日は未来の日付にはできません');
            }
        });
    }

    public function messages(): array
    {
        return [
            'over_name.required' => '姓は必須です。',
            'over_name.string' => '姓は文字のみ有効です。',
            'over_name.max' => '姓は10文字以内で入力してください。',

            'under_name.required' => '名は必須です。',
            'under_name.string' => '名は文字のみ有効です。',
            'under_name.max' => '名は10文字以内で入力してください。',

            'over_name_kana.required' => 'セイは必須です。',
            'over_name_kana.string' => 'セイは文字のみ有効です。',
            'over_name_kana.max' => 'セイは30文字以内で入力してください。',
            'over_name_kana.regex' => 'セイはカタカナで入力してください。',

            'under_name_kana.required' => 'メイは必須です。',
            'under_name_kana.string' => 'メイは文字のみ有効です。',
            'under_name_kana.max' => 'メイは30文字以内で入力してください。',
            'under_name_kana.regex' => 'メイはカタカナで入力してください。',

            'mail_address.required' => 'メールアドレスは必須です。',
            'mail_address.email' => '正しいメールアドレスを入力してください。',
            'mail_address.unique' => 'このメールアドレスは既に使われています。',

            'sex.required' => '性別は必須です。',
            'sex.in' => '性別はいずれかを選択してください。',

            'old_year.required' => '年は必須です。',
            'old_year.min' => '2000年以降で入力してください。',
            'old_month.required' => '月は必須です。',
            'old_day.required' => '日は必須です。',

            'role.required' => '役職は必須項目です。',
            'role.in' => '役職はいずれかを選択してください。',

            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは８文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以内で入力してください。',
            'password.confirmed' => 'パスワードが正しくありません。'
        ];
    }
}
