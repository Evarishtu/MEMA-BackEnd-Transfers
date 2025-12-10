<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Viajero;
use App\Models\Reserva;
use App\Models\TransferTipoReserva;
use App\Models\Hotel;
use App\Models\TransferVehiculo;

class ViajeroController extends Controller {
    public function dashboard(){
        $viajero = Auth::guard('viajero')->user();
        return view('viajero.dashboard', compact('viajero'));
    }
    public function informacionPersonal(){
        $viajero = Auth::guard('viajero')->user();
        return view('viajero.info', compact('viajero'));
    }
    // public function actualizarInformacionPersonal(Request $request){
    //     $viajero = Auth::guard('viajero')->user();

    //     $request->validate([
    //         'nombre' => 'required',
    //         'apellido1' => 'required',
    //         'direccion' => 'required',
    //         'codigoPostal' => 'required',
    //         'pais' => 'required',
    //         'ciudad' => 'required',
    //         'password' => 'nullable|min:4'
    //     ]);

    //     $viajero->update([
    //         'nombre' => $request->nombre,
    //         'apellido1' => $request->apellido1,
    //         'apellido2' => $request->apellido2,
    //         'direccion' => $request->direccion,
    //         'codigoPostal' => $request->codigoPostal,
    //         'pais' => $request->pais,
    //         'ciudad' => $request->ciudad,
    //         'password' => $request->password ? bcrypt($request->password) : $viajero->password
    //     ]);
    //     return back()->with('success', 'Información actualizada correctamente');
    // }
    public function crearReserva(){
        $tiposReserva = TransferTipoReserva::all();
        $hoteles = Hotel::all();
        $vehiculos = TransferVehiculo::all();
        $viajero = Auth::guard('viajero')->user();

        return view('viajero.reservas.create', compact('tiposReserva', 'hoteles', 'vehiculos', 'viajero'));
    }
    public function guardarReserva(Request $request){
        $viajero = Auth::guard('viajero')->user();

        $request->validate([
            'id_tipo_reserva' => 'required|integer',
            'id_hotel' => 'required|integer',
            'id_vehiculo' => 'required|integer',
            'num_viajeros' => 'required|integer|min:1',
        ]);
        $data = $request->all();
        $data['id_viajero'] = $viajero->id_viajero;
        $data['email_cliente'] = $viajero->email;
        $data['usuario_creacion'] = $viajero->email;

        Reserva::create($data);

        return redirect()->route('viajero.reservas.index')->with('success', 'Reserva creada correctamente');
    }
    public function listarReservas(){
        $viajero = Auth::guard('viajero')->user();
        $reservas = Reserva::where('id_viajero', $viajero->id_viajero)->get();

        return view('viajero.reservas.index', compact('reservas'));
    }
    public function verReserva($id){
        $reserva = Reserva::findOrFail($id);
        if($reserva->id_viajero !== Auth::guard('viajero')->user()->id_viajero){
            abort(403);
        }
        return view('viajero.reservas.show', compact('reserva'));
    }
    public function cancelarReserva($id){
        $reserva = Reserva::findOrFail($id);

        if($reserva->id_viajero != Auth::guard('viajero')->user()->id_viajero){
            abort(403);
        }
        $reserva->delete();
        return back()->with('success', 'Reserva cancelada');
    }
}

?>