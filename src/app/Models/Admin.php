<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable

{
    protected $table = 'transfer_admin';
    protected $primaryKey = 'id_admin'; 
    public $timestamps = false;
    protected $fillable = [
        'email', 
        'password',
        'nombre',
    ];
}
