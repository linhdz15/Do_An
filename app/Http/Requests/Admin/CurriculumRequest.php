<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Curriculum;
use Illuminate\Validation\Rule;

class CurriculumRequest extends FormRequest
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
                Rule::unique('curriculums', 'title')->ignore($this->curriculum->id ?? null),
            ],
            'slug' => [
                'required',
                'alpha_dash',
                'min:2',
                'max:100',
                Rule::unique('curriculums', 'slug')->ignore($this->curriculum->id ?? null),
            ],
            'description' => [ 'nullable'],
            'time' => 'numeric',
            'score' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => __('Tiêu đề đã tồn tại'),
        ];
    }
}
