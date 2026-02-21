<?php

namespace App\Http\Requests\V1\Car;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            'client_id' => ['sometimes', 'integer', 'exists:clients,id'],
            'model' => ['sometimes', 'string', 'min:1', 'max:255'],
            'brand' => ['sometimes', 'string', 'min:1', 'max:255'],
            'year' => ['sometimes', 'integer', 'min:1901', 'max:' . min(date('Y') + 1, 2155)],
        ];
    }
}
