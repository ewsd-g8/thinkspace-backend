<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH'),
            'email' => 'required|email|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH') . '|unique:users,email',
            'mobile' => 'nullable|unique:users,mobile|regex:/^([0-9\s\-\+\(\)]*)$/|phone:MM|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH'),
            'password' => 'required|string|same:password_confirmation|min:6|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH'),
            'profile' => 'nullable|mimes:jpeg,png,jpg,gif',
            'roles' => 'required'
        ];
    }
}
