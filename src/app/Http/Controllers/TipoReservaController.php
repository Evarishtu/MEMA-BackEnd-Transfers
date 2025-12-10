<?php

namespace App\Http\Controllers;

use App\Models\TipoReserva;
use Illuminate\Http\Request;

class TipoReservaController extends Controller
{
    // Listar todos
    public function index()
    {
        $reservatipo = TipoReserva::orderBy('id_tipo_reserva', 'ASC')->get();
        return view('reservatipo.index', compact('reservatipo'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('reservatipo.form');
    }

    // Guardar nuevo
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255'
        ]);

        TipoReserva::create([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('reservatipo.index');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $reservatipo = TipoReserva::findOrFail($id);
        return view('reservatipo.form', compact('reservatipo'));
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255'
        ]);

        $reservatipo = TipoReserva::findOrFail($id);
        $reservatipo->update([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('reservatipo.index');
    }

    // Eliminar
    public function destroy($id)
    {
        TipoReserva::destroy($id);
        return redirect()->route('reservatipo.index');
    }
}
