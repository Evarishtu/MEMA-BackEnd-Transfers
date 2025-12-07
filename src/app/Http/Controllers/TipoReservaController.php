<?php 
namespace App\Http\Controllers;

use App\Models\TransferTipoReserva;
use Illuminate\Http\Request;

class TipoReservaController extends Controller {
    public function index(){
        $reservas = TransferTipoReserva::orderBy('id_tipo_reserva')->get();
        return view ('reservatipo.index', compact('reservas'));
    }
    public function create(){
        return view('reservatipo.form');
    }
    public function store(Request $request){
        $request->validate([
            'descripcion' => 'required|max:500',
        ]);
        TransferTipoReserva::create([
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->route('reservatipo.index')->with('success', 'Tipo de reserva creado correctamente');
    }
    public function edit($id){
        $reservatipo = TransferTipoReserva::findOrFail($id);
        return view('reservatipo.form', compact('reservatipo'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'descripcion' => 'required|max:500',
        ]);
        $reservatipo = TransferTipoReserva::findOrFail($id);

        $reservatipo->update([
            'descripcion' => $request->descripcion,
        ]);
        return redirect()->route('reservatipo.index')->with('success', 'Tipo de reserva actualizado correctamente');
    }
    public function destroy($id){
        TransferTipoReserva::destroy($id);

        return redirect()->route('reservatipo.index')->with('success', 'Tipo de reserva eliminado correctamente');
    }
}
?>