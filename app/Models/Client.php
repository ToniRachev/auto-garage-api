<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
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
}
