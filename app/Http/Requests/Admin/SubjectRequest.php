<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'seo_title' => 'max:255',
            'seo_keywords' => 'max:255',
            'seo_description' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('request.admin.subject.title.required'),
            'title.min' => __('request.admin.subject.title.min'),
            'title.max' => __('request.admin.subject.title.max'),
            'banner.mimes' => __('request.admin.subject.banner.mimes'),
            'banner.max' => __('request.admin.subject.banner.max'),
            'status.required' => __('request.admin.subject.status.required'),
            'seo_title.max' => __('request.admin.subject.seo_title.max'),
            'seo_keywords.max' => __('request.admin.subject.seo_keywords.max'),
            'seo_description.max' => __('request.admin.subject.seo_description.max'),
        ];
    }
}
