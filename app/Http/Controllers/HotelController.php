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
use App\Models\Zona;
use App\Services\ReservaEmailService;


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

        if ($tipo == 3) {

            $fechaEntrada = $request->fecha_entrada;
            $horaEntrada  = $request->hora_entrada;
            $fechaSalida  = $request->fecha_vuelo_salida;
            $horaSalida   = $request->hora_vuelo_salida;
            $horaRecogida = $request->hora_recogida;

            if ($horaRecogida && $horaSalida && $horaRecogida >= $horaSalida) {
                return redirect()
                    ->route('hotel.reservas.datos', [
                        'tipo_reserva' => $tipo,
                        'email'        => $request->email_cliente
                    ])
                    ->withErrors([
                        'hora_recogida' => 'La hora de recogida no puede ser igual o posterior a la del vuelo'
                    ])
                    ->withInput();
            }

            if ($fechaSalida && $fechaEntrada && $fechaSalida < $fechaEntrada) {
                return redirect()
                    ->route('hotel.reservas.datos', [
                        'tipo_reserva' => $tipo,
                        'email'        => $request->email_cliente
                    ])
                    ->withErrors([
                        'fecha_vuelo_salida' => 'La fecha del vuelo de ida no puede ser anterior a la de llegada'
                    ])
                    ->withInput();
            }

            if (
                $fechaSalida === $fechaEntrada &&
                $horaSalida &&
                $horaEntrada &&
                $horaSalida <= $horaEntrada
            ) {
                return redirect()
                    ->route('hotel.reservas.datos', [
                        'tipo_reserva' => $tipo,
                        'email'        => $request->email_cliente
                    ])
                    ->withErrors([
                        'hora_vuelo_salida' => 'La hora del vuelo de ida debe ser posterior a la de llegada'
                    ])
                    ->withInput();
            }
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

    try{
        ReservaEmailService::enviarConfirmacion(
            $request->email_cliente,
            $localizador,
            $hotel->nombre,
            TipoReserva::TipoReservaDesc($tipo)
            );
    }catch(\Throwable $e){
            logger()->error($e->getMessage());
    }

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
            'email'        => 'required|email|unique:transfer_viajeros,email',
            'password'     => 'required|min:2',
            'nombre'       => 'required|string',
            'apellido1'    => 'required|string',
            'apellido2'    => 'nullable|string',
            'direccion'    => 'required|string',
            'codigoPostal' => 'required|string',
            'pais'         => 'required|string',
            'ciudad'       => 'required|string',
        ]);

        // Crear viajero
        $viajero = Viajero::create([
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'nombre'       => $request->nombre,
            'apellido1'    => $request->apellido1,
            'apellido2'    => $request->apellido2,
            'direccion'    => $request->direccion,
            'codigoPostal' => $request->codigoPostal,
            'pais'         => $request->pais,
            'ciudad'       => $request->ciudad,
        ]);

        // Mostrar vista de éxito sencilla
        return view('hotel.registrosuccess', [
            'viajero' => $viajero
        ]);
    }

    /*
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
*/ 
    public function comisiones(Request $request){
        $hotel     = auth('hotel')->user();
        $mes       = $request->get('mes', now()->format('Y-m'));
        $inicioMes = $mes . '-01 00:00:00';
        $finMes    = date('Y-m-t 23:59:59', strtotime($inicioMes));

        $datos = DB::table('transfer_hotel')
            ->leftJoin('transfer_reservas', function ($join) use ($inicioMes, $finMes) {
                $join->on('transfer_hotel.id_hotel', '=', 'transfer_reservas.id_hotel')
                    ->whereBetween('transfer_reservas.fecha_reserva', [$inicioMes, $finMes]);
            })
            ->where('transfer_hotel.id_hotel', $hotel->id_hotel) 
            ->select(
                'transfer_hotel.nombre as hotel',
                'transfer_hotel.comision as comision_hotel',

                DB::raw("SUM(CASE WHEN transfer_reservas.usuario_creacion = 'admin' THEN 1 ELSE 0 END) AS reservas_admin"),
                DB::raw("SUM(CASE WHEN transfer_reservas.usuario_creacion = 'viajero' THEN 1 ELSE 0 END) AS reservas_viajero"),
                DB::raw("SUM(CASE WHEN transfer_reservas.usuario_creacion = 'corporativo' THEN 1 ELSE 0 END) AS reservas_corporativo"),
                DB::raw("(
                    SUM(CASE WHEN transfer_reservas.usuario_creacion = 'corporativo' THEN 1 ELSE 0 END) * transfer_hotel.comision
                ) AS total_comisiones")
            )
            ->groupBy(
                'transfer_hotel.id_hotel',
                'transfer_hotel.nombre',
                'transfer_hotel.comision'
            )
            ->get();

        return view('hotel.comisiones', compact('datos', 'mes', 'hotel'));
    }


    public function index(){
        $hoteles = Hotel::with('zona')->orderBy('id_hotel')->get();
        return view('hotel.index', compact('hoteles'));
    }

    public function create(){
        $zonas = Zona::all();
        return view('hotel.form', compact('zonas'));
    }

    public function createCorporativo(){
        $zonas   = Zona::all();
        $hoteles = Hotel::orderBy('nombre')->get();

        return view('admin.crearcorporativo', compact('zonas', 'hoteles'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'usuario'  => 'required|string|max:25|unique:transfer_hotel,usuario',
            'password' => 'required|min:4',
            'id_zona'  => 'nullable|exists:transfer_zona,id_zona',
            'comision' => 'nullable|integer|min:0',
        ]);
        Hotel::create([
            'nombre'   => $request->nombre,
            'usuario'  => $request->usuario,
            'password' => bcrypt($request->password),
            'id_zona'  => $request->id_zona,
            'comision' => $request->comision,
        ]);
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Hotel creado correctamente');
    }

    public function edit($id){
        $hotel = Hotel::findOrFail($id);
        $zonas = Zona::all();

        return view('hotel.form', compact('hotel', 'zonas'));
    }

    public function update(Request $request, $id){
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'usuario'  => 'required|string|max:25' . $hotel->id_hotel . ',id_hotel',
            'id_zona'  => 'nullable|exists:transfer_zona,id_zona',
            'comision' => 'nullable|integer|min:0',
        ]);

        $data = $request->only('nombre', 'usuario', 'id_zona', 'comision');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $hotel->update($data);

        return redirect()->route('hotel.index')->with('success', 'Hotel actualizado correctamente');
    }

    public function destroy($id){
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('hotel.index')->with('success', 'Hotel eliminado correctamente');
    }
}
?>