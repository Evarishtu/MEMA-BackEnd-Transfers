<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.reservas.tipo', compact('tipos'));
    }

    // ===============================
    // 2. FORMULARIO DE DATOS DE RESERVA
    // ===============================
    public function crearReservaDatos(Request $request)
    {
        $request->validate([
            'tipo_reserva' => 'required|exists:transfer_tipo_reserva,id_tipo_reserva',
        ]);

        $tipo = $request->tipo_reserva;
        $hoteles = Hotel::orderBy('nombre')->get();
        $vehiculos = Vehiculo::orderBy('descripcion')->get();

        return view('admin.reservas.datos', compact('tipo', 'hoteles', 'vehiculos'));
    }

    // ===============================
    // 3. GUARDAR RESERVA (LÓGICA COMPLETA)
    // ===============================
    public function guardarReserva(Request $request)
    {
        // VALIDACIÓN BASE
        $request->validate([
            'email_cliente'   => 'required|email',
            'id_hotel'        => 'required|exists:transfer_hotel,id_hotel',
            'tipo_reserva'    => 'required|exists:transfer_tipo_reserva,id_tipo_reserva',
            'numero_viajeros' => 'required|integer|min:1',
            'id_vehiculo'     => 'required|exists:transfer_vehiculo,id_vehiculo'
        ]);

        // Comprobación de que el viajero existe
        $viajero = Viajero::where('email', $request->email_cliente)->first();
        if (!$viajero) {
            return redirect()
                ->route('admin.viajero.create', [
                    'email' => $request->email_cliente,
                    'tipo_reserva' => $request->tipo_reserva
                ])
                ->with('info', 'Debe registrar al viajero antes de continuar.');
        }

        // Lógica de validación según tipo (1, 2 o 3)
        // → Pendiente, la migro después si confirmas seguir

        // Obtener zona por hotel
        $id_zona = Hotel::find($request->id_hotel)->id_zona;

        // Generar localizador
        $localizador = strtoupper(substr(md5(uniqid()), 0, 8));

        // GUARDAR RESERVA
        $reserva = Reserva::create([
            'localizador' => $localizador,
            'id_hotel' => $request->id_hotel,
            'id_tipo_reserva' => $request->tipo_reserva,
            'email_cliente' => $request->email_cliente,
            'id_destino' => $id_zona,
            'num_viajeros' => $request->numero_viajeros,
            'id_vehiculo' => $request->id_vehiculo,
            'usuario_creacion' => 'admin',
            'fecha_reserva' => now(),
            'fecha_modificacion' => now(),

            // Campos opcionales
            'fecha_entrada' => $request->fecha_entrada,
            'hora_entrada' => $request->hora_entrada,
            'numero_vuelo_entrada' => $request->numero_vuelo_entrada,
            'origen_vuelo_entrada' => $request->origen_vuelo_entrada,
            'fecha_vuelo_salida' => $request->fecha_vuelo_salida,
            'hora_vuelo_salida' => $request->hora_vuelo_salida,
            'numero_vuelo_salida' => $request->numero_vuelo_salida,
            'hora_recogida' => $request->hora_recogida,
        ]);

        return view('admin.reservas.confirmacion', compact('reserva'));
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
    public function listarReservas(Request $request)
    {
        $reservas = Reserva::with(['hotel', 'tipo'])
            ->orderBy('fecha_reserva', 'desc')
            ->get();

        $tipos = TipoReserva::all();
        $hoteles = Hotel::all();

        return view('admin.listar', compact('reservas', 'tipos', 'hoteles'));
    }


    // ===============================
    // VER RESERVA
    // ===============================
    public function verReserva($id)
    {
        $reserva = Reserva::findOrFail($id);
        return view('admin.reservas.ver', compact('reserva'));
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

        return view('admin.reservas.editar', compact('reserva', 'hoteles', 'vehiculos', 'tipos'));
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
        return redirect()->route('admin.reservas.listar')
            ->with('success', 'Reserva eliminada.');
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

}
