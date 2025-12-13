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
        //Si viene desde registrar viajero
        if (session()->has('email_precargado')) {
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

        // Obtener el tipo real desde la BD
        $tipoModel = TipoReserva::find($tipo);

        // Debe existir porque lo valida arriba, pero por seguridad:
        if (!$tipoModel) {
            return redirect()
                ->route('admin.reservas.crear')
                ->with('error', 'Tipo de reserva no válido.');
        }

        // Nombre real del tipo (columna "descripcion")
        $tipo_nombre = $tipoModel->descripcion;

        // Datos adicionales
        $hoteles   = Hotel::orderBy('nombre')->get();
        $vehiculos = Vehiculo::orderBy('descripcion')->get();

        // Si viene un email precargado del proceso de registrar viajero
        $email_cliente = $request->query('email', '');

        return view('admin.datos', compact(
            'tipo',
            'tipo_nombre',
            'hoteles',
            'vehiculos',
            'email_cliente'
        ));
    }


    // ===============================
    // 3. GUARDAR RESERVA (LÓGICA COMPLETA)
    // ===============================
    public function guardarReserva(Request $request){
        // ====================================
        // 1. VALIDACIÓN BASE
        // ====================================
        $request->validate([
            'tipo_reserva'      => 'required|exists:transfer_tipo_reserva,id_tipo_reserva',
            'email_cliente'     => 'required|email',
            'id_hotel'          => 'required|exists:transfer_hotel,id_hotel',
            'id_vehiculo'       => 'required|exists:transfer_vehiculo,id_vehiculo',
            'numero_viajeros'   => 'required|integer|min:1',
        ]);

        $tipo       = $request->tipo_reserva;
        $tipoDesc = TipoReserva::TipoReservaDesc($tipo);

        // ====================================
        // 2. COMPROBAR QUE EL EMAIL EXISTE
        // ====================================
        $viajero = Viajero::where('email', $request->email_cliente)->first();

        if (!$viajero) {
            $email_cliente = $request->email_cliente;
            $tipo_reserva  = $tipo;

            // Muestra tu vista privada de admin
            return view('admin.registroviajero', compact('email_cliente', 'tipo_reserva'));
        }

        // ====================================
        // 3. VALIDACIONES DEPENDIENTES DEL TIPO
        // ====================================

        $validator = Validator::make($request->all(), []);

        // ----- TIPO 1 → HOTEL → AEROPUERTO
        if ($tipo == 1) {
            $validator->after(function ($v) use ($request) {
                
                if ($request->hora_recogida && $request->hora_vuelo_salida) {

                    if ($request->hora_recogida > $request->hora_vuelo_salida) {
                        $v->errors()->add('hora_recogida', 
                            'La hora de recogida no puede ser posterior a la hora del vuelo.');
                    }

                    if ($request->hora_recogida == $request->hora_vuelo_salida) {
                        $v->errors()->add('hora_recogida', 
                            'La hora de recogida no puede ser igual a la hora del vuelo.');
                    }
                }
            });
        }


        // ----- TIPO 3 → IDA Y VUELTA
        if ($tipo == 3) {
            $validator->after(function ($v) use ($request) {

                // Validación recogida vs salida
                if ($request->hora_recogida && $request->hora_vuelo_salida) {

                    if ($request->hora_recogida > $request->hora_vuelo_salida) {
                        $v->errors()->add('hora_recogida', 
                            'La hora de recogida no puede ser posterior al vuelo.');
                    }

                    if ($request->hora_recogida == $request->hora_vuelo_salida) {
                        $v->errors()->add('hora_recogida', 
                            'La hora de recogida no puede ser igual al vuelo.');
                    }
                }

                // Validación fechas ida/vuelta
                if ($request->fecha_vuelo_salida && $request->fecha_entrada) {

                    if ($request->fecha_vuelo_salida < $request->fecha_entrada) {
                        $v->errors()->add('fecha_vuelo_salida',
                            'La fecha del vuelo de ida no puede ser posterior a la fecha de llegada.');
                    }

                    if ($request->fecha_vuelo_salida == $request->fecha_entrada) {

                        if ($request->hora_vuelo_salida > $request->hora_entrada) {
                            $v->errors()->add('hora_vuelo_salida',
                                'La hora del vuelo de ida no puede ser posterior a la de vuelta.');
                        }

                        if ($request->hora_vuelo_salida == $request->hora_entrada) {
                            $v->errors()->add('hora_vuelo_salida',
                                'La hora del vuelo de ida no puede ser igual a la de vuelta.');
                        }
                    }
                }
            });
        }

        // Ejecuta validaciones dinámicas
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ====================================
        // 4. NORMALIZAR CAMPOS A NULL
        // ====================================
        $data = $request->only([
            'tipo_reserva',
            'id_hotel',
            'id_vehiculo',
            'email_cliente',
            'numero_viajeros',
            'fecha_vuelo_salida',
            'hora_vuelo_salida',
            'numero_vuelo_salida',
            'hora_recogida',
            'fecha_entrada',
            'hora_entrada',
            'numero_vuelo_entrada',
            'origen_vuelo_entrada'
        ]);

        foreach ($data as $k => $v) {
            if ($v === "" || $v === null) {
                $data[$k] = null;
            }
        }

        // ====================================
        // 5. OBTENER DESTINO POR HOTEL
        // ====================================
        $id_zona = Hotel::where('id_hotel', $request->id_hotel)->value('id_zona');

        // ====================================
        // 6. GENERAR LOCALIZADOR
        // ====================================
        $localizador = Reserva::generarLocalizador(); // método que debes implementar

        // ====================================
        // 7. CREAR RESERVA
        // ====================================
        $reserva = Reserva::create([
            'localizador'          => $localizador,
            'id_hotel'             => $request->id_hotel,
            'id_tipo_reserva'      => $request->tipo_reserva,
            'email_cliente'        => $request->email_cliente,
            'id_destino'           => $id_zona,
            'num_viajeros'         => $request->numero_viajeros,
            'id_vehiculo'          => $request->id_vehiculo,
            'usuario_creacion'     => 'admin',
            'fecha_reserva'        => now(),
            'fecha_modificacion'   => now(),

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

        // ====================================
        // 8. ENVIAR EMAIL
        // ====================================
        /*
        $hotelNombre = Hotel::find($request->id_hotel)->nombre;

        EmailHelper::enviarConfirmacionReserva(
            $request->email_cliente,
            $viajero->nombre ?? "Cliente",
            $localizador,
            $tipoDesc,
            $hotelNombre
        ); */

        // ====================================
        // 9. MOSTRAR CONFIRMACIÓN
        // ====================================

        $hotelNombre = Hotel::HotelDesc($request->id_hotel);

        return view('admin.confirmacion', [
            'localizador'        => $localizador,
            'email'              => $request->email_cliente,
            'tipo_reserva_texto' => $tipoDesc,
            'hotel_nombre'       => $hotelNombre,
            'numero_viajeros'    => $request->numero_viajeros
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
                    DB::raw("(SUM(CASE WHEN transfer_reservas.usuario_creacion = 'corporativo' THEN 1 ELSE 0 END) * 10 * (1 + transfer_hotel.comision / 100)
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