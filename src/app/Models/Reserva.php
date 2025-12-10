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

    public static function listarEventosCalendario(){
        return self::select(
                'transfer_reservas.id_reserva',
                'transfer_reservas.localizador',
                'transfer_reservas.id_hotel',
                'transfer_reservas.id_tipo_reserva',
                'transfer_reservas.email_cliente',
                'transfer_reservas.fecha_reserva',
                'transfer_reservas.fecha_entrada',
                'transfer_reservas.hora_entrada',
                'transfer_reservas.fecha_vuelo_salida',
                'transfer_reservas.hora_vuelo_salida'
            )
            ->leftJoin('transfer_hotel', 'transfer_hotel.id_hotel', '=', 'transfer_reservas.id_hotel')
            ->leftJoin('transfer_tipo_reserva', 'transfer_tipo_reserva.id_tipo_reserva', '=', 'transfer_reservas.id_tipo_reserva')
            ->get()
            ->map(function ($r) {
                return [
                    'id_reserva'        => $r->id_reserva,
                    'localizador'       => $r->localizador,
                    'hotel_nombre'      => $r->hotel->nombre ?? '',
                    'tipo_descripcion'  => $r->tipo->descripcion ?? '',
                    'fecha_entrada'     => $r->fecha_entrada,
                    'hora_entrada'      => $r->hora_entrada,
                    'fecha_vuelo_salida'=> $r->fecha_vuelo_salida,
                    'hora_vuelo_salida' => $r->hora_vuelo_salida,
                ];
            }
        );
    }

    public static function generarLocalizador(){
        return strtoupper(substr(uniqid('RES-'), -8));
    }

}
