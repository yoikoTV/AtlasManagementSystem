<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'post_id' => ['required', 'exists:posts,id'],
            'comment' => ['required', 'max:250', 'string']
        ];
    }

    public function messages()
    {
        return [
            'post_id.required' => '投稿先が見つかりませんでした。',
            'post_id.exists' => '選択された投稿は存在しません。',
            'comment.required' => 'コメントは必ず入力してください。',
            'comment.max' => '250文字以内で入力してください。',
            'comment.string' => 'コメントは文字列のみ有効です。'
        ];
    }
}
