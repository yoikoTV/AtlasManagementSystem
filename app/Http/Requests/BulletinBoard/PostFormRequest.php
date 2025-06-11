<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
        //編集のバリデーショn
        if ($this->isMethod('post') && $this->routeIs('post.edit')) {
            return [
                'post_title' => 'required|min:4|string|max:50',
                'post_body' => 'nullable|min:10|string|max:5000',
            ];
        }

        // 新規投稿のバリデーショn
        return [
            'post_category_id' => 'required|exists:main_categories,id',
            'post_title' => 'required|min:4|string|max:50',
            'post_body' => 'required|min:10|string|max:5000'
        ];
    }

    public function messages()
    {
        return [
            'post_category_id.required' => 'カテゴリーの選択は必須です。',
            'post_title.required' => 'タイトルは必ず入力してください。',
            'post_title.string' => 'タイトルは文字列のみ有効です。',
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.string' => '内容は文字列のみ有効です。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は5000文字です。',
        ];
    }
}
