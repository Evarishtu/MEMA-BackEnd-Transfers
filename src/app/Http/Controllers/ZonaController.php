<?php

namespace App\Http\Controllers;

use App\Models\TransferZona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    public function index(){
        $zonas = TransferZona::orderBy('id_zona')->get();
        return view('zona.index', compact('zonas'));
    }

    public function create(){
        return view('zona.form');
    }
    public function store(Request $request){
        $request->validate([
            'descripcion'=>'required|max:500',
        ]);
        TransferZona::create([
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->route('zona.index')->with('success', 'Zona creada correctamente');
    }
    public function edit($id){
        $zona = TransferZona::findOrFail($id);
        return view('zona.form', compact('zona'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'descripcion' => 'required|max:500',
        ]);
        $zona = TransferZona::findOrFail($id);
        $zona->update([
            'descripcion' =>$request->descripcion,
        ]);
        return redirect()->route('zona.index')->with('success', 'Zona actualizada correctamente');
    }
    public function destroy($id)
    {
        TransferZona::destroy($id);

        return redirect()->route('zona.index')->with('success', 'Zona eliminada correctamente');
    }
}
