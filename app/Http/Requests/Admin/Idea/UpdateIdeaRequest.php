<?php

namespace App\Http\Requests\Admin\Idea;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIdeaRequest extends FormRequest
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
            'title' => 'required|string',
            'content' => 'required|string',
            'closure_id' => 'required|exists:closures,id',
            'user_id' => 'required|exists:users,id',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}
