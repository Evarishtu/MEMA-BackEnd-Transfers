<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Reserva;

class Viajero extends Authenticatable
{
    protected $table = 'transfer_viajeros';
    protected $primaryKey = 'id_viajero';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'nombre',
        'apellido1',
        'apellido2',
        'direccion',
        'codigoPostal',
        'pais',
        'ciudad'
    ];

    protected $hidden = ['password'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'email_cliente', 'email');
    }
}
