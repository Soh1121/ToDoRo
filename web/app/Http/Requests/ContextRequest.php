<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContextRequest extends FormRequest
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
            'context_id' => 'integer',
            'name' => 'required|max:30',
        ];
    }

    /**
     * エラーメッセージのカスタマイズ
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'コンテキスト名を入力してください',
            'name.max' => 'コンテキスト名は30文字以内で入力してください',
        ];
    }
}
