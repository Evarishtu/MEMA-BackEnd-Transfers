<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ZonaStatsController extends Controller{
    public function reservasPorZona(){
        $totalReservas = DB::table('transfer_reservas')->count();

        if($totalReservas === 0){
            return response()->json([]);
        }
        $datos = DB::table('transfer_zona')
            ->leftJoin('transfer_hotel', 'transfer_zona.id_zona', '=', 'transfer_hotel.id_zona')
            ->leftJoin('transfer_reservas', 'transfer_hotel.id_hotel', '=', 'transfer_reservas.id_hotel')
            ->select(
                'transfer_zona.id_zona',
                'transfer_zona.descripcion as zona',
                DB::raw('COUNT(transfer_reservas.id_reserva) as total_traslados'),
                DB::raw('ROUND((COUNT(transfer_reservas.id_reserva) / ' . $totalReservas . ') * 100, 2) as porcentaje')
            )
            ->groupBy('transfer_zona.id_zona', 'transfer_zona.descripcion')
            ->orderByDesc('total_traslados')
            ->get();
        return response()->json($datos);
    }
}
?>