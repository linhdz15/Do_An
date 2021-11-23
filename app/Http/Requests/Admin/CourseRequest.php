<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
                Rule::unique('courses', 'title')->ignore($this->course->id ?? null),
            ],
            'slug' => [
                'required',
                'alpha_dash',
                'min:2',
                'max:100',
                Rule::unique('courses', 'slug')->ignore($this->course->id ?? null),
            ],
            'description' => [ 'nullable'],
            'banner' => ['nullable', 'mimes:' . config('image.types'), 'max:' . config('image.max_size')],
            'status' => ['nullable', Rule::in([Course::ACTIVE, Course::DISABLE])],
            'seo_title' => 'nullable|max:255',
            'seo_description' => 'nullable|max:500',
            'seo_keywords' => 'nullable|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'chapter_id' => 'nullable|exists:chapters,id',
            'lesson_id' => 'nullable|exists:lessons,id',
            'editor_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => __('Tiêu đề đã tồn tại'),
        ];
    }
}
