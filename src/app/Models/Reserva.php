<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'transfer_reservas';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;

    protected $fillable = [
        'localizador',
        'id_hotel',
        'id_tipo_reserva',
        'email_cliente',
        'id_destino',
        'fecha_reserva',
        'fecha_modificacion',

        'fecha_entrada',
        'hora_entrada',
        'numero_vuelo_entrada',
        'origen_vuelo_entrada',

        'fecha_vuelo_salida',
        'hora_vuelo_salida',
        'numero_vuelo_salida',
        'hora_recogida',

        'num_viajeros',
        'id_vehiculo',
        'usuario_creacion'
    ];

    // ===== RELACIONES =====
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotel', 'id_hotel');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoReserva::class, 'id_tipo_reserva', 'id_tipo_reserva');
    }

    public function viajero()
    {
        return $this->belongsTo(Viajero::class, 'email_cliente', 'email');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo');
    }

    public function zona()
    {
        return $this->belongsTo(TransferZona::class, 'id_destino', 'id_zona');
    }
}
