<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Question;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('questions', 'title')->ignore($this->question->id ?? null),
            ],
            'slug' => [
                'required',
                'alpha_dash',
                'min:2',
                'max:100',
                Rule::unique('questions', 'slug')->ignore($this->question->id ?? null),
            ],
            'content' => [ 'required', 'max:7000'],
            'reason' => [ 'required'],
            'curriculum_id' => [ 'required', 'exists:curriculums,id'],
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => __('Tiêu đề đã tồn tại'),
        ];
    }
}
