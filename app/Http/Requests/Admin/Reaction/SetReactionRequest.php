<?php

namespace App\Http\Requests\Admin\Reaction;

use Illuminate\Foundation\Http\FormRequest;

class SetReactionRequest extends FormRequest
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
            'type' => 'required|boolean',
            'idea_id' => 'required|exists:ideas,id',
        ];
    }
}
