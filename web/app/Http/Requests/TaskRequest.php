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
            'start_date' => 'date|before_or_equal:due_date',
            'due_date' => 'date|after_or_equal:start_date',
            'term' => 'integer|between:0,99',
            'timer' => 'integer',
            'repeat_id' => 'integer',
            'priority' => 'integer|between:0,4',
        ];
    }
}
