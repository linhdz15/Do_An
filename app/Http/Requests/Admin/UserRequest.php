<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user = request()->user;
        $idEdit = is_null($user) ? false : true;
        
        $roles = [
            User::ADMIN,
            User::NORMAL_USER,
            User::EDITOR,
        ];

        return [
            'name' => 'required|min:3|max:255',
            'email' => $idEdit ? 'nullable' : 'required|email|unique:users',
            'role' => 'required|in:' . implode(',', $roles),
            'password' => $idEdit ? 'nullable' : 'required|confirmed|min:6'
        ];
    }
}
