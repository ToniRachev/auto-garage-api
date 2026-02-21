<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city'
    ];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, Car::class);
    }
}
