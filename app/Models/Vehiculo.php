<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'transfer_vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'email_conductor',
        'password'
    ];

    protected $hidden = ['password'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_vehiculo', 'id_vehiculo');
    }
}
