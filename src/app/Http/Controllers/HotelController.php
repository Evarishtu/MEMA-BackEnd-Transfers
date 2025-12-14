<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Hotel;
use App\Models\Vehiculo;
use App\Models\Viajero;
use App\Models\Reserva;
use App\Models\TipoReserva;



class HotelController extends Controller{
    public function dashboard(){
        $hotel = auth('hotel')->user();
        return view('hotel.dashboard', compact('hotel'));
    }
    public function crearReserva(){
        $tipos = TipoReserva::orderBy('descripcion')->get();
        return view('hotel.tipo', compact('tipos'));
    }
    public function crearReservaDatos(Request $request){
        if(session()->has('email_precargado')){
            $request->merge([
                'email_cliente' => session('email_precargado'),
                'tipo_reserva' => session('tipo_reserva')
            ]);
            session()->forget(['email_precargado', 'tipo_reserva']);
        }
        $request->validate([
            'tipo_reserva' => 'required|exists:transfer_tipo_reserva,id_tipo_reserva',
        ]);
        $tipo = $request->tipo_reserva;
        $tipoModel = TipoReserva::find($tipo);

        if(!$tipoModel){
            return redirect()
                ->route('hotel.reservas.crear')
                ->with('error', 'Tipo de reserva no válido.');
        }
        $tipo_nombre = $tipoModel->descripcion;
        $vehiculos = Vehiculo::orderBy('descripcion')->get();
        $email_cliente = $request->query('email', '');

        return view('hotel.datos', compact(
            'tipo',
            'tipo_nombre',
            'vehiculos',
            'email_cliente'
        ));
    }
    public function guardarReserva(Request $request){
        // dd($request->all());
        $hotel = auth()->guard('hotel')->user();

        $request->validate([
            'tipo_reserva' => 'required|exists:transfer_tipo_reserva,id_tipo_reserva',
            'email_cliente' => 'required|email',
            'id_vehiculo' => 'required|exists:transfer_vehiculo,id_vehiculo',
            'numero_viajeros' => 'required|integer|min:1',
        ]);
        $tipo = $request->tipo_reserva;
        $tipoDesc = TipoReserva::TipoReservaDesc($tipo);

        //=== COMPROBAR VIAJERO ===
        $viajero = Viajero::where('email', $request->email_cliente)->first();

        if(!$viajero){
            return view('hotel.registroviajero', [
                'email_cliente' => $request->email_cliente,
                'tipo_reserva' => $tipo
            ]);
        }
        $validator = Validator::make($request->all(), []);

        if($tipo == 1){
            $validator->after(function ($v) use ($request){
                if($request->hora_recogida && $request->hora_vuelo_salida){
                    if($request->hora_recogida >= $request->hora_vuelo_salida){
                        $v->errors()->add(
                            'hora_recogida',
                            'Hora de recogida incorrecta'
                        );
                    }
                }
            });
        }

        if($tipo == 3){
            $request->validate([
                'fecha_entrada' => 'required|date',
                'hora_entrada' => 'required',
                'fecha_vuelo_salida' => 'required|date',
                'hora_vuelo_salida' => 'required',
            ]);
            $validator->after(function($v) use ($request){
                if($request->fecha_vuelo_salida && $request->fecha_entrada){
                    if($request->fecha_vuelo_salida < $request->fecha_entrada){
                        $v->errors()->add(
                            'fecha_vuelo_salida',
                            'Fecha ida posterior a vuelta'
                        );
                    }
                }
            });
        }

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $data = $request->only([
            'fecha_vuelo_salida',
            'hora_vuelo_salida',
            'numero_vuelo_salida',
            'hora_recogida',
            'fecha_entrada',
            'hora_entrada',
            'numero_vuelo_entrada',
            'origen_vuelo_entrada'
        ]);
        foreach($data as $k => $v){
            if($v === "" || $v === null){
                $data[$k] = null;
            }
        }
        $id_zona = $hotel->id_zona;
        $localizador = Reserva::generarLocalizador();

        Reserva::create([
        'localizador'        => $localizador,
        'id_hotel'           => $hotel->id_hotel,
        'id_tipo_reserva'    => $tipo,
        'email_cliente'      => $request->email_cliente,
        'id_destino'         => null,
        'num_viajeros'       => $request->numero_viajeros,
        'id_vehiculo'        => $request->id_vehiculo,
        'usuario_creacion'   => 'corporativo',
        'fecha_reserva'      => now(),
        'fecha_modificacion' => now(),

        // Llegada
        'fecha_entrada'        => $data['fecha_entrada'],
        'hora_entrada'         => $data['hora_entrada'],
        'numero_vuelo_entrada' => $data['numero_vuelo_entrada'],
        'origen_vuelo_entrada' => $data['origen_vuelo_entrada'],

        // Salida
        'fecha_vuelo_salida'   => $data['fecha_vuelo_salida'],
        'hora_vuelo_salida'    => $data['hora_vuelo_salida'],
        'numero_vuelo_salida'  => $data['numero_vuelo_salida'],
        'hora_recogida'        => $data['hora_recogida'],
    ]);

    return view('hotel.confirmacion', [
        'localizador'        => $localizador,
        'email'              => $request->email_cliente,
        'tipo_reserva_texto' => $tipoDesc,
        'hotel_nombre'       => $hotel->nombre,
        'numero_viajeros'    => $request->numero_viajeros
    ]);

    }
    public function listarReservas(){
        $hotel = auth('hotel')->user();

        $reservas = Reserva::with(['tipo'])
            ->where('id_hotel', $hotel->id_hotel)
            ->orderBy('fecha_reserva', 'desc')
            ->get();
        return view('hotel.reservas', [
            'hotel' => $hotel,
            'reservas' => $reservas
        ]);
    }
    public function storeViajero(Request $request){
        $request->validate([
            'email' => 'required|email|unique:transfer_viajeros,email',
            'nombre' => 'required',
            'apellido1' => 'required',
            'direccion' => 'required'
        ]);
        $password = bin2hex(random_bytes(4));

        Viajero::create([
            'email' => $request->email,
            'password' => bcrypt($password),
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'direccion' => $request->direccion,
            'codigoPostal' => $request->codigoPostal,
            'pais' => $request->pais,
            'ciudad' => $request->ciudad,
        ]);

        return redirect()
            ->route('hotel.reservas.datos', [
                'tipo_reserva' => $request->tipo_reserva,
                'email' => $request->email
            ])
            ->with('success', "Cliente registrado. Contraseña tempral: $password");
    }
    public function comisiones(){
        $hotel = auth('hotel')->user();
        $comisiones = Reserva::selectRaw('
            YEAR(fecha_reserva) as year,
            MONTH(fecha_reserva) as month,
            COUNT(*) as total_reservas
        ')
        ->where('id_hotel', $hotel->id_hotel)
        ->where('usuario_creacion', 'corporativo')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        return view('hotel.comisiones', [
            'hotel' => $hotel,
            'comisiones' => $comisiones
        ]);
    }
}
?>