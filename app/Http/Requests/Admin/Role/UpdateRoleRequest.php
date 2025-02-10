<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required|regex:/^[\p{Lu}\p{Ll}\p{Nd}\p{Myanmar}]+$/u|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH') . '|unique:roles,name,' . $this->route('role')->id,
            'permission' => 'required',
        ];
    }
}
