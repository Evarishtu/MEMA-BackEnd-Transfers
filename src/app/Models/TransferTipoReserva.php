<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferTipoReserva extends Model{
    protected $table = 'transfer_tipo_reserva';
    protected $primaryKey = 'id_tipo_reserva';
    public $timestamps = false;

    protected $fillable = [
        'descripcion'
    ];
}

?>