<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'carId' => $this->car_id,
            'serviceType' => $this->service_type,
            'price' => $this->price,
            'status' => $this->status,
            'car' => new CarResource($this->whenLoaded('car')),
        ];
    }
}
