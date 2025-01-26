<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
      'main_category_id' => 'required|exists:main_categories,id',
      'sub_category_name' => 'required|max:100|string|unique:sub_categories,sub_category'
    ];
  }

  public function messages()
  {
    return [
      'main_category_id.required' => 'メインカテゴリーは必須項目です。',
      'main_category_id.exists' => '存在しないメインカテゴリーです。',
      'sub_category_name.required' => 'サブカテゴリーの名前は必須です。',
      'sub_category_name.string' => 'サブカテゴリーは文字列のみ有効です。',
      'sub_category_name.max' => '100文字以内で入力してください。',
      'sub_category_name.unique' => '既に存在しているサブカテゴリーです。'
    ];
  }
}
