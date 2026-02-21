<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'car_id',
        'service_type',
        'price',
        'status'
    ];
}
