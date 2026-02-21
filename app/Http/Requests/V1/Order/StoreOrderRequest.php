<?php

namespace App\Http\Requests\V1\Order;

use App\Enums\V1\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOrderRequest extends FormRequest
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
        $this['car_id'] = $this->integer('carId');
        $this['service_type'] = $this->input('serviceType');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id'],
            'service_type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
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
