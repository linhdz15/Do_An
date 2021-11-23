<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'banner' => 'nullable|mimes:' . config('image.types') . '|max:' .  config('image.max_size'),
            'status' => 'required',
            'chapter_id' => 'required|exists:chapters,id',
            'seo_title' => 'max:255',
            'seo_keywords' => 'max:255',
            'seo_description' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('request.admin.lesson.title.required'),
            'title.min' => __('request.admin.lesson.title.min'),
            'title.max' => __('request.admin.lesson.title.max'),
            'banner.mimes' => __('request.admin.lesson.banner.mimes'),
            'banner.max' => __('request.admin.lesson.banner.max'),
            'chapter_id.required' => __('request.admin.lesson.chapter_id.required'),
            'chapter_id.exists' => __('request.admin.lesson.chapter_id.exists'),
            'seo_title.max' => __('request.admin.lesson.seo_title.max'),
            'seo_keywords.max' => __('request.admin.lesson.seo_keywords.max'),
            'seo_description.max' => __('request.admin.lesson.seo_description.max'),
        ];
    }
}
