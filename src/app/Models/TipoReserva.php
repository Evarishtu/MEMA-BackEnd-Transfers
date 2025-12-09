<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoReserva extends Model
{
    protected $table = 'transfer_tipo_reserva';
    protected $primaryKey = 'id_tipo_reserva';
    public $timestamps = false;

    protected $fillable = ['descripcion'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_tipo_reserva', 'id_tipo_reserva');
    }
}
