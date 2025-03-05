<?php

namespace App\Http\Requests\Admin\ReportType;

use Illuminate\Foundation\Http\FormRequest;

class CreateReportTypeRequest extends FormRequest
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
            'name' => 'required|string|unique:report_types,name',
            'description' => 'required|string',
        ];
    }
}
