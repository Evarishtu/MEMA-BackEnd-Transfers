<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Zona;
use Illuminate\Http\Request;


class HotelController extends Controller{

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
            'comision' => 'nullable|integer|min:0|max:100',
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
            'comision' => 'nullable|integer|min:0|max:100',
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