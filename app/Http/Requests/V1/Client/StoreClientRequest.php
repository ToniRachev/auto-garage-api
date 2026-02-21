<?php

namespace App\Http\Requests\V1\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
            'phone' => ['required', 'string', 'min:10', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'city' => ['required', 'string', 'min:2', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'There is already client with this email address.',
        ];
    }
}
