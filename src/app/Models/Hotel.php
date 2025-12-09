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
        'comision',
    ];

    protected $hidden = ['password'];

    public function zona()
    {
        return $this->belongsTo(TransferZona::class, 'id_zona', 'id_zona');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_hotel', 'id_hotel');
    }
}
