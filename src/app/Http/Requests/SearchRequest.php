<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Shop;

class SearchRequest extends FormRequest
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
        $validAreas = Shop::select('area')->distinct()->pluck('area')->toArray();
        $validGenres = Shop::select('genre')->distinct()->pluck('genre')->toArray();

        return [
            'area' => 'nullable', Rule::in($validAreas),
            'genre' => 'nullable', Rule::in($validGenres),
            'keyword' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'area.in' => 'エリアは候補内から選択してください',
            'genre.in' => 'ジャンルは候補内から選択してください',
            'keyword.string' => 'キーワードは文字列で入力してください',
            'keyword.max' => 'キーワードは255文字以内で入力してください',
        ];
    }
}