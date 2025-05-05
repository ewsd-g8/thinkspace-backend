<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH'),
            'email' => 'required|email|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH') . '|unique:users,email,' . $this->route('user')->id,
            'mobile' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|phone:MM|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH') . '|unique:users,mobile,' . $this->route('user')->id,
            'profile' => 'nullable|mimes:jpeg,png,jpg,gif',
            'roles' => 'required'
        ];
    }
}
