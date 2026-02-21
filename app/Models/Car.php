<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'client_id',
        'brand',
        'model',
        'year'
    ];
}
