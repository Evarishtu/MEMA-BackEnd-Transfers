<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Hotel extends Authenticatable
{
    protected $table = 'transfer_hotel';
    protected $primaryKey = 'id_hotel'; 
    public $timestamps = false;
    protected $fillable = [
        'nombre', 
        'usuario',
        'password',
        'id_zona',
        'comision'
    ];
}
