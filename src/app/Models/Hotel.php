<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Hotel extends Authenticatable{
    protected $table = 'transfer_hotel';

    protected $fillable = [
        'nombre',
        'usuario',
        'password',
        'id_zona',
        'comision',
    ];
    protected $hidden = ['password'];

    public function getAuthIdentifierName(){
        return 'usuario';
    }
}
