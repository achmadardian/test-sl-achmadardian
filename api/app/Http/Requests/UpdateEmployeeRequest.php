<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|unique:employees,email',
            'hired_at' => 'nullable|date_format:Y-m-d',
            'ended_at' => 'nullable|date_format:Y-m-d',
            'position_id' => 'nullable|int|exists:positions,id'
        ];
    }
}
