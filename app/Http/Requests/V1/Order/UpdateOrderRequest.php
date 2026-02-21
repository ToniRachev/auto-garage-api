<?php

namespace App\Http\Requests\V1\Order;

use App\Enums\V1\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderRequest extends FormRequest
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
            'car_id' => ['sometimes', 'exists:cars,id'],
            'service_type' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', new Enum(OrderStatus::class)],
        ];
    }

    public function messages(): array
    {
        $allowedStatuses = implode(', ', array_column(OrderStatus::cases(), 'value'));

        return [
            'status.enum' => "The status must be one of: {$allowedStatuses}.",
        ];
    }
}
