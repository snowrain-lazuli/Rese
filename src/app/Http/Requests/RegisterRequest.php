<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required | email | unique:users,email',
            'password' => 'required | string | min:8 | not_in:Password123!',
        ];
    }
    /**
     *  バリデーション項目名定義
     * @return array
     */

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力して下さい。',
            'name.unique' => 'その名前はすでに使用されています。',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.unique' => 'そのメールアドレスはすでに使用されています',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.not_in' => '入力されたパスワードは脆弱性が高いです。別のパスワードを使用してください'
        ];
    }
}