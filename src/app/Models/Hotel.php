<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Hotel extends Authenticatable
{
    protected $fillable = ['email', 'password'];
}
