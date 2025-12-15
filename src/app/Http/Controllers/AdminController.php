<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Reserva;
use App\Models\TipoReserva;
use App\Models\Hotel;
use App\Models\Viajero;
use App\Models\Vehiculo;
use App\Models\Admin;
use App\Services\ReservaEmailService;

class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard', compact('admin'));
    }

    // ===============================
    // 1. SELECCIONAR TIPO DE RESERVA
    // ===============================
    public function crearReserva()
    {
        $tipos = TipoReserva::orderBy('descripcion')->get();
        return view('admin.tipo', compact('tipos'));

    }

    // ===============================
    // 2. FORMULARIO DE DATOS DE RESERVA
    // ===============================
    public function crearReservaDatos(Request $request){
        // Validar tipo
        $request->validate([
            'tipo_reserva' => 'required|exists:transfer_tipo_reserva,id_tipo_reserva',
        ]);

        $tipo = $request->tipo_reserva;
        $tipoModel = TipoReserva::findOrFail($tipo);

        $hoteles   = Hotel::orderBy('nombre')->get();
        $vehiculos = Vehiculo::orderBy('descripcion')->get();
        $email_cliente = $request->query('email', '');

        return view('admin.datos', [
            'tipo' => $tipo,
            'tipo_nombre' => $tipoModel->descripcion,
            'hoteles' => $hoteles,
            'vehiculos' => $vehiculos,
            'email_cliente' => $email_cliente
        ]);;
    }
    // ===============================
    // 3. GUARDAR RESERVA (LÓGICA COMPLETA)
    // ===============================
    public function guardarReserva(Request $request){
        
        // ==========================
        // VALIDACIÓN BASE
        // ==========================
        $request->validate([
            'tipo_reserva'    => 'required|exists:transfer_tipo_reserva,id_tipo_reserva',
            'email_cliente'   => 'required|email',
            'id_hotel'        => 'required|exists:transfer_hotel,id_hotel',
            'id_vehiculo'     => 'required|exists:transfer_vehiculo,id_vehiculo',
            'numero_viajeros' => 'required|integer|min:1',
        ]);

        $tipo = $request->tipo_reserva;

        // ==========================
        // COMPROBAR VIAJERO
        // ==========================
        $viajero = Viajero::where('email', $request->email_cliente)->first();

        if (!$viajero) {
            return view('admin.registroviajero', [
                'email_cliente' => $request->email_cliente,
                'tipo_reserva'  => $tipo
            ]);
        }

        // ==========================
        // VALIDACIONES POR TIPO
        // ==========================
        $fechaEntrada = $request->fecha_entrada;
        $horaEntrada  = $request->hora_entrada;
        $fechaSalida  = $request->fecha_vuelo_salida;
        $horaSalida   = $request->hora_vuelo_salida;
        $horaRecogida = $request->hora_recogida;

        // --- TIPO 1
        if ($tipo == 1 && $horaRecogida && $horaSalida && $horaRecogida >= $horaSalida) {
            return redirect()
                ->route('admin.reservas.datos', [
                    'tipo_reserva' => $tipo,
                    'email' => $request->email_cliente
                ])
                ->withErrors([
                    'hora_recogida' => 'La hora de recogida debe ser anterior al vuelo'
                ])
                ->withInput();
        }

        // --- TIPO 3 (IDA Y VUELTA)
        if ($tipo == 3) {

            if ($horaRecogida && $horaSalida && $horaRecogida >= $horaSalida) {
                return redirect()
                    ->route('admin.reservas.datos', [
                        'tipo_reserva' => $tipo,
                        'email' => $request->email_cliente
                    ])
                    ->withErrors([
                        'hora_recogida' => 'La hora de recogida no puede ser anterior o igual a la del vuelo de salida'
                    ])
                    ->withInput();
            }

            if ($fechaSalida && $fechaEntrada) {

                if ($fechaSalida > $fechaEntrada) {
                    return redirect()
                        ->route('admin.reservas.datos', [
                            'tipo_reserva' => $tipo,
                            'email' => $request->email_cliente
                        ])
                        ->withErrors([
                            'fecha_vuelo_salida' => 'La fecha del vuelo de ida no puede ser anterior a la de llegada'
                        ])
                        ->withInput();
                }

                if ($fechaSalida === $fechaEntrada && $horaSalida && $horaEntrada && $horaSalida <= $horaEntrada) {
                    return redirect()
                        ->route('admin.reservas.datos', [
                            'tipo_reserva' => $tipo,
                            'email' => $request->email_cliente
                        ])
                        ->withErrors([
                            'hora_vuelo_salida' => 'La hora del vuelo de ida debe ser posterior a la de llegada'
                        ])
                        ->withInput();
                }
            }
        }

        // ==========================
        // CREAR RESERVA
        // ==========================
        
        $hotel = Hotel::findOrFail($request->id_hotel);
        $localizador = Reserva::generarLocalizador();

        Reserva::create([
            'localizador'        => $localizador,
            'id_hotel'           => $request->id_hotel,
            'id_tipo_reserva'    => $tipo,
            'email_cliente'      => $request->email_cliente,
            'id_destino'         => null,
            'num_viajeros'       => $request->numero_viajeros,
            'id_vehiculo'        => $request->id_vehiculo,
            'usuario_creacion'   => 'admin',
            'fecha_reserva'      => now(),
            'fecha_modificacion' => now(),

            'fecha_entrada'        => $fechaEntrada,
            'hora_entrada'         => $horaEntrada,
            'numero_vuelo_entrada' => $request->numero_vuelo_entrada,
            'origen_vuelo_entrada' => $request->origen_vuelo_entrada,

            'fecha_vuelo_salida'   => $fechaSalida,
            'hora_vuelo_salida'    => $horaSalida,
            'numero_vuelo_salida'  => $request->numero_vuelo_salida,
            'hora_recogida'        => $horaRecogida,
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
        

        return view('admin.confirmacion', [
            'localizador' => $localizador,
            'email' => $request->email_cliente,
            'tipo_reserva_texto' => TipoReserva::TipoReservaDesc($tipo),
            'hotel_nombre' => $hotel->nombre,
            'numero_viajeros' => $request->numero_viajeros
        ]);
    }


    // ===============================
    // REGISTRO DE VIAJERO
    // ===============================
    public function crearViajero(Request $request)
    {
        $email = $request->email;
        $tipo_reserva = $request->tipo_reserva;

        return view('admin.viajeros.create', compact('email', 'tipo_reserva'));
    }

    public function storeViajero(Request $request)
    {
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
            ->route('admin.reservas.datos', [
                'tipo_reserva' => $request->tipo_reserva,
                'email' => $request->email
            ])
            ->with('success', "Cliente registrado. Contraseña temporal: $password");
    }

    // ===============================
    // LISTAR RESERVAS
    // ===============================
    public function listarReservas(Request $request){
        $query = Reserva::with(['hotel', 'tipo'])
            ->orderBy('fecha_reserva', 'desc');

        // FILTRO: Desde
        if ($request->filled('desde')) {
            $query->whereDate('fecha_reserva', '>=', $request->desde);
        }

        // FILTRO: Hasta
        if ($request->filled('hasta')) {
            $query->whereDate('fecha_reserva', '<=', $request->hasta);
        }

        // FILTRO: Tipo de reserva
        if ($request->filled('tipo')) {
            $query->where('id_tipo_reserva', $request->tipo);
        }

        // FILTRO: Hotel
        if ($request->filled('hotel')) {
            $query->where('id_hotel', $request->hotel);
        }

        // FILTRO: Búsqueda general
        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($sub) use ($q) {
                $sub->where('localizador', 'LIKE', "%$q%")
                    ->orWhere('email_cliente', 'LIKE', "%$q%");
            });
        }

        // Obtener resultados
        $reservas = $query->get();

        // Datos para selects de filtros
        $tipos = TipoReserva::all();
        $hoteles = Hotel::all();

        return view('admin.listar', compact('reservas', 'tipos', 'hoteles'));
    }



    // ===============================
    // VER RESERVA
    // ===============================
    public function verReserva($id){
        $reserva = Reserva::with(['hotel', 'tipo_reserva', 'vehiculo'])->findOrFail($id);

        return view('admin.ver', compact('reserva'));
    }

    // ===============================
    // EDITAR RESERVA
    // ===============================
    public function editarReserva($id)
    {
        $reserva = Reserva::findOrFail($id);
        $hoteles = Hotel::all();
        $vehiculos = Vehiculo::all();
        $tipos = TipoReserva::all();

        return view('admin.editar', compact('reserva', 'hoteles', 'vehiculos', 'tipos'));
    }

    public function actualizarReserva(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $reserva->update($request->all());

        return redirect()->route('admin.reservas.ver', $id)
            ->with('success', 'Reserva actualizada correctamente.');
    }

    // ===============================
    // CANCELAR RESERVA
    // ===============================
    public function cancelarReserva($id)
    {
        Reserva::destroy($id);
        return redirect()->route('admin.reservas.index')->with('success', 'Reserva eliminada.');
    }

    // ===============================
    // PERFIL ADMIN
    // ===============================
    public function informacionPersonal()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.info', compact('admin'));
    }

    public function actualizarInformacionPersonal(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'nombre' => 'required',
            'email'  => 'required|email',
            //'password' => 'nullable|min:4'
        ]);

        $admin->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $admin->password
        ]);

        return back()->with('success', 'Datos actualizados correctamente.');
    }

    public function calendario(Request $request){
        $vista = $request->query('vista', 'semana');
        $fecha_base = $request->query('fecha', date('Y-m-d'));

        // Obtener todos los eventos (reservas)
        $eventos = Reserva::with(['tipo', 'hotel'])->orderBy('fecha_reserva', 'asc')
            ->get();

        /* ================================================
        GENERAR DÍAS DE LA SEMANA (para vista "semana")
        ================================================= */
        $diasSemana = [];
        if ($vista === 'semana') {
            $base = new \DateTime($fecha_base);
            $dow = (int) $base->format('N'); // 1 = lunes
            $base->modify('-' . ($dow - 1) . ' day');

            for ($i = 0; $i < 7; $i++) {
                $diasSemana[] = $base->format('Y-m-d');
                $base->modify('+1 day');
            }
        }

        /* ================================================
        GENERAR MATRIZ DEL MES (6 filas × 7 columnas)
        ================================================= */
        $calendar = [];
        if ($vista === 'mes') {
            $first = new \DateTime(date('Y-m-01', strtotime($fecha_base)));
            $startDow = (int)$first->format('N');
            $start = clone $first;
            $start->modify('-' . ($startDow - 1) . ' day');

            for ($week = 0; $week < 6; $week++) {
                $row = [];
                for ($day = 0; $day < 7; $day++) {
                    $row[] = $start->format('Y-m-d');
                    $start->modify('+1 day');
                }
                $calendar[] = $row;
            }
        }

        return view('admin.calendario', [
            'vista'       => $vista,
            'fecha_base'  => $fecha_base,
            'eventos'     => $eventos,
            'diasSemana'  => $diasSemana,
            'calendar'    => $calendar,
        ]);
    }

    public function registrarViajeroDesdeAdmin(Request $request){
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
        return view('admin.registrosuccess', [
            'viajero' => $viajero
        ]);
    }



    public function comisionesHoteles(Request $request){

        $mes       = $request->get('mes', now()->format('Y-m'));
        $inicioMes = $mes . '-01 00:00:00';
        $finMes    = date('Y-m-t 23:59:59', strtotime($inicioMes));

        $datos = DB::table('transfer_hotel')->leftJoin('transfer_reservas', function ($join) use ($inicioMes, $finMes) {
        $join->on('transfer_hotel.id_hotel', '=', 'transfer_reservas.id_hotel')->whereBetween('transfer_reservas.fecha_reserva', [$inicioMes, $finMes]);
            })->select('transfer_hotel.id_hotel','transfer_hotel.nombre as hotel','transfer_hotel.comision as comision_hotel',
                // Reservas por tipo
                    DB::raw("SUM(CASE WHEN transfer_reservas.usuario_creacion = 'admin' THEN 1 ELSE 0 END) AS reservas_admin"),
                    DB::raw("SUM(CASE WHEN transfer_reservas.usuario_creacion = 'viajero' THEN 1 ELSE 0 END) AS reservas_viajero"),
                    DB::raw("SUM(CASE WHEN transfer_reservas.usuario_creacion = 'corporativo' THEN 1 ELSE 0 END) AS reservas_corporativo"),

                // Total comisiones corporativo (por reserva)
                    DB::raw("(SUM(CASE WHEN transfer_reservas.usuario_creacion = 'corporativo' THEN 1 ELSE 0 END) * transfer_hotel.comision
                    ) AS total_comisiones")
            )->groupBy('transfer_hotel.id_hotel',
                        'transfer_hotel.nombre',
                        'transfer_hotel.comision')
            ->orderByDesc('total_comisiones')
            ->get();

        return view('admin.comisiones', compact('datos', 'mes'));
    }

}
?>