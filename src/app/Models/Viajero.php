<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Viajero extends Authenticatable
{
    protected $fillable = [
        'email',
        'password',
    ];
}
