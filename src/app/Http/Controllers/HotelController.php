<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Zona;
use Illuminate\Http\Request;


class HotelController extends Controller{
    public function create(){
        $zonas = Zona::all();
        return view('admin.crearhotel', compact('zonas'));
    }
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:100',
            'usuario' => 'required|string|max:25|unique:transfer_hotel,usuario',
            'password' => 'required|min:4',
            'id_zona' => 'nullable|exists:transfer_zona,id_zona',
            'comision' => 'nullable|integer|min:0|max:100',
        ]);
        Hotel::create([
            'nombre' => $request->nombre,
            'usuario' => $request->usuario,
            'password' => bcrypt($request->password),
            'id_zona' => $request->id_zona,
            'comision' => $request->comision,
        ]);
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Hotel creado correctamente');
    }
}

?>