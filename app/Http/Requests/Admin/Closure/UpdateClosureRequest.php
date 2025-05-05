<?php

namespace App\Http\Requests\Admin\Closure;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClosureRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique('closures', 'name')->ignore($this->route('closure')),
            ],
            'date' => 'required|date|after_or_equal:today',
            'final_date' => 'required|date|after:date',
        ];
    }
}
