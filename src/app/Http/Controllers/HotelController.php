<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HotelController extends Controller
{
    public function index()
    {
        $hoteles = Hotel::with('zona')->orderBy('id_hotel', 'ASC')->get();
        return view('hotel.index', compact('hoteles'));
    }

    public function create()
    {
        $zonas = Zona::orderBy('descripcion')->get();
        return view('hotel.form', compact('zonas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'id_zona' => 'required',
            'comision' => 'nullable|numeric',
            'usuario' => 'required',
            'password' => 'required'
        ]);

        Hotel::create([
            'id_zona' => $request->id_zona,
            'nombre' => $request->nombre,
            'comision' => $request->comision,
            'usuario' => $request->usuario,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('hotel.index');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        $zonas = Zona::orderBy('descripcion')->get();

        return view('hotel.form', compact('hotel', 'zonas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'id_zona' => 'required',
            'comision' => 'nullable|numeric',
            'usuario' => 'required'
        ]);

        $hotel = Hotel::findOrFail($id);

        $hotel->update([
            'nombre' => $request->nombre,
            'id_zona' => $request->id_zona,
            'comision' => $request->comision,
            'usuario' => $request->usuario,
            'password' => $request->password ? Hash::make($request->password) : $hotel->password
        ]);

        return redirect()->route('hotel.index');
    }

    public function destroy($id)
    {
        Hotel::destroy($id);
        return redirect()->route('hotel.index');
    }
}
