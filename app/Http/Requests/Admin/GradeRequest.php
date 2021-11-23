<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
            'type.required' => __('request.admin.grade.type.required'),
            'seo_title' => 'max:255',
            'seo_keywords' => 'max:255',
            'seo_description' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('request.admin.chapter.title.required'),
            'title.min' => __('request.admin.chapter.title.min'),
            'title.max' => __('request.admin.chapter.title.max'),
            'banner.mimes' => __('request.admin.chapter.banner.mimes'),
            'banner.max' => __('request.admin.chapter.banner.max'),
            'status.required' => __('request.admin.chapter.status.required'),
            'type.required' => __('request.admin.grade.type.required'),
            'seo_title.max' => __('request.admin.chapter.seo_title.max'),
            'seo_keywords.max' => __('request.admin.chapter.seo_keywords.max'),
            'seo_description.max' => __('request.admin.chapter.seo_description.max'),
        ];
    }
}
