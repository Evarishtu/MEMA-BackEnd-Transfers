<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class TransferVehiculo extends Model{
    protected $table = 'transfer_vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'email_conductor',
        'password',
    ];
}
?>