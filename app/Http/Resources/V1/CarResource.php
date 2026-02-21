<?php

namespace App\Http\Resources\V1;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Car
 */

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'clientId' => $this->client_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'client' => new ClientResource($this->whenLoaded('client')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}
