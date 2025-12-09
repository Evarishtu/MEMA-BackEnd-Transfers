<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    // LISTAR VEHÍCULOS
    public function index()
    {
        $vehiculos = Vehiculo::orderBy('id_vehiculo')->get();
        return view('vehiculo.index', compact('vehiculos'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        return view('vehiculo.form');
    }

    // GUARDAR NUEVO VEHÍCULO
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        Vehiculo::create([
            'descripcion' => $request->descripcion,
            'email_conductor' => $request->email_conductor,
            'password' => $request->password_conductor
        ]);

        return redirect()->route('vehiculo.index');
    }

    // FORMULARIO EDITAR
    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('vehiculo.form', compact('vehiculo'));
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required'
        ]);

        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('vehiculo.index');
    }

    // ELIMINAR
    public function destroy($id)
    {
        Vehiculo::destroy($id);
        return redirect()->route('vehiculo.index');
    }
}