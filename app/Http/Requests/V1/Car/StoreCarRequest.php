<?php

namespace App\Http\Requests\V1\Car;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this['client_id'] = $this->integer('clientId');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'model' => ['required', 'string', 'min:1', 'max:255'],
            'brand' => ['required', 'string', 'min:1', 'max:255'],
            'year' => ['required', 'integer', 'min:1901', 'max:' . min(date('Y') + 1, 2155)],
        ];
    }
}
