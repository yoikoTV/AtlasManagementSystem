<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryFormRequest extends FormRequest
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
      'main_category_name' => 'required|max:100|string|unique:main_categories,main_category',
    ];
  }

  public function messages()
  {
    return [
      'main_category_name.required' => 'メインカテゴリーの名前は必須です。',
      'main_category_name.string' => 'メインカテゴリーは文字列のみ有効です。',
      'main_category_name.max' => '100文字以内で入力してください。',
      'main_category_name.unique' => '既に存在しているメインカテゴリーです。',
    ];
  }
}
