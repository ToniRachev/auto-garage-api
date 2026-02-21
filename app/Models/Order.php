<?php

namespace App\Models;

use App\Enums\V1\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'car_id',
        'service_type',
        'price',
        'status'
    ];

    protected $attributes = [
        'status' => OrderStatus::PENDING->value,
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
