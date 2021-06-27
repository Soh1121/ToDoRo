<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'id' => 'integer',
            'name' => 'required|max:140',
            'project_id' => 'integer',
            'context_id' => 'integer',
            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'term' => 'integer|between:0,99',
            'timer' => 'integer',
            'repeat_id' => 'integer',
            'priority_id' => 'integer|between:1,5',
        ];
    }

    /**
     * エラーメッセージのカスタマイズ
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'タスク名を入力してください',
            'start_date.required' => '開始日を入力してください',
            'due_date.required' => '終了日を入力してください',
            'name.max' => 'タスク名には140文字以下の文字列を指定してください',
            'start_date.before_or_equal' => '開始日は終了日以前を選択してください',
            'due_date.after_or_equal' => '終了日は開始日以後を選択してください',
        ];
    }
}
