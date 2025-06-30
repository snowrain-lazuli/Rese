<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'area' => 'required|string|max:100',
            'genre' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '画像ファイルをアップロードしてください',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => '画像は jpeg, png, jpg, gif 形式で指定してください。',
            'image.max' => '画像サイズは2MB以下にしてください。',
            'name.required' => 'ショップ名は必須です。',
            'name.max' => 'ショップ名は255文字以内で入力してください。',
            'area.required' => 'エリアは必須です。',
            'area.max' => 'エリアは100文字以内で入力してください。',
            'genre.required' => 'ジャンルは必須です。',
            'genre.max' => 'ジャンルは100文字以内で入力してください。',
            'description.required' => '店舗情報は必須です。',
            'description.max' => '店舗情報は1000文字以内で入力してください。',
        ];
    }
}